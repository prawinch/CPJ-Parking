<?php
class Allocationinfo extends CI_Model
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

    function get_approve_info($id)
    {
        $query=$this->db->where('id',$id)->get('parking_approve');
        return $query->row();
    }

    function parking_info()
    {
        $query=$this->db->order_by('id','asc')->where(array('booking_status'=>'0','status'=>'1'))->get('parking');
        return $query->result_array();
    }


    function get_user_alloc_count($user)
    {
        $this->db->where('alloc.user',$user);
        $query=$this->db->get('parking_allocation as alloc');
        return $query->num_rows();
    }
    function get_parking_alloc_count($user)
    {
        $this->db->where('alloc.parking',$user);
        $query=$this->db->get('parking_allocation as alloc');
        return $query->num_rows();
    }

    function get_parking_alloc($id)
    {
        $this->db->select('alloc.*,p.id as parking_id,p.name as parking_name,p.type as parking_type');
        $this->db->from('parking_allocation as alloc');
        $this->db->join('parking as p','alloc.parking=p.id');
        $this->db->where('alloc.id',$id);
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query->row_array();
    }

    function get_user_alloc($user)
    {
        $this->db->select('alloc.*,p.id as parking_id,p.name as parking_name,p.type');
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

    function save($id=-1,$data)
    {
        if ($id == -1) {
            return $this->db->insert('parking_allocation', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('parking_allocation', $data);
        }
    }

    function save_approve($id=-1,$data)
    {
        if ($id == -1) {
            return $this->db->insert('parking_approve', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('parking_approve', $data);
        }
    }


    function list_select()
    {
        $query = $this->db->get('parking_allocation');
        return $query->result_array();
    }

    function get_parking_waiting_confirmation()
    {
        $this->db->where(array('status'=>'0'));
        $query = $this->db->get('parking_approve');
        return $query->result_array();
    }

    function get_status()
    {
        return array(' ','Booked','Queue','Not in Queue');
    }

    function save_batch($id=-1,$data)
    {
        if ($id == -1) {
            return $this->db->insert('allocation_batch', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('allocation_batch', $data);
        }
    }



    function generate()
    {
        $today=date('Y-m-d');
      //  $today='2017-07-28';
        $from_date=date('Y-m-d',strtotime("first day of next month"));
        $to_date=date('Y-m-d',strtotime("last day of next month"));

        $Query=$this->db->where('create_date',$today)->get('trans');
        if($Query->num_rows()==0){
            $this->db->from('parking_allocation as ac');
            $this->db->join('parking as p','ac.parking=p.id');

           $where = "(ac.status='1' OR ac.status='2') AND ac.from_date<='$from_date' AND (ac.to_date>='$to_date' OR ac.to_date='0000-00-00')";
           $this->db->where($where);

            /*$this->db->where('ac.status',1);
            $this->db->or_where('ac.status',2);
            $this->db->where('ac.from_date<=',$from_date);
            $this->db->where('ac.to_date>=',$to_date);
            $this->db->or_where('ac.to_date','0000-00-00'); */

            $data['reports']= $this->db->get()->result_array();
           //print_r($data['reports']);exit;

            foreach($data['reports'] as $key=>$val){

                $group= $this->Parkinginfo->get_parking_group($val['parking_group']);
                $persons=$this->Commoninfo->str_pad_left($val['contract_no'],2);
                $contract_no=$group['name']."-".$val['name']."-".$persons;

               $post_data=array('userid'=>$val['user'], 'parking'=>$val['parking'], 'from_date'=>$from_date,'contract_no'=>$contract_no, 'to_date'=>$to_date,'create_date'=>$today, 'amount'=>$val['amount']);
               $this->db->insert('trans',$post_data);
            }
        }
    }

    function get_column_pdf()
    {
        return array('S.No','PIN','Name','Post No','Post Ort','Amount','From Date','To Date');
    }

    function get_trans($year,$month,$day)
    {
        $dat=$year."-".$month."-".$day;
       // $this->db->like('from_date',$date);
        $search_date=date('Y-m-d',strtotime($dat));
        $this->db->select('trans.*,p.id as parking_id,p.name as parking_name,p.type as parking_type,ad.firstname,ad.lastname,ad.address,ad.pin,ad.post_no,ad.post_ort,ad.apartment_no as apartment');
        //`id`, `email`, `mobile`, `password`, `firstname`, `lastname`, `apartment_no`, `pin`, `post_no`, `post_ort`, `address`, `status`, `first_login`, `queue`, `total_parking`
        $this->db->from('trans');
        $this->db->join('parking as p','trans.parking=p.id');
        $this->db->join('admin as ad','trans.userid=ad.id');
        $this->db->where('create_date',$search_date);
        $this->db->order_by('trans.id','asc');
        return $this->db->get()->result_array();
    }

    function  get_reports()
    {
       $this->db->select('from_date,create_date');

       //$this->db->order_by('from_date');
       $this->db->group_by('create_date');
       $this->db->order_by('id','desc');
       return $this->db->get('trans')->result_array();
    }

}