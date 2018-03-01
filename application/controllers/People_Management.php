<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class People_Management extends CI_Controller {

    public function show_employee()
    {
        // get from API
        $url = site_url('api/show_people');  

        // set header
        $token = $this->session->userdata('id_token');
        $authorization = array('Authorization' => $token );
        
        // set parameter request body
        $param = array("type_people" => "employee");
        
        $request_headers = array();
        $request_headers[] = 'Authorization: '.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $transaction = curl_exec($ch);

        if (curl_errno($ch)) {
            
            print "Error: ".curl_error($ch);
            
        } else {
            
            $data = json_decode($transaction);

            curl_close($ch);
        }
        
        $this->load->template('management/v_employee', $data);
    }

    public function form_add_employee()
    {
        $this->load->template('management/v_employee_add');
    }

}

/* End of file People_Management.php */
