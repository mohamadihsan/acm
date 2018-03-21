<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/Card_model');
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
                    'menu'          => 'Card', 
                    'title'         => 'Card Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Card List'
                );

                
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
