<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRole_model extends CI_Model {

    var $table = 'macm.t_m_group_access'; //nama tabel dari database
    var $column_order = array(null, "n_group", "n_menu"); //field yang ada di table user
    var $column_search = array('n_group','n_menu'); //field yang diizin untuk pencarian 
    var $order = array('i_group_access' => 'asc'); // default order 

    private function _get_datatables_query($param = null, $data = null)
    {
        $i_group = 1;
        if($param == 'filter'){
            $i_group = $data['i_group'];
        }
        $this->db->where("ga.i_group = $i_group OR ga.i_group IS NULL AND menu.b_active = 't' ", NULL, FALSE);
        $this->db->select(' ga.i_group_access,
                            menu.i_menu,
                            menu.n_menu,
                            menu.n_parent,
                            gr.i_group,
                            gr.n_group,
                            ga.b_view,
                            ga.b_insert,
                            ga.b_update,
                            ga.b_delete  ');
        $this->db->from('macm.t_m_menu menu');
        $this->db->join('macm.t_m_group_access ga', 'ga.i_menu = menu.i_menu', 'left');
        $this->db->join('macm.t_m_group gr', 'gr.i_group = ga.i_group', 'left');
        $this->db->order_by('ga.i_group desc', 'menu.n_menu desc', 'menu.level desc');
        
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
 
    function get_datatables($param = null, $data = null)
    {
        if ($param == 'filter') {
            $this->_get_datatables_query('filter', $data);
        }else{
            $this->_get_datatables_query();
        }
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
        $this->db->where('i_group_access',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('i_group_access', $id);
        $this->db->delete($this->table);
    }

    function show_data_company()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

}

/* End of file UserRole_model.php */
