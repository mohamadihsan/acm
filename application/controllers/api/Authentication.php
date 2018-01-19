<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class Authentication extends REST_Controller {

    private $secret = 'access card management';

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('master/user_model');
        
    }

    public function login_post()
    {
        // validasi
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[20]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            
            // Set response 
            $this->response([
                'status' => FALSE,
                'message' => 'Form isian tidak diisi dengan benar'
            ], REST_Controller::HTTP_PAYMENT_REQUIRED); // inputan ada yang tidak valid

        } else {

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $data_post = array(
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT) 
            );

            // cek data user
            if($user = $this->user_model->show($data_post)->result()){
                
                $i_user_from_db     = $user[0]->i_user;
                $username_from_db   = $user[0]->username;
                $password_from_db   = $user[0]->password;
                $i_group_access     = $user[0]->i_group_access;

                // cek data apakah username terdaftar atau tidak 
                if (count($user) > 0) {
                    
                    // username terdaftar, cek password sesuai atau tidak 
                    if (password_verify($password, $password_from_db)) {
                        
                        $iat        = date('Y-m-d H:i:s');
                        $expired    = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($iat)));

                        // JWT
                        $payload['i_user']          =   $i_user_from_db;
                        $payload['username']        =   $username_from_db;
                        $payload['password']        =   $password_from_db;
                        $payload['i_group_access']  =   $i_group_access;
                        $payload['d_insert']        =   $iat;
                        $payload['expired']         =   $expired;

                        $output['id_token']     =   JWT::encode($payload, $this->secret);

                        // create session token
                        // $session_data = array(
                        //     'id_token' => $output['id_token']
                        // );
                        
                        // $this->session->set_userdata($session_data);
                    
                        try{

                            // set ip address
                            $ip_address = $this->input->ip_address();
                            if (!$this->input->valid_ip($ip_address)) {
                                $ip_address = null;
                            }

                            // data login success
                            $data_login_success = array(
                                'i_login'           => 1,
                                'c_login'           => 'DUMMYCARD',
                                'i_group_access'    => $i_group_access,
                                'i_user'            => $i_user_from_db,
                                'ip_address'        => $ip_address,
                                'id_token'          => $output['id_token'],
                                'iat'               => $iat,
                                'expired'           => $expired
                            );

                            // insert into tacm.t_d_login
                            $this->user_model->insert_login_success($data_login_success);

                        }catch(Exception $e){
                            
                            // error
                            $output['error']  = $e;
                        
                        }    

                        // Set the response 
                        $this->response($output, REST_Controller::HTTP_OK); // user valid

                    }else{

                        // Set the response 
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Password yang dimasukkan salah'
                        ], REST_Controller::HTTP_UNAUTHORIZED); // data user tidak valid

                    }

                }
                
            }else{

                // Set the response 
                $this->response([
                    'status' => FALSE,
                    'message' => 'Username atau Password yang dimasukkan salah'
                ], REST_Controller::HTTP_UNAUTHORIZED); // data user tidak valid
            
            }
            
        }
       
    }

    public function check_token_get()
    {

        // retrieve token
        if($token = $this->input->get_request_header('Authorization')){
            // from header
        }else if($this->session->userdata('id_token')== null){
            // jika menggunakan session
            $token = $this->session->userdata('id_token');
        }else{
            // set token null
            $token = null;
        }

        try{

            $decode = JWT::decode($token, $this->secret, array('HS256'));
            
            // retrieve i_user dari token
            $i_user = $decode->i_user;

            // cocokan token dan expired token
            if($valid = $this->user_model->token_validation($i_user)->result()){
                
                // tanggal expired dari tacm.t_d_login
                $token_expired = $valid[0]->expired;

                // cek apakah token masih berlaku atau sudah expired
                if ($token_expired < date('Y-m-d H:i:s')) {
                    
                    // token expired
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Token sudah expired'
                    ], REST_Controller::HTTP_UNAUTHORIZED); // token expired

                }else{

                    // Set the response 
                    $this->response([
                        'status' => true,
                        'message' => 'Token valid'
                    ], REST_Controller::HTTP_OK); // token valid

                }
        
            }
            
        }catch(Exception $e){

            // Set the response 
            $this->response([
                'status' => FALSE,
                'message' => 'Token invalid'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }
    }

    public function protected_method()
    {
        if ($this->check_token_get()) {
            //cek apakah user yang login sama dengan user token

            return true;
        }
    }

}
