<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Blacklist extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('transaction/Blacklist_model');
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
            $list = $this->Blacklist_model->get_datatables($param, $data);
        }else{
            $list = $this->Blacklist_model->get_datatables();
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
            $row[] = $field->d_blacklist;
            $row[] = $field->description;  
            $row[] = '  <button type="button" class="btn btn-info btn-sm" onclick="restore_data('."'".$field->i_blacklist."'".')"><i class="fa fa-refresh"></i> restore</button>';

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Blacklist_model->count_all(),
            "recordsFiltered" => $this->Blacklist_model->count_filtered(),
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
                    'menu'          => 'Blacklist', 
                    'title'         => 'Blacklist', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Blacklist History'
                );

                
                $data['blacklist'] = $this->Blacklist_model->show_data_blacklist();
                $data['card'] = $this->Blacklist_model->show_data_card();

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

        $data['menu'] = 'Blacklist';
        
        $this->load->template('transaction/v_blacklist', $data);
    }

    public function ajax_restore($id)
    {
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $this->Blacklist_model->restore($id, $i_user);
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
            
        $insert = $this->Blacklist_model->save($c_card, $description, $i_user);
        
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

/* End of file Blacklist.php */
