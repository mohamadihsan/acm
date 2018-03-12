<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class People_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/People_model');
        $this->load->model('master/Company_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json($type_people)
    {
        $list = $this->People_model->get_datatables($type_people);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            
            if ($field->b_active == 't') {
                $b_active = '<span class="label label-success">active</span>';
            }else{
                $b_active = '<span class="label label-danger">non active</span>';
            }

            if ($field->card_active != null) {
                $days = 'days';
            }else{
                $days = '-';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->c_people;
            $row[] = $field->n_people;
            $row[] = $field->n_company;
            $row[] = $b_active;
            $row[] = $field->card_active.' '.$days;
            $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_people."'".')"><i class="fa fa-pencil"></i> edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_people."'".')"><i class="fa fa-trash"></i> delete</button>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->People_model->count_all($type_people),
            "recordsFiltered" => $this->People_model->count_filtered($type_people),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function all_employee()
    {
        $type_people = 'employee';
        // call function
        $this->get_json($type_people);
    }

    public function all_tenant()
    {
        $type_people = 'tenant';
        // call function
        $this->get_json($type_people);
    }

    public function all_non_employee()
    {
        $type_people = 'non employee';
        // call function
        $this->get_json($type_people);
    }

    public function show_employee()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Employee', 
                    'title'         => 'Employee Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Employee List'
                );

                
                $data['company'] = $this->Company_model->show_data_company();

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

        $data['menu'] = 'dashboard';
        
        $this->load->template('management/v_employee', $data);
    }

    public function show_tenant()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Tenant', 
                    'title'         => 'Tenant Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Tenant List'
                );

                $data['company'] = $this->Company_model->show_data_company();

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
        
        $this->load->template('management/v_tenant', $data);
    }

    public function show_non_employee()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Non Employee', 
                    'title'         => 'Non Employee Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Non Employee List'
                );

                $data['company'] = $this->Company_model->show_data_company();

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
        
        $this->load->template('management/v_non_employee', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->People_model->get_by_id($id);
        //$data->email = ($data->email == '0000-00-00') ? '' : $data->email; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'c_people' => $this->input->post('c_people'),
                'n_people' => $this->input->post('n_people'),
                'type_people' => $this->input->post('type_people'),
                'c_company' => $this->input->post('c_company'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'b_active' => 't',
                'e_entry' => $i_user,
                'card_active' => $this->input->post('card_active'),
            );
        $insert = $this->People_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'c_people' => $this->input->post('c_people'),
                'n_people' => $this->input->post('n_people'),
                'type_people' => $this->input->post('type_people'),
                'c_company' => $this->input->post('c_company'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'b_active' => 't',
                'e_entry' => $i_user,
                'card_active' => $this->input->post('card_active'),
            );
        $this->People_model->update(array('i_people' => $this->input->post('i_people')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->People_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_people') == '')
        {
            $data['inputerror'][] = 'c_people';
            $data['error_string'][] = 'Identity Number is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('n_people') == '')
        {
            $data['inputerror'][] = 'n_people';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('type_people') == '')
        {
            $data['inputerror'][] = 'type_people';
            $data['error_string'][] = 'Please select type';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('c_company') == '')
        {
            $data['inputerror'][] = 'c_company';
            $data['error_string'][] = 'Please select Company';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}

/* End of file People_Management.php */
