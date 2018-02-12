<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class MCard_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Card_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function find_post()
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
                    
                    // response failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{
                    
                    $c_card = $json['c_card'];
                    $i_card_type = $json['i_card_type'];

                    // action untuk data post format json
                    $data_post = array(
                        'c_card'        => $c_card,
                        'i_card_type'   => $i_card_type
                    );

                }

                // show data
                if($response = $this->Card_model->show($c_card, $i_card_type)){

                    if($response[0]->c_card == null){
                        // response success not found data
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_PARTIAL_CONTENT);
                    }else if(count($response) > 1){
                        //response success with data
                        $this->response([
                            'status' => true,
                            'data' => $response,
                            'jumlah_data' => count($response),
                            'message' => 'Data kembar ditemukan'
                        ], REST_Controller::HTTP_OK);
                    }else{
                        //response success with data
                        $this->response([
                            'status' => true,
                            'data' => $response,
                            'message' => 'Data ditemukan'
                        ], REST_Controller::HTTP_OK);
                    }
                }else{
                    // response failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Data tidak ditemukan'
                    ], REST_Controller::HTTP_PARTIAL_CONTENT);
                }
                 
            }else{
                // response unauthorized karena token invalid
                $this->response([
                    'status' => false,
                    'message' => 'Token invalid'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        }else{
            // response unauthorized karena token invalid
            $this->response([
                'status' => false,
                'message' => 'Token invalid'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}


/* End of file MCard_API.php */
