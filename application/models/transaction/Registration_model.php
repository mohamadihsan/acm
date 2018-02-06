<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {

    public function insert($uid, $c_card, $i_card_type, $c_people, $n_company, $i_user)
    {
        $result = $this->db->query("SELECT * FROM tacm.sp_registration('$uid', '$c_card', '$i_card_type', '$c_people', '$n_company', '$i_user')")->result();
        
        return $result;
    }

}

/* End of file Registration_model.php */
