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
        $this->load->library('Token_Validation');
        $this->load->model('master/User_model');

    }

    // List all your items
    public function index()
    {
        if ($this->session->userdata('id_token')) {
            // get session token
            $token = $this->session->userdata('id_token');
            
            //cek masa berlaku token
            if($this->token_validation->check($token)){
                
                $data['title'] = 'Dashboard';
                //token masih berlaku
                $this->load->template('dashboard/v_dashboard', $data);
                
            }else{
                //token expired
                $this->session->unset_userdata('id_token');
                
                redirect(base_url(),'refresh');
            }
        }else{
            // load from login
            $this->load->view('login/v_form_login');
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
            }else{
                // data login salah
                //set flash data
                $this->session->set_flashdata('hasil','Insert Data Gagal');
            }
            
            //redirect
            redirect(site_url());

        }else{
            // request method tidak sesuai
            redirect(site_url());
        }
    }

    public function logout()
    {
       
        // get session token
        $token = $this->session->userdata('id_token');
        
        //cek masa berlaku token
        if($this->token_validation->check($token)){
            
            // extract token 
            $extract = $this->token_validation->extract($token);
            $json = json_decode($extract);
            // set variable
            $i_user = $json->i_user;
            $i_group_access = $json->i_group_access;
            // set ip address
            $ip_address = $this->input->ip_address();
            if (!$this->input->valid_ip($ip_address)) {
                $ip_address = null;
            }
            
            // clear session
            if(!$this->session->unset_userdata('id_token')){
                
                $data = array(
                    'i_user' => $i_user,
                    'i_group_access' => $i_group_access,
                    'ip_address' => $ip_address
                );
                
                try{
                    // non sktifkan status login
                    $this->User_model->clear_data_login($i_user);
                    // insert data logout
                    $this->User_model->insert_data_logout($data);
                }catch(Exception $e){
                    // gagal menyimpan data logout
                    redirect(site_url());
                }
                
                // session telah berhasil di bersihkan
                redirect(site_url());
                
            }else{
                // gagal unset session token
                redirect(site_url());
            }

        }else{
            // token tidak valid atau tidak ada session token
            redirect(site_url());
        }
    }
}

/* End of file User_Authentication.php */

