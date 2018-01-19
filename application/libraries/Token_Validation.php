<?php
require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;
class Token_validation {

    private $secret = 'access card management';

    private function check_token($token)
    {

        try{

            $decode = JWT::decode($token, $this->secret, array('HS256'));
            
            // retrieve tanggal expired dari token
            $token_expired = $decode->expired;

            // cek apakah token masih berlaku atau sudah expired
            if ($token_expired < date('Y-m-d H:i:s')) {
                
                //token expired
                return false;
            }else{
                
                // token masih berlaku
                return true;
            }
            
        }catch(Exception $e){
            
            // kesalahan dalam memproses
            return false;
        }
    }

    public function check($token)
    {
        if($this->check_token($token)) {
            //cek apakah user yang login sama dengan user token
            return true;
        }
    }

}

/* End of file Token_Validation.php */

