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

    public function check_action($i_group, $n_menu)
    {
        $query = $this->db->query("
            SELECT
                b_view,
                b_insert,
                b_update,
                b_delete 
            FROM
                macm.t_m_menu menu
                LEFT JOIN macm.t_m_group_access group_access ON menu.i_menu = group_access.i_menu 
            WHERE
                group_access.i_group = '$i_group'  
                AND LOWER( menu.n_menu ) = LOWER( '$n_menu' ) 
                AND menu.b_active = 't' 
                LIMIT 1
        ");

        return $query->result();
    }

    public function show_menu_user($i_group, $n_parent)
    {
        if ($n_parent != null) {
            $where = "AND LOWER(menu.n_parent) = LOWER('$n_parent')";
        }else{
            $where = 'AND menu.n_parent IS NULL';
        }
        
        $query = $this->db->query("
            SELECT
                n_menu,
                LEVEL,
                b_view,
                b_insert,
                b_update,
                b_delete,
                n_parent,
                site_url,
                segment_name,
                icon 
            FROM
                macm.t_m_menu menu
                LEFT JOIN macm.t_m_group_access group_access ON menu.i_menu = group_access.i_menu 
            WHERE
                group_access.i_group = '$i_group' 
                $where
                AND menu.b_active = 't' 
            ORDER BY
                2,
                6,
                1
        ");

        return $query->result();
    }

}

/* End of file Menu_model.php */
