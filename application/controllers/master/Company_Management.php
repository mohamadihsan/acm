<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/Company_model');
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
        $list = $this->Company_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->c_company;
            $row[] = $field->n_company;
            $row[] = $field->address;            
            $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_company."'".')"><i class="fa fa-pencil"></i> edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_company."'".')"><i class="fa fa-trash"></i> delete</button>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Company_model->count_all(),
            "recordsFiltered" => $this->Company_model->count_filtered(),
            "data" => $data,
        );
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
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Company', 
                    'title'         => 'Company Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Company List'
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

        $data['menu'] = 'Company';
        
        $this->load->template('management/v_company', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Company_model->get_by_id($id);
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
        $insert = $this->Company_model->save($data);
        
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
        $this->Company_model->update(array('i_company' => $this->input->post('i_company')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Company_model->delete_by_id($id);
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

/* End of file Company_Management.php */