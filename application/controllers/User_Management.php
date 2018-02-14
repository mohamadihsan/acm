<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Management extends CI_Controller {

    public function index()
    {
        $this->load->template('management/v_user');
    }

}

/* End of file User_Management.php */
