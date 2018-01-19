<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Authentication extends CI_Controller {

    var $API ="";

    public function __construct()
    {
        parent::__construct();
        // path API
        $this->API = base_url();
        //Load Dependencies
        $this->load->library('curl');
        $this->load->library('token_validation');

    }

    // List all your items
    public function index( $offset = 0 )
    {
        if ($this->session->userdata('id_token')) {
            // get session token
            $token = $this->session->userdata('id_token');
            
            //cek masa berlaku token
            if($this->token_validation->check($token)){
                
                //token masih berlaku
                
            }else{
                //token expired
                $this->session->unset_userdata('id_token');
                
                redirect(base_url(),'refresh');
            }
        }else{
            // load from login
            $this->load->template('login/v_form_login');
        }
    }

    // verifikasi user
    public function verify()
    {
        if(isset($_POST['login'])){
            
            $data = array(
                'username'  =>  $this->input->post('username'),
                'password'  =>  $this->input->post('password'));
            
            // post data ke API
            $login =  $this->curl->simple_post($this->API.'api/user_auth/login', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            
            // cek apakah data login benar atau salah
            if($login){
                // data login benar
                // retrieve data from json
                $json = json_decode($login);
                $id_token = $json->id_token;
                $session_data = array('id_token' => $id_token );

                // set session token
                $this->session->set_userdata($session_data);
                
                // set flash data
                $this->session->set_flashdata('hasil','Insert Data Berhasil');
                redirect(base_url().'home');
            }else{
                // data login salah
                //set flash data
                $this->session->set_flashdata('hasil','Insert Data Gagal');
                redirect(base_url());
            }

        }else{
            // request method tidak sesuai
            redirect(base_url());
        }
    }
}

/* End of file User_Authentication.php */

