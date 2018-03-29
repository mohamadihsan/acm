<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Update_Card extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('transaction/Update_Card_model');
        $this->load->model('general/Menu_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json($param = null, $data = null)
    {
        $output = null;
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){

                if ($param == 'filter') {
                    $list = $this->Update_Card_model->get_datatables($param, $data);
                }else{
                    $list = $this->Update_Card_model->get_datatables();
                }

                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    if ($field->c_status == 't') {
                        $c_status = '<span class="badge badge-success badge-roundless"><i class="fa fa-check"></i> success</span>';
                    }else{
                        $c_status = '<span class="badge badge-danger badge-roundless"><i class="fa fa-close"></i> failed</span>';
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_card;
                    $row[] = $field->i_card_type;
                    $row[] = $field->c_people;
                    $row[] = $field->n_company;
                    $row[] = $c_status;
                    $row[] = $field->d_active_card_before;
                    $row[] = $field->d_active_card;
                    $row[] = $field->n_desc;  
                    $row[] = $field->d_update_card;  

                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Update_Card_model->count_all(),
                    "recordsFiltered" => $this->Update_Card_model->count_filtered(),
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

    public function filter()
    {
        $data = array(
            'c_status' => $this->input->post('c_status'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date')
        );
        // call function
        $this->get_json('filter', $data);
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Update Card', 
                    'title'         => 'Update Card', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Update Card History'
                );

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
                $data['update_card'] = $this->Update_Card_model->show_data_update_card();

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

        $data['menu'] = 'Update Card';
        
        $this->load->template('transaction/v_update_card', $data);
    }

}

/* End of file Update_Card.php */
