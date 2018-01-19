<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function show($param = '')
    {
        if ($param == '') { 
            $where = "b_active='t'";

            // tampilkan semua data user
            $this->db->select('*')->from('macm.t_m_user')->where();
            $user = $this->db->get();
        }else{
            $where = "username='".$param['username']."' AND b_active='t'";

            // tampilkan data user sesuai parameter
            $this->db->select('*')->from('macm.t_m_user')->where($where);
            $user = $this->db->get();    
        }
        
        return $user;
    }   
    
    public function insert_login_success($data)
    {
        
        $this->db->insert('tacm.t_d_login', $data);
        return $this->db->affected_rows();

    }

    public function token_validation($i_user)
    {
        $where = "b_active='t' AND i_user='".$i_user."' ORDER BY d_login DESC";
        $this->db->select('*')->from('tacm.t_d_login')->where($where);
        return $this->db->get();
        
    }

}

/* End of file User_model.php */

