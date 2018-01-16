<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Authentication extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies

    }

    // List all your items
    public function index( $offset = 0 )
    {
        $this->load->template('login/v_form_login');
    }

    // verifikasi user
    public function verify()
    {
        echo 'MASUK';
    }

    // Add a new item
    public function add()
    {

    }

    //Update one item
    public function update( $id = NULL )
    {

    }

    //Delete one item
    public function delete( $id = NULL )
    {

    }
}

/* End of file Authentication.php */

