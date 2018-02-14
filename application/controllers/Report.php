<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function index()
    {
        $this->load->template('report/v_report');
    }

}

/* End of file Report.php */
