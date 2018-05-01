<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/Card_model');
        $this->load->model('general/Menu_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json()
    {
        $output = null;
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){

                $list = $this->Card_model->get_datatables();
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    if ($field->b_active == 't') {
                        $b_active = '<span class="badge badge-success badge-roundless"><i class="fa fa-check"></i> active</span>';
                    }else{
                        $b_active = '<span class="badge badge-danger badge-roundless"><i class="fa fa-check"></i> non active</span>';
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_card;
                    $row[] = $field->i_card_type;
                    $row[] = $field->c_people;
                    $row[] = $field->d_active_card; 
                    $row[] = $b_active;            
                    
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Card_model->count_all(),
                    "recordsFiltered" => $this->Card_model->count_filtered(),
                    "data" => $data,
                );
            }
        }
        //output dalam format JSON
        echo json_encode($output);
    }

    public function all()
    {
        // call function
        $this->get_json();
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "card";
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Card', 
                    'title'         => 'Card Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Card List'
                );

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
                $roles = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                $data['view']   = $roles[0]->b_view;
                $data['insert'] = $roles[0]->b_insert;

                $data['card'] = $this->Card_model->show_data_card();

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

        $data['menu'] = 'Card';
        
        $this->load->template('management/v_card', $data);
    }
}

/* End of file Card_Management.php */
