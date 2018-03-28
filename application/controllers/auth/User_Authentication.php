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
                
                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];
                
                // parameter
                $param = array('i_group' => $i_group_from_token );

                $data_role = $this->User_model->show_user_role($param)->result();
                $group = $data_role[0]->n_group;
                
                // rediret route based on user role
                switch ($group) {
                    case 'admin':
                        
                        $data['title'] = 'Dashboard';
                        //token masih berlaku
                        // $this->load->template('dashboard/v_dashboard', $data);
                        redirect(site_url('dashboard'),'refresh');
                    
                        break;
                    
                    case 'GCG':
                        # code...
                        break;
                    
                    case 'penjualan':
                        # code...
                        break;

                    default:
                        redirect(site_url('login'));
                        break;
                }
                
            }else{
                //token expired
                $this->session->unset_userdata('id_token');
                
                redirect(site_url('login'),'refresh');
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
                $this->session->set_flashdata('login_success','Welcome to ACMS');

            }else{
                // data login salah
                //set flash data
                $this->session->set_flashdata('login_failed','Username & Password wrong!');
            }
            
            //redirect
            redirect(site_url('login'));

        }else{
            $this->session->set_flashdata('login_failed','Please enter button LOGIN!');
            // request method tidak sesuai
            redirect(site_url('login'));
        }
    }

    public function logout()
    {
        

        // get session token
        $token = $this->session->userdata('id_token');

        // jika ada header token
        if($token){
             
            //cek validasi token
            if($this->token_validation->check($token)){
                
                // extract token 
                $extract = $this->token_validation->extract($token);
                
                // set variable
                $i_user = $extract['i_user'];
                $c_login = $extract['c_login'];
                $terminal_id = $extract['terminal_id'];
                $i_group = $extract['i_group'];

                $ip_address = $this->input->ip_address();
                if (!$this->input->valid_ip($ip_address)) {
                    $ip_address = null;
                }

                // clear session
                if(!$this->session->unset_userdata('id_token')){
                    
                    $data = array(
                        'i_user' => $i_user,
                        'i_group' => $i_group,
                        'ip_address' => $ip_address
                    );
                    
                    try{
                        
                        //clear status login active true menjadi false
                        $count_clear = $this->User_model->clear_data_login($i_user);
                        if ($count_clear > 0) {
                            
                            $data = array(
                                'i_user' => $i_user,
                                'i_group' => $i_group,
                                'c_login' => $c_login,
                                'terminal_id' => $terminal_id,
                                'ip_address' => $ip_address
                            );
                            
                            // clear data login & logout success
                            try{
                                $this->User_model->insert_data_logout($data);
                            }catch(Exception $e){
                                //respone gagl non aktifkan status login
                                redirect(site_url('login'));
                            }
                            
                            // respone success logout 
                            redirect(site_url('login'));

                        }else{

                            // clear data login failed & logout success
                            redirect(site_url('login'));
                        
                        }

                    }catch(Exception $e){

                        // gagal menyimpan data logout
                        redirect(site_url('login'));
                    
                    }
                    
                    // session telah berhasil di bersihkan
                    redirect(site_url('login'));
                    
                }else{

                    // gagal unset session token / token invalid
                    redirect(site_url('login'));
                
                }
            }    
            
        }else{

            // respone unauthorized karena token invalid
            redirect(site_url('login'));
        
        }
    }

    public function register_user()
    {
        
    }
}

/* End of file User_Authentication.php */

