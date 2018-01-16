<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class User_Authentication extends REST_Controller {

    private $secret = 'access card management';

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
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
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        } else {
            
            // cek data user
            $username = 'ihsan';
            $password = '12345';
           
            $data_post = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password') 
            );  

            if ($data_post['username'] == $username && $data_post['password'] == $password) {

                $date = new DateTime();

                // JWT
                $payload['username']    =   $data_post['username'];
                $payload['password']    =   $data_post['password'];
                $payload['d_insert']    =   $date->getTimestamp();
                $payload['expired']     =   $date->getTimestamp() + 60 * 60 * 5;

                $output['id_token']     =   JWT::encode($payload, $this->secret);

                // Set the response 
                $this->response($output, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            
            }else if($data_post['username'] != $username && $data_post['password'] == $password){
               
                // Set the response 
                $this->response([
                    'status' => FALSE,
                    'message' => 'Username yang anda masukkan salah'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
           
            }else if($data_post['username'] == $username && $data_post['password'] != $password){
                
                // Set the response 
                $this->response([
                    'status' => FALSE,
                    'message' => 'Password yang anda masukkan salah'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
            }else{
                
                // Set the response 
                $this->response([
                    'status' => FALSE,
                    'message' => 'Account tidak terdaftar'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
            }
            
        }
       
    }

    public function check_token()
    {

        $jwt = $this->input->get_request_header('Authorization');

        try{

            $decode = JWT::decode($jwt, $this->secret, array('HS256'));

            return $decode->username;
            
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
        if ($this->check_token()) {
            //cek apakah user yang login sama dengan user token

            return true;
        }
    }

}
