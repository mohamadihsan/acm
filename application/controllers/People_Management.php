<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class People_Management extends CI_Controller {

    public function show_employee()
    {
        $this->load->template('management/v_employee');
    }

    public function form_add_employee()
    {
        $this->load->template('management/v_employee_add');
    }

}

/* End of file People_Management.php */
