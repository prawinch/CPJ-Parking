<?php
class Croninfo extends CI_Model
{


    function get_alloc_count($date)
    {
        $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,pc.to_date as end_date');
        $this->db->from('alloc as ac');
        $this->db->join('parking as p','ac.parking=p.id');
        $this->db->join('parking_allocation as pc','ac.parking=pc.parking');
        $this->db->where('ac.alloc_date<=',$date);
        $this->db->where('ac.to_date=',$date);
        $this->db->where('ac.status','1');
        $this->db->order_by('position','asc');
        $this->db->group_by('parking');
      //  $this->db->limit('1','0');
        return $query=$this->db->get();
     }

    function get_alloc($date)
    {
        $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,pc.to_date as end_date,pc.id as parent_id');
        $this->db->from('alloc as ac');
        $this->db->join('parking as p','ac.parking=p.id');
        $this->db->join('parking_allocation as pc','ac.parking=pc.parking');
        $this->db->where('ac.alloc_date<=',$date);
        $this->db->where('ac.to_date=',$date);
        $this->db->where('ac.status','1');
        $this->db->order_by('position','asc');
        $this->db->group_by('parking');
        $this->db->limit('1','0');
        $query=$this->db->get();
        return $query->result_array();
    }

    function get_alloc_cancel($parking)
    {
        //$this->db->select('ac.*,p.id as parking_id,p.name as parking_name,pc.to_date as end_date');
        $this->db->select('ac.*,p.id as parking_id,p.name as parking_name');
        $this->db->from('alloc as ac');
        $this->db->join('parking as p','ac.parking=p.id');
       // $this->db->join('parking_allocation as pc','ac.parking=pc.parking');
        $this->db->where('ac.parking',$parking);
        //$this->db->where('ac.status','0');
        $this->db->order_by('position','asc');
        //$this->db->limit('1','0');
        $query=$this->db->get();
        return $query->result_array();
    }



    function get_alloc_not_confirmation($date)
    {
        $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,pc.to_date as end_date');
        $this->db->from('alloc as ac');
        $this->db->join('parking as p','ac.parking=p.id');
        $this->db->join('parking_allocation as pc','ac.parking=pc.parking');
        $this->db->where('ac.alloc_date<=',$date);
        $this->db->where('ac.to_date=',$date);
        $this->db->where('ac.status','0');
        $this->db->order_by('position','asc');
        $this->db->group_by('parking');
        //$this->db->limit('1','0');
        $query=$this->db->get();
        return $query->row();

    }

    function get_alloc_batch($date)
    {
        $this->db->where('to_date<=',$date);
        $query=$this->db->get('allocation_batch');
        echo $this->db->last_query();
        return $query->result_array();

    }

}