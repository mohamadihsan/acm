<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        $this->load->template('dashboard/v_dashboard');   
    }
}

/* End of file Dashboard.php */
