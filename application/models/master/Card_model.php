<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model {

    var $table = 'macm.t_m_card'; //nama tabel dari database
    var $column_order = array(null, 'c_card', 'i_card_type', 'c_people', 'd_active_card', 'b_active'); //field yang ada di table user
    var $column_search = array('c_card', 'c_people'); //field yang diizin untuk pencarian 
    var $order = array('i_card' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
 
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
        $this->db->where('i_card',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    function show_data_card()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function show($c_card, $i_card_type)
    {
        $result = $this->db->query("SELECT * FROM macm.sp_getcard('$c_card','$i_card_type')")->result();
        
        return $result;
    }

    public function show_all()
    {
        $result = $this->db->query("SELECT * FROM macm.sp_getcard()")->result();
        
        return $result;
    }

    function exportExcel($i_card_type = null)
    {
        if($i_card_type != 'all'){
            $this->db->where('i_card_type', $i_card_type);
        }
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    public function show_card_type()
    {
        $result = $this->db->query("SELECT * FROM macm.t_m_card_type")->result();
        
        return $result;
    }
}

/* End of file Card_model.php */
