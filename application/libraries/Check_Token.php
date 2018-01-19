<?php

require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class Check_Token extends CI_Controller {

    private $secret = 'access card management';

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('master/user_model');
        
    }

    private function validasi_token($token)
    {

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
                    return false;
                    
                }else{

                    // token valid dan masih berlaku 
                    return true;

                }
        
            }
            
        }catch(Exception $e){

            // Set the response 
            return false;

        }
    }

    public function token($token)
    {
        if ($this->validasi_token($token)) {
            //cek apakah user yang login sama dengan user token
            return true;
        }else{
            return false;
        }
    }

}
