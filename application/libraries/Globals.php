<?php

class Globals {

    //  Pass array as an argument to constructor function
    public function __construct($config = array()) {

        $config['application_name'] = "Access Card Management";
        $config['company_name'] = "Nutech Integrasi";
        $config['developer'] = "Mohamad Ihsan";

        //  Create associative array from the passed array
        foreach ($config as $key => $value) {
            $data[$key] = $value;
        }

        // Make instance of CodeIgniter to use its resources
        $CI = & get_instance();

        // Load data into CodeIgniter
        $CI->load->vars($data);
    }
}

?>