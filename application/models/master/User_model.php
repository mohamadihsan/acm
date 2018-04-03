<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    var $table = 'macm.t_m_user'; //nama tabel dari database
    var $column_order = array(null, "username", "n_group", "n_people"); //field yang ada di table user
    var $column_search = array('username','n_group', 'n_people'); //field yang diizin untuk pencarian 
    var $order = array('i_user' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        
        $this->db->select(' us.i_user,
                            us.username,
                            us.password,
                            gr.n_group,
                            pe.i_people,
                            pe.n_people,
                            us.d_entry,
                            us.d_updated,
                            us.b_active ');
        $this->db->from('macm.t_m_user us');
        $this->db->join('macm.t_m_group gr', 'gr.i_group = us.i_group', 'left');
        $this->db->join('macm.t_m_people pe', 'pe.i_people = us.i_people', 'left');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if(isset($_POST['search']['value'])) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('i_user',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        if($this->check_user($data['username']) == false){
            // insert data user to macm.t_m_user
            if($this->db->insert($this->table, $data)){
                return $this->db->insert_id();
            }

            return false;

        }else{

            return false;

        }
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('i_user', $id);
        $this->db->delete($this->table);
    }

    function show_data_user()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function show($param = '')
    {
        if ($param == '') { 
            $where = "b_active='t'";

            // tampilkan semua data user
            $this->db->select('*')->from('macm.t_m_user');
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

    private function check_user($username)
    {
        
        $this->db->where('username', $username);
        
        if ($this->db->get('macm.t_m_user')->num_rows() > 0) {
            return true;
        }

        return false;
    }

    public function register($data)
    {
        if($this->check_user($data['username']) == false){
            // insert data user to macm.t_m_user
            if($this->db->insert('macm.t_m_user', $data)){
                return true;
            }

            return false;

        }else{

            return false;

        }
    }

}

/* End of file User_model.php */

