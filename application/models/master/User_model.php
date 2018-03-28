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

    public function show_user_role($param)
    {
        // tampilkan semua data user
        $this->db->select('n_group')->from('macm.t_m_group')->where($param);
        $role = $this->db->get();
        
        return $role;
    }   
    
    public function insert_login_success($data)
    {
        //insert to db
        $this->db->insert('tacm.t_d_login', $data);
        return $this->db->affected_rows();

    }

    public function token_validation($i_user)
    {
        $where = "b_active='t' AND i_user='".$i_user."' ORDER BY d_login DESC";
        $this->db->select('*')->from('tacm.t_d_login')->where($where);
        return $this->db->get();
        
    }

    public function insert_log_login($data)
    {
        // insert to db
        if($this->db->insert('tacm.t_log_login', $data)){
            return true;
        }
        return false;
        
    }

    public function check_login_active($data)
    {
            
        // tampilkan semua data user
        $this->db->order_by('i_login', 'desc');
        $this->db->limit(1);
        $this->db->select('*')->from('tacm.t_d_login')->where($data);
        $user = $this->db->get();
        
        return $user;
    }

    public function clear_data_login($id)
    {
        $this->db->where('i_user', $id);
        $this->db->update('tacm.t_d_login', array('b_active' => 'f'));
        return $this->db->affected_rows();
        
    }

    public function insert_data_logout($data)
    {
        // insert to db
        if($this->db->insert('tacm.t_d_logout', $data)){
            return true;
        }
        return false;
        
    }

}

/* End of file User_model.php */

