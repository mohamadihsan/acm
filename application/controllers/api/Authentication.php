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
            $i_group            = $user[0]->i_group;

            // cek data apakah username terdaftar atau tidak 
            if (count($user) > 0) {
                
                // username terdaftar, cek password sesuai atau tidak 
                if (password_verify($password, $password_from_db)) {
                    
                    $data_login_active = array(
                        'i_user' => $i_user_from_db,
                        'b_active' => 't'
                    );

                    // validasi status active untuk aplikasi frontend
                    if ($terminal_id != '' OR $terminal_id != null) {
                        // cek apakah user sedang login / belum logout dari boot
                        $log = $this->User_model->check_login_active($data_login_active);
                        //exract data
                        $log2 = $log->result();

                        if($log->num_rows() > 0){

                            if (TRIM($log2[0]->terminal_id) != TRIM($terminal_id) AND TRIM($log2[0]->terminal_id) != null) {
                                
                                $output = array(
                                    'status' => false,
                                    'username' => $username_from_db,
                                    'message' => 'User sedang aktif di boot lain'
                                );
                                //user sedang aktif di boot lain/ belum melakukan logout
                                $this->response($output, REST_Controller::HTTP_FORBIDDEN);

                            }
                        }
                    }
                    
                    $iat        = date('Y-m-d H:i:s');
                    $expired    = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($iat)));
                    // set ip address
                    $ip_address = $this->input->ip_address();
                    if (!$this->input->valid_ip($ip_address)) {
                        $ip_address = null;
                    }
                    $c_login = date('YmdHis');

                    try{

                        // JWT
                        $payload['i_user']          =   $i_user_from_db;
                        $payload['i_group']         =   $i_group;
                        $payload['expired']         =   $expired;
                        $payload['terminal_id']     =   $terminal_id;
                        $payload['c_login']         =   $c_login;

                        $output['id_token']     =   JWT::encode($payload, $this->secret);
                        // $output['i_user']       =   $i_user_from_db;

                        // data login success
                        $data_login_success = array(
                            'c_login'           => $c_login,
                            'i_group'           => $i_group,
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
                        // $response = $this->db->query("SELECT * FROM macm.sp_get_timeserver()")->result();
                        // $e_code = $response[0]->time_server;

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
}
