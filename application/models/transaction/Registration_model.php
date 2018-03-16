<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {

    var $table = 'tacm.t_d_registration'; //nama tabel dari database
    var $column_order = array(null, "r.c_registration", "r.c_card", "r.i_card_type", "r.c_people", "p.n_people", "c.n_company", "r.c_status", "d.n_desc", "r.d_entry"); //field yang ada di table user
    var $column_search = array('r.c_registration','r.c_card', "r.c_people", "p.n_people", "c.n_company", "d.n_desc"); //field yang diizin untuk pencarian 
    var $order = array('i_registration' => 'asc'); // default order 

    private function _get_datatables_query($param = null, $data = null)
    {
        if($param == 'filter'){
            $start_date = $data['start_date'];
            $end_date   = $data['end_date'];
            $c_status   = $data['c_status'];

            if ($c_status != "") {
                $this->db->where(array('c_status' => $c_status));
            }

            if ($start_date != null) {
                $this->db->where(array('r.d_entry >=' => $start_date.' 00:00:00'));
            }

            if ($start_date != null) {
                $this->db->where(array('r.d_entry <=' => $end_date.' 23:59:59'));
            }
        }

        $this->db->select(' r.i_registration,
                            r.c_registration,
                            r.uid,
                            r.c_card,
                            r.i_card_type,
                            r.c_people,
                            p.n_people,
                            r.c_company,
                            c.n_company,
                            r.c_status,
                            r.c_desc,
                            d.n_desc,
                            r.e_entry,
                            r.d_entry 
                        ');
        $this->db->from(' tacm.t_d_registration r');
        $this->db->join(' macm.t_m_people p', 'p.c_people = r.c_people' ,'left');
        $this->db->join(' macm.t_m_company c', 'c.c_company = r.c_company' , 'left');
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
        $this->db->where('i_registration',$id);
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
        $this->db->where('i_registration', $id);
        $this->db->delete($this->table);
    }

    function show_data_registration()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($uid, $c_card, $i_card_type, $c_people, $c_company, $i_user)
    {
        $result = $this->db->query("SELECT * FROM tacm.sp_registration('$uid', '$c_card', '$i_card_type', '$c_people', '$c_company', '$i_user')")->result();
        
        return $result;
    }

}

/* End of file Registration_model.php */
