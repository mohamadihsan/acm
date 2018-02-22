<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TRegistration_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction/Registration_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function registration_post()
    {
        // request header authorization
        $token = $this->input->get_request_header('Authorization');
        // jika ada header token
        if($token){        
            //cek validasi token
            if($this->token_validation->check($token)){
 
                // extract token
                $data_token = $this->token_validation->extract($token);
                $i_user = $data_token['i_user'];
                
                $json = json_decode(file_get_contents('php://input'), true);
                // cara mendeklarasikannya
                // echo $data['n_desc'];
                
                if (!$json) {
                    
                    // respone failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{

                    $uid           = $json['uid'];
                    $c_card        = $json['c_card'];
                    $i_card_type   = $json['i_card_type'];
                    $c_people      = $json['c_people'];
                    $n_company     = $json['n_company'];

                    // action untuk data post format json
                    $data_post = array(
                        'uid'           => $uid,
                        'c_card'        => $c_card,
                        'i_card_type'   => $i_card_type,
                        'c_people'      => $c_people,
                        'n_company'     => $n_company,
                        'i_user'        => $i_user
                    );

                }

                // insert data macm.t_m_desc
                if($response = $this->Registration_model->insert($uid, $c_card, $i_card_type, $c_people, $n_company, $i_user)){
                    
                    if($response[0]->c_status == 'f'){
                        // response success not found data
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Kartu sudah terdaftar'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);
                    }else if($response[0]->c_status == 't'){
                        //respone success
                        $this->response([
                            'status' => true,
                            'data' => $data_post,
                            'message' => 'Registrasi Kartu berhasil'
                        ], REST_Controller::HTTP_CREATED);
                    }else{
                        // response success not found data
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Proses registrasi gagal, cek kembali parameter yang anda masukkan!'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);
                    }
                    
                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Registrasi Kartu gagal'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);
                }
                 
            }else{
                // respone unauthorized karena token invalid
                $this->response([
                    'status' => false,
                    'message' => 'Token invalid'
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

/* End of file TRegistration_API.php */
