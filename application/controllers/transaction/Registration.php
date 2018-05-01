<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('transaction/Registration_model');
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
                    $list = $this->Registration_model->get_datatables($param, $data);
                }else{
                    $list = $this->Registration_model->get_datatables();
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
                    $row[] = $field->c_registration;
                    $row[] = $field->c_card;
                    $row[] = $field->i_card_type;
                    $row[] = $field->c_people;
                    $row[] = $field->n_people;
                    $row[] = $field->n_company;
                    $row[] = $c_status;
                    $row[] = $field->n_desc;  
                    $row[] = $field->d_entry;  

                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Registration_model->count_all(),
                    "recordsFiltered" => $this->Registration_model->count_filtered(),
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
        $n_menu = 'registration card';

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Registration', 
                    'title'         => 'Registration', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Registration History'
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
                
                $data['company'] = $this->Registration_model->show_data_registration();

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

        $data['menu'] = 'Registration';
        
        $this->load->template('transaction/v_registration', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Registration_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'c_registration' => $this->input->post('c_registration'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $insert = $this->Registration_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'c_registration' => $this->input->post('c_registration'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $this->Registration_model->update(array('i_registration' => $this->input->post('i_registration')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Registration_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_registration') == '')
        {
            $data['inputerror'][] = 'c_registration';
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

/* End of file Registration.php */
