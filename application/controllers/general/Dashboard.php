<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Dashboard_model');
        $this->load->model('general/Menu_model');
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

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
                $data['total_card_active'] = $this->Dashboard_model->count_card_active();
                $data['total_blacklist'] = $this->Dashboard_model->count_blacklist();
                $data['total_employee'] = $this->Dashboard_model->count_employee();
                $data['total_non_employee'] = $this->Dashboard_model->count_non_employee();

                // echo json_encode($data);die();

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
