<?php
class Passwordinfo extends CI_Model
{



    /*
	Gets information about a particular customer
	*/
    function get_info($table,$id)
    {
        $this->db->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();

        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $customer_id is NOT an customer
            // $person_obj=parent::get_info($table,-1);

            //create object with empty properties.
            $fields = $this->db->list_fields($table);
            $person_obj = new stdClass;

            foreach ($fields as $field)
            {
                $person_obj->$field='';
            }

            return $person_obj;
        }
    }


    /*    Inserts or updates a item    */
    function save(&$post_data,$admin_id)
    {

        $success=false;
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        if ($admin_id==-1)
        {
            $success = $this->db->insert('admin',$post_data);
        }
        else
        {
            $this->db->where('id', $admin_id);
            $success = $this->db->update('admin',$post_data);
        }

        $this->db->trans_complete();
        return $success;

    }



}
?>
