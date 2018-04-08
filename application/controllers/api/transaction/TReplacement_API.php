<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TReplacement_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction/Replacement_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function check_replacement_post()
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

                    $uid                = $json['uid'];
                    $c_card_before      = $json['c_card_before'];
                    $c_card             = $json['c_card'];
                    $i_card_type        = $json['i_card_type'];
                    $c_people           = $json['c_people'];
                    $c_company          = $json['c_company'];
                    $c_physical_card    = $json['c_physical_card'];

                    // action untuk data post format json
                    $data_post = array(
                        'uid'               => $uid,
                        'c_card_before'     => $c_card_before,
                        'c_card'            => $c_card,
                        'i_card_type'       => $i_card_type,
                        'c_people'          => $c_people,
                        'c_company'         => $c_company,
                        'c_physical_card'   => $c_physical_card,
                        'i_user'            => $i_user
                    );

                }

                // insert data macm.t_m_desc
                if($response = $this->Replacement_model->check($uid, $c_card_before, $c_card, $i_card_type, $c_people, $c_company, $i_user, $c_physical_card)){
                    
                    
                    if($response[0]->c_status == 'f' && $response[0]->c_desc == 'RF'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $response,
                            'message' => 'Kartu sudah terdaftar sebelumnya'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else if($response[0]->c_status == 'f' && $response[0]->c_desc == 'NP'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $response,
                            'message' => 'Kartu sebelumnya tidak cocok dengan pemegang kartu'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else if($response[0]->c_status == 'f' && $response[0]->c_desc == 'RS'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $response,
                            'message' => 'Kartu sudah tercatat dalam proses replacement'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else{

                        //respone success process but failed replacement
                        $this->response([
                            'status' => true,
                            'data' => $response,
                            'message' => 'Data Valid'
                        ], REST_Controller::HTTP_ACCEPTED);

                    }

                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Penggantian Kartu gagal'
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

    public function replacement_post()
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

                    $uid                = $json['uid'];
                    $c_card_before      = $json['c_card_before'];
                    $c_card             = $json['c_card'];
                    $i_card_type        = $json['i_card_type'];
                    $c_people           = $json['c_people'];
                    $c_company          = $json['c_company'];
                    $c_physical_card    = $json['c_physical_card'];

                    // action untuk data post format json
                    $data_post = array(
                        'uid'               => $uid,
                        'c_card_before'     => $c_card_before,
                        'c_card'            => $c_card,
                        'i_card_type'       => $i_card_type,
                        'c_people'          => $c_people,
                        'c_company'         => $c_company,
                        'c_physical_card'   => $c_physical_card,
                        'i_user'            => $i_user
                    );

                }

                // insert data macm.t_m_desc
                if($response = $this->Replacement_model->insert($uid, $c_card_before, $c_card, $i_card_type, $c_people, $c_company, $i_user, $c_physical_card)){
                    
                    
                    if($response[0]->c_status == 'f' && $response[0]->c_desc == 'RF'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Kartu sudah terdaftar sebelumnya'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else if($response[0]->c_status == 'f' && $response[0]->c_desc == 'NP'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Kartu sebelumnya tidak cocok dengan pemegang kartu'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else if($response[0]->c_status == 'f' && $response[0]->c_desc == 'RS'){
                        
                        //respone success
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Kartu sudah tercatat dalam proses replacement'
                        ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                    }else{

                        //respone success process but failed replacement
                        $this->response([
                            'status' => true,
                            'data' => $data_post,
                            'message' => 'Penggantian Kartu berhasil'
                        ], REST_Controller::HTTP_ACCEPTED);

                    }

                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Penggantian Kartu gagal'
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

/* End of file TReplacement_API.php */
