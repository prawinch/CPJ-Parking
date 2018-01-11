<?php
class Trackinginfo extends CI_Model
{
    function insert_admin($data)
    {
        return $this->db->insert('admin', $data);
    }

    function save($data,$id)
    {
        if ($id == -1) {
            return $this->db->insert('queue', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('queue', $data);
        }
    }

    function edit_admin($id){
        $query=$this->db->query("SELECT * FROM admin WHERE id = $id");
        return $query->result_array();
    }
    function get_info_admin($id)
    {
        $query=$this->db->query("SELECT * FROM admin WHERE id = $id");
        return $query->result_array();
    }

    function list_select()
    {
        $query = $this->db->get('parking');
        return $query;
    }

    function get_status()
    {
        return array('',$this->lang->line('waiting_queue'),$this->lang->line('parking_allocated'),$this->lang->line('confirmed'));
    }

    function get_user_queue($tbl,$id)
    {
        $this->db->from($tbl);
        $this->db->where('userid',$id);
        $query = $this->db->get();
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj=new stdClass();
            //Get all the fields from items table
            $fields = $this->db->list_fields('queue');

            foreach ($fields as $field)
            {
                $item_obj->$field='';
            }

            return $item_obj;
        }
    }


    function update_user_queue($id)
    {
        $result=$this->get_user_queue('queue',$id);
        $this->db->where('position >', $result->position);
        $this->db->set('position', '`position`- 1', FALSE);
        $this->db->update('queue');
    }


    function update_user_queue_status($id)
    {
        $result=$this->get_user_queue('queue',$id);
        $this->db->where('position >', $result->position);
        $this->db->set(array('position'=>'`position`- 1','position_status'=>1));
        $this->db->update('queue');
    }

    function get_queue()
    {
        $this->db->order_by('position','asc');
        $query= $this->db->get('queue');
        return $query->result_array();
    }

    function alloc_save($data,$id=-1)
    {
        if ($id == -1) {
            return $this->db->insert('alloc', $data);
        } else {
            $this->db->where('userid', $id);
            return $this->db->update('alloc', $data);
        }
    }

    function alloc_save_parking($data,$parking,$id=-1)
    {
        if ($id == -1) {
            return $this->db->insert('alloc', $data);
        } else {
            $this->db->where('userid', $id);
            $this->db->where('parking',$parking);
            return $this->db->update('alloc', $data);
        }
    }


    function get_alloc($id)
    {
        $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,p.type as park_type,pc.to_date as end_date');
        $this->db->from('alloc as ac');
        $this->db->join('parking as p','ac.parking=p.id');
        $this->db->join('parking_allocation as pc','ac.parking=pc.parking');
        $this->db->where('ac.userid',$id);
        $this->db->where('pc.status','2');
        $query=$this->db->get();
        return $query->result_array();
    }

    function save_queue($data,$id)
    {
        if ($id == -1) {
            return $this->db->insert('queue', $data);
        } else {
            $this->db->where('userid', $id);
            return $this->db->update('queue', $data);
        }
    }

    function save_change($data,$id=0)
    {
        if ($id == -1) {
            return $this->db->insert('change_parking', $data);
        } else {
            $this->db->where('userid', $id);
            return $this->db->update('change_parking', $data);
        }
    }

    function get_alloc_confirmed_users($user,$parking)
    {

        return $this->db->where(array('parking'=>$parking,'userid'=>$user,'status'=>'0'))->get('alloc')->num_rows();
    }
    function get_changes_parking_count($user,$parking)
    {

        return $this->db->where(array('parking_id'=>$parking,'userid'=>$user,'status'=>'0'))->get('change_parking')->num_rows();
    }

/*foreach ($h as $key=>$row)
{
$user_info = $CI->Reginfo->get_info($row['userid']);
$username=ucfirst($user_info->firstname)." ".ucfirst($user_info->lastname);
$status=$CI->Trackinginfo->get_status();
echo '<tr><td>'.$i.'</td>
                        <td>'.$username.'</td>
                        <td>'.$row['position'].'</td>
                        <td>'.$status[$row['position_status']].'</td>
                        <td>'.$row['time'].'</td>'; */

}