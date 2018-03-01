<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class People_model extends CI_Model {

    public function show_all($type_people)
    {
        $result = $this->db->query("SELECT * FROM macm.sp_getpeople_by_type('$type_people')")->result();
        
        return $result;
    }

    public function show($c_people, $type_people)
    {
        $result = $this->db->query("SELECT * FROM macm.sp_getpeople('$c_people', '$type_people')")->result();
        
        return $result;
    }

}

/* End of file People_model.php */
