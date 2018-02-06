<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TUpdate_Card_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction/Update_Card_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function update_card_post()
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
                        'uid'           => $json['uid'],
                        'c_card'        => $json['c_card'],
                        'i_card_type'   => $json['i_card_type'],
                        'c_people'      => $json['c_people'],
                        'i_user'        => $json['i_user']
                    );

                }

                // insert data macm.t_m_desc
                if($this->Update_Card_model->insert($data_post)){
                    //respone success
                    $this->response([
                        'status' => true,
                        'data' => $data_post,
                        'message' => 'Update Kartu berhasil'
                    ], REST_Controller::HTTP_OK);

                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Update Kartu gagal'
                    ], REST_Controller::HTTP_NOT_MODIFIED);
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

/* End of file TUpdate_Card_API.php */
