<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class MPeople_API extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/People_model');
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
                    
                    // respone failed
                    $this->response([
                        'status' => false,
                        'message' => 'Format data yang dikirim harus json array'
                    ], REST_Controller::HTTP_NOT_ACCEPTABLE);

                }else{

                    // action untuk data post format json
                    $c_people      = $json['c_people'];
                    $type_people   = $json['type_people'];
                    $data_post = array(
                        'c_people' => $c_people,
                        'type_people' => $type_people 
                    );

                }

                // insert data macm.t_m_desc
                if($response = $this->People_model->show($c_people, $type_people)){

                    if($response[0]->c_people == null){
                        // response success not found data
                        $this->response([
                            'status' => true,
                            'data' => $data_post,
                            'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_NO_CONTENT);
                    }else{
                        //respone success with data
                        $this->response([
                            'status' => true,
                            'data' => $response,
                            'message' => 'Data ditemukan'
                        ], REST_Controller::HTTP_OK);
                    }
                    
                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Data tidak ditemukan'
                    ], REST_Controller::HTTP_NO_CONTENT);
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

/* End of file MPeople_API.php */
