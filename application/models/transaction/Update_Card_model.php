<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Update_Card_model extends CI_Model {

    public function insert($uid, $c_card, $i_card_type, $c_people, $i_user)
    {
        $result = $this->db->query("SELECT * FROM tacm.sp_update_card('$uid', '$c_card', '$i_card_type', '$c_people', '$i_user')")->result();
        
        return $result;
    }

}

/* End of file Update_Card_model.php */
