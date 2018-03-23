<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Dashboard_model');
        $this->load->library('Token_Validation');
    }
    
    public function index()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Dashboard', 
                    'title'         => 'Dashboard'
                );

                $data['total_card_active'] = $this->Dashboard_model->count_card_active();
                $data['total_blacklist'] = $this->Dashboard_model->count_blacklist();
                $data['total_employee'] = $this->Dashboard_model->count_employee();
                $data['total_non_employee'] = $this->Dashboard_model->count_non_employee();

            }else{

                // token expired        
                ?>  
                    <script> 
                        setTimeout(function(){
                            alert("Token is expired. System will be logout automatically!")
                        }, 1000);
                    </script> 
                <?php

                redirect('logout','refresh');
                
            } 

        }else{

            // redirect logout, token not found    
            ?>  
                <script> 
                    setTimeout(function(){
                        alert("You do not have access to this page!")
                    }, 1000);
                </script> 
            <?php

            redirect('logout','refresh');
            
        } 
        
        $this->load->template('dashboard/v_dashboard', $data);   
    }
}

/* End of file Dashboard.php */
