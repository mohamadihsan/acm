<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->template('dashboard/v_dashboard', $data);   
    }
}

/* End of file Dashboard.php */
