<?php
class Reginfo extends CI_Model
{


    function get_superadmin($email, $pwd)
    {
        $this->db->or_where('email', $email);
        $this->db->or_where('apartment_no', $email);
        $this->db->where('password', $pwd);
        $query = $this->db->get('admin');
        echo $this->db->last_query();
        return $query->result();
    }

    function get_admin($email, $pwd)
    {
        $this->db->or_where('email', $email);
        $this->db->or_where('apartment_no', $email);
        $this->db->where('password', $pwd);
        $query = $this->db->get('superadmin');
        return $query->result();
    }

    // get user
    function get_superadmin_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('superadmin');
        return $query->result();
    }
    function insert_admin($data)
    {
        return $this->db->insert('admin', $data);
    }

    function post_array()
    {
        $blocked_array=array('submit','rowid');
        return $blocked_array;

    }

    function get_admin_access()
    {
        return array('1','181','182');
    }


    function saveadmin($id=-1,$data)
    {

         if ($id == -1) {
            return $this->db->insert('admin', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('admin', $data);
        }
    }
    function admin_select()
    {
        $query = $this->db->get('admin');
        return $query;
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
    function get_info($id)
    {
        $this->db->from('admin');
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
            $fields = $this->db->list_fields('admin');

            foreach ($fields as $field)
            {
                $item_obj->$field='';
            }

            return $item_obj;
        }
    }


    function random_string($length = 8){
        $str = '';
        $base = '0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/';
        $i = 0;
        while($i < $length){
            $char = substr($base, mt_rand(0, strlen($base) -1 ), 1);
            if(!strstr($str, $char)){
                $str .= $char;
                $i++;
            }
        }
        return $str;
    }

    function base64decode($code){
        return $this->base64decode(base64_encode($code));
    }


    function base64encode($code){
        return base64_encode(base64_encode($code));
    }


}