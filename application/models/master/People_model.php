<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class People_model extends CI_Model {

    var $table = 'macm.t_m_people'; //nama tabel dari database
    var $table_2 = 'macm.t_m_company';
    var $column_order = array(null, "c_people", "n_people", "n_company", "email", null, "b_active", "d_entry", "card_active"); //field yang ada di table user
    var $column_search = array('c_people','n_people', 'n_company', 'email'); //field yang diizin untuk pencarian 
    var $order = array('i_people' => 'asc'); // default order 

    private function _get_datatables_query($type_people)
    {
        $this->db->where('type_people', $type_people);
        $this->db->from($this->table);
        $this->db->join($this->table_2, 't_m_people.c_company = t_m_company.c_company');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
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
 
    function get_datatables($type_people)
    {
        $this->_get_datatables_query($type_people);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($type_people)
    {
        $this->_get_datatables_query($type_people);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($type_people)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('i_people',$id);
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
        $this->db->where('i_people', $id);
        $this->db->delete($this->table);
    }

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
