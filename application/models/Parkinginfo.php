<?php
class Parkinginfo extends CI_Model
{
    function insert_admin($data)
    {
        return $this->db->insert('admin', $data);
    }
    function save($id=-1,$data)
    {

        if ($id == -1) {
            return $this->db->insert('parking', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('parking', $data);
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


    function get_info($id)
    {
        $this->db->from('parking');
        $this->db->where('id',$id);

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
            $fields = $this->db->list_fields('parking');

            foreach ($fields as $field)
            {
                $item_obj->$field='';
            }

            return $item_obj;
        }
    }

    function parking_status()
    {
        return array($this->lang->line('waiting'),$this->lang->line('confirmed'),$this->lang->line('cancel'),$this->lang->line('closed'));
    }

    function parking_type()
    {
        return array('','MC -Plats','Garage','Carport','P-plats');
    }


    function parking_group()
    {

        $this->db->order_by('id','asc');
        $query = $this->db->get('parking_group');
        //   echo $this->db->last_query();
        return $query->result_array();

    }
    function get_parking_group($id)
    {
        $this->db->where('id', $id);
        $this->db->order_by('id','asc');
        $query = $this->db->get('parking_group');
        return $query->row_array();

    }
    function get_parking_count($status)
    {
        return $this->db->where('booking_status',$status)->get('parking')->num_rows();
    }

}