<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class People_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('master/People_model');
    }

    public function show_employee()
    {
        
        $this->load->template('management/v_employee');
    }

    public function all_employee()
    {
        $list = $this->People_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            
            if ($field->b_active == 't') {
                $b_active = '<span class="label label-success">active</span>';
            }else{
                $b_active = '<span class="label label-danger">non active</span>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->c_people;
            $row[] = $field->n_people;
            $row[] = $field->n_company;
            $row[] = $b_active;
            $row[] = $field->card_active.' days';
            $row[] = '  <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> edit</button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> delete</button>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->People_model->count_all(),
            "recordsFiltered" => $this->People_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function form_add_employee()
    {
        $this->load->template('management/v_employee_add');
    }

}

/* End of file People_Management.php */
