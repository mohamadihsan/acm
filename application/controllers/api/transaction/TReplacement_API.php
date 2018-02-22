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

                    // action untuk data post format json
                    $data_post = array(
                        'uid'           => $json['uid'],
                        'c_card'        => $json['c_card'],
                        'i_card_type'   => $json['i_card_type'],
                        'c_people'      => $json['c_people'],
                        'n_company'     => $json['n_company'],
                        'i_user'        => $i_user
                    );

                }

                // insert data macm.t_m_desc
                if($this->Replacement_model->insert($data_post)){
                    //respone success
                    $this->response([
                        'status' => true,
                        'data' => $data_post,
                        'message' => 'Penggantian Kartu berhasil'
                    ], REST_Controller::HTTP_ACCEPTED);

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
