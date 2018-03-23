<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function count_card_active()
    {
        $query = $this->db->get('macm.t_m_card');
        return  $query->num_rows();
    }
    
    public function count_blacklist()
    {
        $this->db->where('c_desc', 'S');
        $this->db->where('c_status', 't');
        $query = $this->db->get('tacm.t_d_blacklist');
        return  $query->num_rows();
    }

    public function count_employee()
    {
        $this->db->where('type_people', 'employee');
        $this->db->where('b_active', 't');
        $query = $this->db->get('macm.t_m_people');
        return  $query->num_rows();
    }

    public function count_non_employee()
    {
        $this->db->where("type_people NOT IN ('employee')", NULL, FALSE);
        $this->db->where('b_active', 't');
        $query = $this->db->get('macm.t_m_people');
        return  $query->num_rows();
    }

}

/* End of file Dashboard_model.php */
