<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TDeletion_Card_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction/Deletion_Card_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function deletion_card_post()
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
                    
                    // respone failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{

                    // action untuk data post format json
                    $data_post = array(
                        'uid'               => $json['uid'],
                        'c_card'            => $json['c_card'],
                        'c_card_before'     => $json['c_card_before'],
                        'i_card_type'       => $json['i_card_type'],
                        'c_people'          => $json['c_people'],
                        'c_physical_card'   => $json['c_physical_card'],
                        'i_user'            => $json['i_user']
                    );

                }

                // insert data macm.t_m_desc
                if($this->Deletion_Card_model->insert($data_post)){
                    //respone success
                    $this->response([
                        'status' => true,
                        'data' => $data_post,
                        'message' => 'Kartu berhasil dihapus'
                    ], REST_Controller::HTTP_OK);

                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Kartu gagal dihapus'
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

/* End of file TDeletion_Card_API.php */
