<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Management extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
    }
    

    public function index()
    {   
        // get from API
        $url = site_url('api/show_card');  

        // set header
        $token = $this->session->userdata('id_token');
        $authorization = array('Authorization' => $token );
        
        $request_headers = array();
        $request_headers[] = 'Authorization: '.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $transaction = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: ".curl_error($ch);
        } else {
            // Show me the result

            $data = json_decode($transaction);
            // $data['hari'] = "Senin";
            // $data['bulan'] = "Fwbruari";

            curl_close($ch);

            // var_dump(json_decode($transaction));
            // die();
        }

        $this->load->template('management/v_card', $data);
    }

}

/* End of file Card_Management.php */
