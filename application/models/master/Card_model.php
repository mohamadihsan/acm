<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model {

    public function show($c_card, $i_card_type)
    {
        $result = $this->db->query("SELECT * FROM macm.sp_getcard('$c_card','$i_card_type')")->result();
        
        return $result;
    }

}

/* End of file Card_model.php */
