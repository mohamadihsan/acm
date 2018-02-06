<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class Authentication extends REST_Controller {

    private $secret = 'access card management';
    // $secret = JWT::secret();

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('master/User_model');

    }

    public function login_post()
    {
        $json = json_decode(file_get_contents('php://input'), true);
        // cara mendeklarasikannya
        // echo $data['n_desc'];
        
        if (!$json) {
            
            // action untuk data post form input
            
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $terminal_id = $this->input->post('terminal_id');

            // validasi
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[20]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() === false) {
                
                // Set response 
                $this->response([
                    'status' => false,
                    'message' => 'Form isian tidak diisi dengan benar'
                ], REST_Controller::HTTP_PAYMENT_REQUIRED); // inputan ada yang tidak valid

            }
            
        }else{

            // action untuk data post format json

            $username = $json['username'];
            $password = $json['password'];
            $terminal_id = $json['terminal_id'];

        }

        // retrieve data post
        $data_post = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT) 
        );

        // cek data user
        if($user = $this->User_model->show($data_post)->result()){
            
            $i_user_from_db     = $user[0]->i_user;
            $username_from_db   = $user[0]->username;
            $password_from_db   = $user[0]->password;
            $i_group_access     = $user[0]->i_group_access;

            // cek data apakah username terdaftar atau tidak 
            if (count($user) > 0) {
                
                // username terdaftar, cek password sesuai atau tidak 
                if (password_verify($password, $password_from_db)) {
                    
                    $data_login_active = array(
                        'i_user' => $i_user_from_db,
                        'b_active' => 't'
                    );
                    // cek apakah user sedang login / belum logout dari boot
                    $log = $this->User_model->check_login_active($data_login_active);
                    //exract data
                    $log2 = $log->result();

                    if($log->num_rows() > 0){

                        if (TRIM($log2[0]->terminal_id) != TRIM($terminal_id)) {
                            
                            $output = array(
                                'status' => false,
                                'username' => $username_from_db,
                                'message' => 'User sedang aktif di boot lain'
                            );
                            //user sedang aktif di boot lain/ belum melakukan logout
                            $this->response($output, REST_Controller::HTTP_FORBIDDEN);

                        }
                    }

                    $iat        = date('Y-m-d H:i:s');
                    $expired    = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($iat)));
                    // set ip address
                    $ip_address = $this->input->ip_address();
                    if (!$this->input->valid_ip($ip_address)) {
                        $ip_address = null;
                    }

                    try{

                        // JWT
                        $payload['i_user']          =   $i_user_from_db;
                        $payload['username']        =   $username_from_db;
                        $payload['password']        =   $password_from_db;
                        $payload['i_group_access']  =   $i_group_access;
                        $payload['d_insert']        =   $iat;
                        $payload['expired']         =   $expired;
                        $payload['terminal_id']     =   $terminal_id;
                        $payload['c_login']         =   $log2[0]->c_login;

                        $output['id_token']     =   JWT::encode($payload, $this->secret);

                        // data login success
                        $data_login_success = array(
                            'c_login'           => date('YmdHis'),
                            'i_group_access'    => $i_group_access,
                            'i_user'            => $i_user_from_db,
                            'ip_address'        => $ip_address,
                            'id_token'          => $output['id_token'],
                            'iat'               => $iat,
                            'expired'           => $expired,
                            'terminal_id'       => $terminal_id
                        );

                        // insert into tacm.t_d_login
                        if($this->User_model->insert_login_success($data_login_success)){
                            $i_login = $this->db->insert_id();
                        }else{
                            $i_login = null;
                        }

                        // data log login success
                        $data_login = array(
                            'e_code'            => date('YmdHis'),
                            'username'          => $username,
                            'ip_address'        => $ip_address,
                            'c_status'          => '1',
                            'terminal_id'       => $terminal_id
                        );

                        // insert into tacm.t_d_login
                        $this->User_model->insert_log_login($data_login);

                    }catch(Exception $e){
                        
                        // error
                        $output['error']  = 'gagal menyimpan data transaksi login';
                    
                    }    

                    // Set the response 
                    $this->response($output, REST_Controller::HTTP_OK); // user valid

                }else{
                    
                    // data log login failed
                    $data_login = array(
                        'e_code'            => date('YmdHis'),
                        'username'          => $username,
                        'ip_address'        => $ip_address,
                        'c_status'          => '0'
                    );

                    // insert into tacm.t_d_login
                    $this->User_model->insert_log_login($data_login);

                    // Set the response 
                    $this->response([
                        'status' => false,
                        'message' => 'Password yang dimasukkan salah'
                    ], REST_Controller::HTTP_UNAUTHORIZED); // data user tidak valid

                }

            }
            
        }else{

            // Set the response 
            $this->response([
                'status' => false,
                'message' => 'Username atau Password yang dimasukkan salah'
            ], REST_Controller::HTTP_UNAUTHORIZED); // data user tidak valid
        
        } 
    }

    public function logout_get()
    {
        $id = $this->uri->segment(3);
        $terminal_id = $this->uri->segment(4);
        // set ip address
        $ip_address = $this->input->ip_address();
        if (!$this->input->valid_ip($ip_address)) {
            $ip_address = null;
        }
        
        if ($id != '' OR $id != null) {
            //clear status login active true menjadi false
            $count_clear = $this->User_model->clear_data_login($id);
            if ($count_clear > 0) {
                
                $data = array(
                    'i_user' => $id,
                    'terminal_id' => $terminal_id,
                    'ip_address' => $ip_address
                );
                
                // clear data login & logout success
                try{
                    $this->User_model->insert_data_logout($data);
                }catch(Exception $e){
                    //respone gagl non aktifkan status login
                    // respone success logout 
                    $this->response([
                        'status' => true,
                        'i_user' => $id,
                        'terminal_id' => $terminal_id,
                        'message' => 'Anda telah berhasil logout tetapi status login belum dibersihkan'
                    ], REST_Controller::HTTP_NO_CONTENT);
                }
                
                // respone success logout 
                $this->response([
                    'status' => true,
                    'i_user' => $id,
                    'terminal_id' => $terminal_id,
                    'message' => 'Anda telah berhasil logout'
                ], REST_Controller::HTTP_OK);
            }

            // clear data login failed & logout success
            $this->response([
                'status' => true,
                'i_user' => $id,
                'terminal_id' => $terminal_id,
                'message' => 'Anda telah berhasil logout'
            ], REST_Controller::HTTP_OK);
        }

        $this->response([
            'status' => true,
            'message' => 'Bad Request'
        ], REST_Controller::HTTP_BAD_REQUEST);
        
    }
}
