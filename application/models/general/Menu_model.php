<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function show_menu()
    {
        
        $this->db->select('n_menu, level');
        $this->db->where('b_active', 't');
        $query = $this->db->get('macm.t_m_menu');
                
        return $query->result();

    } 
    
    public function show_user_role()
    {
        
        $this->db->select('n_menu, level');
        $this->db->where('b_active', 't');
        $query = $this->db->get('macm.t_m_menu');
                
        return $query->result();

    } 

}

/* End of file Menu_model.php */
