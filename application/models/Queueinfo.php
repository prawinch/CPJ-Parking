<?php
class Queueinfo extends CI_Model
{
    function get_info($id)
    {
        $query=$this->db->where_not_in('id','1')->get('admin');
        return $query->result_array();
    }

    function get_allocation_info($id)
    {
        $query=$this->db->where('id',$id)->get('parking_allocation');
        return $query->row();
    }

    function parking_info()
    {
        $query=$this->db->order_by('id','asc')->where('booking_status','0')->get('parking');
        return $query->result_array();
    }


    function get_user_alloc_count($user)
    {
        $this->db->where('alloc.user',$user);
        $query=$this->db->get('parking_allocation as alloc');
        return $query->num_rows();
    }

    function get_user_alloc($user)
    {
        $this->db->select('alloc.*,p.id as parking_id,p.name as parking_name');
        $this->db->from('parking_allocation as alloc');
        $this->db->join('parking as p','alloc.parking=p.id');
        $this->db->where('alloc.user',$user);
        $query=$this->db->get();
        return $query->result_array();
        /*if($query->num_rows()>0)
        {
        }else
        {
            return false;
        }*/
    }

    function get_queue_all($offset=0)
    {
            $this->db->select('q.*,ad.firstname,ad.lastname,ad.email');
            $this->db->from('queue as q');
            $this->db->join('admin as ad','q.userid=ad.id');
            $this->db->limit(SEND_ALLOC,$offset);  //5 total display 0--start from recod
            $query=$this->db->get();
            return $query->result_array();
     }

    function get_queue_user_parked($user_id=0,$offset=0)//if user cancel parking wont send if that user queue
    {
        $this->db->select('q.*,ad.firstname,ad.lastname,ad.email');
        $this->db->from('queue as q');
        $this->db->join('admin as ad','q.userid=ad.id');
        if($user_id>0)
            $this->db->where('q.userid <>',$user_id);

        $this->db->limit(SEND_ALLOC,$offset);  //5 total display 0--start from recod
        $query=$this->db->get();
        return $query->result_array();
    }

    function save($id=-1,$data)
    {
        if ($id == -1) {
            return $this->db->insert('parking_allocation', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('parking_allocation', $data);
        }
    }

    function list_select($limit=0,$start=0)
    {
        $this->db->select('q.*,ad.firstname,ad.lastname,ad.apartment_no as apartment');
        $this->db->from('queue as q');
        $this->db->join('admin as ad','q.userid=ad.id');
        if($limit!=0)
            $this->db->limit($limit,$start);
        $query=$this->db->get();

        return $query->result_array();
    }

    function get_status()
    {
        return array(' ','Booked','Queue','Not in Queue');
    }

    function delete($userid)
    {
        $this->db->where('userid',$userid)->delete('queue'); //remove confirm parking from alloc
    }
}