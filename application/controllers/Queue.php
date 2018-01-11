<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if (! $this->session->userdata('uid'))
        {
            redirect('login');
        }
        $this->lang->load('common',$this->session->userdata('lang'));
    }

    public function index()
    {
        $data['h']=$this->Queueinfo->list_select();
        $data['headers']=$this->Commoninfo->get_headers_queue();

        $this->load->view('queue/view', $data);
    }

    function add($id=-1)
    {
        $data['parking_info']   =   $this->Queueinfo->parking_info();
        $data['user_info']      =   $this->Queueinfo->get_info($id);
        $data['status']      =   $this->Queueinfo->get_status();

        $this->load->view("allocation/form",$data);
    }

    function edit($id=-1)
    {
        $data['alloc_info']=$this->Queueinfo->get_allocation_info($id);
        $data['status']      =   $this->Queueinfo->get_status();

        $this->load->view("allocation/edit",$data);
    }

    function save($id=-1)
    {
        $reg_data=array();

        foreach($_POST as $key=>$value)
        {
            if (in_array($key, $this->Reginfo->post_array()))
                continue;
            $reg_data[$key] = $value;
        }

        $data['listing_info']=$this->Queueinfo->get_info($id);

        if($id=='-1')
        {
            $this->db->where('id',$this->input->post('parking'))->set(array('booking_status'=>'1'))->update('parking');
            $this->Queueinfo->save($id,$reg_data);
            $this->session->set_flashdata('msg','Added Allocation Successfully');
            redirect('queue');
        }

        else
        {
            $this->Queueinfo->save($id,$reg_data);
            $this->session->set_flashdata('msg','Updated Allocation Successfully');
            redirect('queue');
        }
    }

    function delete_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admin');
        $this->session->set_flashdata('delete_message', 'Your data deleted Successfully..');
        redirect('registration');
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }



    function register_parking_exists()
    {
        if (array_key_exists('name',$_POST)) {
            if ( $this->parking_exists($this->input->post('name')) == TRUE ) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }

    }

    function parking_exists($col)
    {
        $this->db->where('name', $col);

        $query = $this->db->get('parking');
        if( $query->num_rows() > 0 ){ return TRUE; } else { return FALSE; }
    }



   function checktest()
   {
       echo "calling queue controller";
   }





}
