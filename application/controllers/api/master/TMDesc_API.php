<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TMDesc_API extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Desc_model');
        $this->load->library('Token_Validation');
        
    }
    
    public function desc_insert_post()
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
                    
                    // action untuk data post form input
                    // validasi
                    $this->form_validation->set_rules('i_card_type', 'Type Kartu', 'trim');
                    $this->form_validation->set_rules('c_desc', 'Kode Deskripsi', 'trim|required|min_length[1]|max_length[2]');
                    $this->form_validation->set_rules('n_desc', 'Deskripsi', 'trim|min_length[2]|max_length[50]');

                    if ($this->form_validation->run() === false) {
                        
                        // Set response 
                        $this->response([
                            'status' => false,
                            'message' => 'Parameter tidak diisi dengan benar'
                        ], REST_Controller::HTTP_PAYMENT_REQUIRED); // parameter tidak valid

                    }

                    // retrieve data post
                    $data_post = array(
                        'i_card_type'   => $this->input->post('i_card_type'),
                        'c_desc'        => $this->input->post('c_desc'),
                        'n_desc'        => $this->input->post('n_desc')
                    );
                    
                }else{

                    // action untuk data post format json
                    $data_post = array(
                        'i_card_type'   => $json['i_card_type'],
                        'c_desc'        => $json['c_desc'],
                        'n_desc'        => $json['n_desc']
                    );

                }

                // insert data macm.t_m_desc
                if($this->Desc_model->insert($data_post)){
                    //respone success
                    $this->response([
                        'status' => true,
                        'data' => $data_post,
                        'message' => 'Data berhasil disimpan'
                    ], REST_Controller::HTTP_CREATED);

                }else{
                    // respone failed
                    $this->response([
                        'status' => false,
                        'data' => $data_post,
                        'message' => 'Gagal menyimpan data'
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

    public function desc_update_put()
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
                    
                    // action untuk data post form input
                    // validasi
                    $this->form_validation->set_rules('i_card_type', 'Type Kartu', 'trim');
                    $this->form_validation->set_rules('c_desc', 'Kode Deskripsi', 'trim|required|min_length[1]|max_length[2]');
                    $this->form_validation->set_rules('n_desc', 'Deskripsi', 'trim|min_length[2]|max_length[50]');

                    if ($this->form_validation->run() === false) {
                        
                        // Set response 
                        $this->response([
                            'status' => false,
                            'message' => 'Parameter tidak diisi dengan benar'
                        ], REST_Controller::HTTP_PAYMENT_REQUIRED); // parameter tidak valid

                    }

                    // retrieve data post
                    $data_post = array(
                        'i_card_type'   => $this->input->post('i_card_type'),
                        'c_desc'        => $this->input->post('c_desc'),
                        'n_desc'        => $this->input->post('n_desc')
                    );
                    
                }else{

                    // action untuk data post format json
                    $data_post = array(
                        'i_card_type'   => $json['i_card_type'],
                        'c_desc'        => $json['c_desc'],
                        'n_desc'        => $json['n_desc']
                    );

                }

                //cek id yang akan diupdate
                $id = $this->uri->segment(4);

                if ($id != '' OR $id == null) {
                    
                    // insert data macm.t_m_desc
                    $count_update = $this->Desc_model->update($id, $data_post);

                    return $count_update;
                    if ($count_update > 0) {
                        //respone success
                        $this->response([
                            'status' => true,
                            'data' => $data_post,
                            'message' => 'Data berhasil diupdate'
                        ], REST_Controller::HTTP_OK);

                    }else{
                        // respone failed
                        $this->response([
                            'status' => false,
                            'data' => $data_post,
                            'message' => 'Gagal mengupdate data'
                        ], REST_Controller::HTTP_NOT_MODIFIED);
                    }
                    
                }else{
                    // Set the response and exit
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
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
        };
        
    }

    public function desc_softdelete_delete()
    {
        
        // request header authorization
        $token = $this->input->get_request_header('Authorization');
        // jika ada header token
        if($token){
            //cek validasi token
            if($this->token_validation->check($token)){
                
                //cek id yang akan dihapus
                $id = $this->uri->segment(4);

                if ($id != '' OR $id == null) {
                    
                    //lakukan sof delete
                    $count_delete = $this->Desc_model->soft_delete($id);
                    if ($count_delete > 0) {
                        // data berhasil di soft delete
                        $message = [
                            'status' => true,
                            'id' => $id,
                            'message' => 'Data telah berhasil dihapus'
                        ];
                        $this->set_response($message, REST_Controller::HTTP_OK); 
    
                    }else{
                        // tidak ada data yang di soft delete
                        $message = [
                            'status' => true,
                            'message' => 'data dengan id '.$id.' tidak ditemukan'
                        ];
                        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    
                    }

                }else{
                    // Set the response and exit
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
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

/* End of file TMDesc_API.php */
