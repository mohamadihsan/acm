<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuUser_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
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

    public function get_json($n_menu)
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
                $action = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                $view   = $action[0]->b_view;
                $insert = $action[0]->b_insert;
                $update = $action[0]->b_update;
                $delete = $action[0]->b_delete;
                
                //  END SCRIPT TO SET USER ROLE

                $list = $this->MenuUser_model->get_datatables();
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
                    $row[] = $field->n_menu;
                    $row[] = $field->level;
                    $row[] = $field->n_parent; 
                    $row[] = $field->site_url; 
                    $row[] = $field->segment_name; 
                    $row[] = $field->icon;    
                    $row[] = $b_active; 
                    
                    if ($update == 't' AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_menu."'".')"><i class="fa fa-pencil"></i> edit</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_menu."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else if ($update == 't' AND $delete == 'f' OR $delete == null) {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_menu."'".')"><i class="fa fa-pencil"></i> edit</button>';
                    }else if ($update == 'f' OR $update == null AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_menu."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else{
                        $row[] = '';
                    }
                    
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->MenuUser_model->count_all(),
                    "recordsFiltered" => $this->MenuUser_model->count_filtered(),
                    "data" => $data,
                );
            }
        }
        
        //output dalam format JSON
        echo json_encode($output);
    }

    public function all()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'menu';

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
                    'menu'          => 'Menu', 
                    'title'         => 'Menu Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Menu List'
                );

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
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

        $data['menu'] = 'Menu';
        
        $this->load->template('management/v_menu', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->MenuUser_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'n_menu' => $this->input->post('n_menu'),
                'level' => $this->input->post('level'),
                'b_active'   => $this->input->post('b_active'),
                'e_entry' => $i_user,
                'n_parent'   => $this->input->post('n_parent'),
                'site_url'   => $this->input->post('site_url'),
                'segment_name'   => $this->input->post('segment_name'),
                'icon'   => $this->input->post('icon')
            );
        $insert = $this->MenuUser_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
            'n_menu' => $this->input->post('n_menu'),
            'level' => $this->input->post('level'),
            'b_active'   => $this->input->post('b_active'),
            'e_entry' => $i_user,
            'n_parent'   => $this->input->post('n_parent'),
            'site_url'   => $this->input->post('site_url'),
            'segment_name'   => $this->input->post('segment_name'),
            'icon'   => $this->input->post('icon')
            );
        $this->MenuUser_model->update(array('i_menu' => $this->input->post('i_menu')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->MenuUser_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('n_menu') == '')
        {
            $data['inputerror'][] = 'n_menu';
            $data['error_string'][] = 'Menu Name is required';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('segment_name') == '')
        {
            $data['inputerror'][] = 'segment_name';
            $data['error_string'][] = 'Segment Name is required';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file MenuUser_Management.php */
