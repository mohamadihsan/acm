<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Deletion extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('transaction/Deletion_Card_model');
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

                // BEGIN
                // INCLUDE THIS SCRIPT TO SET USER ROLE
                // get user role 
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];
                // menu name must pair with n_menu on macm.t_m_menu
                $n_menu = 'card deletion';

                // show user role for action this menu
                $action = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                $view   = $action[0]->b_view;
                $insert = $action[0]->b_insert;
                $update = $action[0]->b_update;
                $delete = $action[0]->b_delete;
                
                //  END SCRIPT TO SET USER ROLE

                if ($param == 'filter') {
                    $list = $this->Deletion_Card_model->get_datatables($param, $data);
                }else{
                    $list = $this->Deletion_Card_model->get_datatables();
                }

                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_card;
                    $row[] = $field->i_card_type;
                    $row[] = $field->c_people;
                    $row[] = $field->n_company;
                    $row[] = $field->description;  
                    $row[] = $field->d_deletion_card;  

                    if ($update == 't') {
                        $row[] = '  <button type="button" class="btn btn-info btn-sm" onclick="restore_data('."'".$field->i_deletion_card."'".')"><i class="fa fa-refresh"></i> restore</button>';
                    }else{
                        $row[] = '';
                    }
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Deletion_Card_model->count_all(),
                    "recordsFiltered" => $this->Deletion_Card_model->count_filtered(),
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
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date')
        );
        // call function
        $this->get_json('filter', $data);
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = 'card deletion';

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Deletion Card', 
                    'title'         => 'Deletion Card', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Deletion Card History'
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

                $data['deletion'] = $this->Deletion_Card_model->show_data_deletion_card();
                $data['card'] = $this->Deletion_Card_model->show_data_card();

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

        $data['menu'] = 'Deletion Card';
        
        $this->load->template('transaction/v_deletion', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Deletion_Card_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'b_delete' => $this->input->post('b_delete'),
                'e_entry' => $i_user
            );
        $this->Deletion_Card_model->update(array('i_deletion_card' => $this->input->post('i_deletion_card')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_restore($id)
    {
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $this->Deletion_Card_model->restore($id, $i_user);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_add()
    {
        $this->_validate();

        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $c_card         = $this->input->post('c_card');
        $description    = $this->input->post('description');

        $data = array(
                'c_card' => $c_card,
                'description' => $description,
                'i_user' => $i_user
            );
            
        $insert = $this->Deletion_Card_model->save($c_card, $description, $i_user);
        
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_card') == '')
        {
            $data['inputerror'][] = 'c_card';
            $data['error_string'][] = 'The Card is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('description') == '')
        {
            $data['inputerror'][] = 'description';
            $data['error_string'][] = 'Description / Reason is required';
            $data['status'] = FALSE;
        }
    }

}

/* End of file Deletion.php */
