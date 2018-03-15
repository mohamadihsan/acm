<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Deletion extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('transaction/Deletion_Card_model');
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
            $row[] = $field->n_desc;  
            $row[] = $field->d_deletion_card;  

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Deletion_Card_model->count_all(),
            "recordsFiltered" => $this->Deletion_Card_model->count_filtered(),
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
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Deletion Card', 
                    'title'         => 'Deletion Card', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Deletion Card History'
                );

                
                $data['deletion'] = $this->Deletion_Card_model->show_data_deletion_card();

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

}

/* End of file Deletion.php */
