<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Menu_model');
        
    }

    public function show()
    {
        
    }

}

/* End of file Menu.php */
