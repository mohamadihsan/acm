<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blacklist_model extends CI_Model {

    var $table = 'tacm.t_d_blacklist'; //nama tabel dari database
    var $column_order = array(null, "r.c_card", "r.i_card_type", "r.c_people", "c.n_company", "r.d_blacklist"); //field yang ada di table user
    var $column_search = array('r.c_card', "r.c_people", "c.n_company", "d.n_desc"); //field yang diizin untuk pencarian 
    var $order = array('i_blacklist' => 'asc'); // default order 

    private function _get_datatables_query($param = null, $data = null)
    {
        if($param == 'filter'){
            $start_date = $data['start_date'];
            $end_date   = $data['end_date'];

            if ($start_date != null) {
                $this->db->where(array('r.d_blacklist >=' => $start_date.' 00:00:00'));
            }

            if ($start_date != null) {
                $this->db->where(array('r.d_blacklist <=' => $end_date.' 23:59:59'));
            }
        }
        
        $this->db->where('r.c_desc =', 'SB');
        
        $this->db->select(' r.i_blacklist,
                            r.uid,
                            r.c_card,
                            r.i_card_type,
                            r.c_people,
                            p.n_people,
                            c.c_company,
                            c.n_company,
                            r.c_desc,
                            d.n_desc,
                            r.e_entry,
                            r.description,
                            r.d_blacklist 
                        ');
        $this->db->from(' tacm.t_d_blacklist r');
        $this->db->join(' macm.t_m_people p', 'p.c_people = r.c_people' ,'left');
        $this->db->join(' macm.t_m_company c', 'c.c_company = p.c_company' , 'left');
        $this->db->join(' macm.t_m_desc d', 'd.c_desc = r.c_desc' , 'left');
        
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
        $this->db->where('i_blacklist',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($c_card, $description, $i_user)
    {
        $result = $this->db->query("SELECT * FROM tacm.sp_blacklist('$c_card', '$description', $i_user)")->result();
        
        return $result;
    }
 
    public function restore($i_blacklist, $i_user)
    {
        $result = $this->db->query("SELECT * FROM tacm.sp_reactivate_card($i_blacklist, $i_user)")->result();
        
        return $result;
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('i_blacklist', $id);
        $this->db->delete($this->table);
    }

    function show_data_blacklist()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function show_data_card()
    {   
        $status = ['SB', 'BL'];
        
        $this->db->where('b_active', 't');
        $this->db->where("c_card NOT IN( SELECT c_card FROM tacm.t_d_blacklist WHERE c_desc IN ('SB', 'BL'))", NULL, FALSE);
        $query = $this->db->get('macm.t_m_card')->result();

        return $query;        
    }

}

/* End of file Blacklist_model.php */
