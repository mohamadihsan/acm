<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Management extends CI_Controller {

    public function index()
    {
        $this->load->template('management/v_card');
    }

}

/* End of file Card_Management.php */
