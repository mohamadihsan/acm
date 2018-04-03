<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class MUser_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/User_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function register_user_post()
    {
        // request header authorization
        $token = $this->input->get_request_header('Authorization');
        // jika ada header token
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $json = json_decode(file_get_contents('php://input'), true);
                // cara mendeklarasikannya
                // echo $data['n_desc'];
                
                if (!$json) {
                    // response failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{

                    // action untuk data post format json
                    $username   = $json['username'];
                    $password   = password_hash($json['password'], PASSWORD_DEFAULT);
                    $i_group    = $json['i_group'];
                    $i_people   = $json['i_people'];

                    $data_post = array(
                        'username' => $username,
                        'password' => $password,
                        'i_group' => $i_group,
                        'i_people' => $i_people,
                        'b_active' => 't' 
                    );

                }

                // show data
                if($this->User_model->register($data_post) == true ){

                    //response success with data
                    $this->response([
                        'status' => true,
                        'message' => 'Akun telah berhasil dibuat'
                    ], REST_Controller::HTTP_OK);
                    
                }else{
                    // response failed
                    $this->response([
                        'status' => false,
                        'data' => ["username" => $username],
                        'message' => 'Username sudah digunakan'
                    ], REST_Controller::HTTP_PARTIAL_CONTENT);
                }
                 
            }else{
                // response unauthorized karena token invalid
                $this->response([
                    'status' => false,
                    'message' => 'Token invalid'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        }else{
            // response unauthorized karena token invalid
            $this->response([
                'status' => false,
                'message' => 'Token invalid'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function reset_password_post()
    {
        // request header authorization
        $token = $this->input->get_request_header('Authorization');
        // jika ada header token
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $json = json_decode(file_get_contents('php://input'), true);
                // cara mendeklarasikannya
                // echo $data['n_desc'];
                
                if (!$json) {
                    
                    // response failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{

                    // action untuk data post format json
                    $email      = $json['email'];
                    
                    $data_post = array(
                        'email' => $email
                    );

                }

                // show data
                if($this->User_model->reset_passwrod($data_post)){

                    //response success with data
                    $this->response([
                        'status' => true,
                        'message' => 'Link reset password sudah dikirim melalui email'
                    ], REST_Controller::HTTP_OK);
                    
                }else{
                    // response failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Email tidak terdaftar, silahkan hubungi admin'
                    ], REST_Controller::HTTP_PARTIAL_CONTENT);
                }
                 
            }else{
                // response unauthorized karena token invalid
                $this->response([
                    'status' => false,
                    'message' => 'Token invalid'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        }else{
            // response unauthorized karena token invalid
            $this->response([
                'status' => false,
                'message' => 'Token invalid'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}

/* End of file MUser_API.php */
