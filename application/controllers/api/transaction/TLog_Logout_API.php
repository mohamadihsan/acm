<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TLog_Logout_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/User_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function logout_get()
    {
        // request header authorization
        $token = $this->input->get_request_header('Authorization');

        // request from web with session token
        if($token == null){
            $token = $this->session->userdata('id_token');
        }

        // jika ada header token
        if($token){
             
            //cek validasi token
            if($this->token_validation->check($token)){
                
                // extract token 
                $extract = $this->token_validation->extract($token);
                
                // set variable
                $i_user = $extract['i_user'];
                $c_login = $extract['c_login'];
                $terminal_id = $extract['terminal_id'];
                $i_group_access = $extract['i_group_access'];



                // $i_user = $json->i_user;
                // $c_login = $json->c_login;
                // $terminal_id = $json->terminal_id;
                // $i_group_access = $json->i_group_access;
                // set ip address
                $ip_address = $this->input->ip_address();
                if (!$this->input->valid_ip($ip_address)) {
                    $ip_address = null;
                }

                //clear status login active true menjadi false
                $count_clear = $this->User_model->clear_data_login($i_user);
                if ($count_clear > 0) {
                    
                    $data = array(
                        'i_user' => $i_user,
                        'i_group_access' => $i_group_access,
                        'c_login' => $c_login,
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
                            'i_user' => $i_user,
                            'terminal_id' => $terminal_id,
                            'message' => 'Anda telah berhasil logout tetapi status login belum dibersihkan'
                        ], REST_Controller::HTTP_PARTIAL_CONTENT);
                    }
                    
                    // respone success logout 
                    $this->response([
                        'status' => true,
                        'i_user' => $i_user,
                        'terminal_id' => $terminal_id,
                        'message' => 'Anda telah berhasil logout'
                    ], REST_Controller::HTTP_OK);
                }else{
                    // clear data login failed & logout success
                    $this->response([
                        'status' => false,
                        'i_user' => $i_user,
                        'terminal_id' => $terminal_id,
                        'message' => 'Anda telah berhasil logout '
                    ], REST_Controller::HTTP_OK);
                }
            
            }else{
                // respone unauthorized karena token invalid
                $this->response([
                    'status' => false,
                    'message' => 'Proses Logout gagal! Token invalid'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        }else{
            // respone unauthorized karena token invalid
            $this->response([
                'status' => false,
                'message' => 'Token invalid'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }            
    }

}

/* End of file TDeletion_Card_API.php */
