<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRole_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/UserRole_model');
        $this->load->model('master/Group_model');
        $this->load->model('master/User_model');
        $this->load->model('master/MenuUser_model');
        $this->load->model('general/Menu_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json($n_menu, $param = null, $data = null)
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

                // show user role for action this menu
                // $action = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                // $view   = $action[0]->b_view;
                // $insert = $action[0]->b_insert;
                // $update = $action[0]->b_update;
                // $delete = $action[0]->b_delete;
                
                //  END SCRIPT TO SET USER ROLE

                
                if ($param == 'filter') {
                    $list = $this->UserRole_model->get_datatables($param, $data);
                }else{
                    $list = $this->UserRole_model->get_datatables();
                }

                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    if ($field->b_view == 't') {
                        $b_view = 'checked';
                    }else{
                        $b_view = '';
                    }
                    if ($field->b_insert == 't') {
                        $b_insert = 'checked';
                    }else{
                        $b_insert = '';
                    }
                    if ($field->b_update == 't') {
                        $b_update = 'checked';
                    }else{
                        $b_update = '';
                    }
                    if ($field->b_delete == 't') {
                        $b_delete = 'checked';
                    }else{
                        $b_delete = '';
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->n_menu;
                    $row[] = $field->n_parent;
                    $row[] = $field->n_group;
                    $row[] = '  <label class="mt-checkbox">
                                    <input type="checkbox" name="b_view" id="b_view" '.$b_view.' />
                                    <span></span>
                                </label>';
                    $row[] = '  <label class="mt-checkbox">
                        <input type="checkbox" name="b_insert" id="b_insert" '.$b_insert.' />
                        <span></span>
                    </label>';
                    $row[] = '  <label class="mt-checkbox">
                        <input type="checkbox" name="b_update" id="b_update" '.$b_update.' />
                        <span></span>
                    </label>';
                    $row[] = '  <label class="mt-checkbox">
                        <input type="checkbox" name="b_delete" id="b_delete" '.$b_delete.' />
                        <span></span>
                    </label>';
                    
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->UserRole_model->count_all(),
                    "recordsFiltered" => $this->UserRole_model->count_filtered(),
                    "data" => $data,
                );
            }
        }
        
        //output dalam format JSON
        echo json_encode($output);
    }

    public function filter()
    {
        $n_menu = 'User Role';

        $data = array(
            'i_group' => $this->input->post('i_group')
        );
        // call function
        $this->get_json($n_menu, 'filter', $data);
    }

    public function all()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'User Role';

        // call function
        $this->get_json($n_menu);
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'User Role', 
                    'title'         => 'User Role Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'User Role List'
                );

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
                $data['groups'] = $this->Group_model->show();
                $data['menus'] = $this->MenuUser_model->show();

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

        $data['menu'] = 'User Role';
        
        $this->load->template('management/v_user_role', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->UserRole_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'c_company' => $this->input->post('c_company'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $insert = $this->UserRole_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'c_company' => $this->input->post('c_company'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $this->UserRole_model->update(array('i_company' => $this->input->post('i_company')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->UserRole_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_company') == '')
        {
            $data['inputerror'][] = 'c_company';
            $data['error_string'][] = 'Company Code is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('n_company') == '')
        {
            $data['inputerror'][] = 'n_company';
            $data['error_string'][] = 'Company Name is required';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file UserRole_Management.php */
