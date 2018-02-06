<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Desc_model extends CI_Model {

    // insert data
    public function insert($data)
    {
        if ($this->db->insert('macm.t_m_desc', $data)) {
            return true;
        }
        return false;
    }

    // update data
    public function update($id, $data)
    {
        $this->db->where('i_desc', $id);
        $this->db->update('macm.t_m_desc', $data);
        return $this->db->affected_rows();
            
    }

    // soft delete
    public function soft_delete($id)
    {
        
        $this->db->where('i_desc', $id);
        $this->db->update('macm.t_m_desc', array('b_active'=>'f'));
        return $this->db->affected_rows();
        
    }

    // force delete / delete permanen
    public function force_delete($id)
    {
        $this->db->where('i_desc', $id);
        $this->db->delete('macm.t_m_desc');
        return $this->db->affected_rows();
        
    }

}

/* End of file Desc_model.php */
