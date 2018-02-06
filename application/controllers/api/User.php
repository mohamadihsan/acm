<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/User_Model');
        
    }
    

    public function user_get()
    {
        
    }

}

/* End of file User.php */
