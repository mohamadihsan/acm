<?php
require APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;
class Token_Validation {

    private $secret = 'access card management';

    private function check_token($token)
    {

        try{

            $decode = JWT::decode($token, $this->secret, array('HS256'));
            
            // retrieve tanggal expired dari token
            $token_expired = $decode->expired;
            
            $CI =& get_instance();
            
            // get time server
            $CI->load->database();
            $response = $CI->db->query("SELECT * FROM macm.sp_get_timeserver()")->result();
            $time_server = $response[0]->time_server;
            // $time_server = date('Y-m-d H:i:s');

            // cek apakah token masih berlaku atau sudah expired
            if ($token_expired < $time_server) {
                
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

    private function extract_token($token)
    {

        try{

            $decode = JWT::decode($token, $this->secret, array('HS256'));
            
            // retrieve tanggal expired dari token
            $token_expired = $decode->expired;
            
            // get time server
            $CI =& get_instance();
            
            // get time server
            $CI->load->database();
            $response = $CI->db->query("SELECT * FROM macm.sp_get_timeserver()")->result();
            $time_server = $response[0]->time_server;
            // $time_server = date('Y-m-d H:i:s');

            // cek apakah token masih berlaku atau sudah expired
            if ($token_expired < $time_server) {
                
                //token expired
                $data = array(
                    'status'=> false, 
                    'pesan' => 'token telah kadaluarsa'
                );

                return json_encode($data);

            }else{
                
                // token masih berlaku
                $data = array(
                    'status'=> true, 
                    'i_group_access' => $decode->i_group_access,
                    'i_user' => $decode->i_user,
                    'c_login' => $decode->c_login,
                    'terminal_id' => $decode->terminal_id,
                    'expired' => $decode->expired 
                );

                return $data;
            }
            
        }catch(Exception $e){
            $data = array(
                'status'=> false,
                'pesan' => 'terjadi error saat memproses data' 
            );
            // kesalahan dalam memproses
            return json_encode($data);
        }
    }

    public function check($token)
    {
        if($this->check_token($token)) {
            //cek apakah user yang login sama dengan user token
            return true;
        }
    }

    public function extract($token)
    {
        return $this->extract_token($token);
    }
}

/* End of file Token_Validation.php */

