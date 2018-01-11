<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation extends CI_Controller {

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

        $data['h']=$this->Allocationinfo->list_select();
        $data['headers']=$this->Commoninfo->get_headers_allocation();

        //Parking Status
        $data['parking_status']=$this->Parkinginfo->parking_status();
        $this->load->view('allocation/view', $data);
    }

    function add($id=-1)
    {
        $data['parking_info']   =   $this->Allocationinfo->parking_info();
        $data['user_info']      =   $this->Allocationinfo->get_info($id);
        $data['status']      =   $this->Allocationinfo->get_status();

        $this->load->view("allocation/form",$data);
    }

    function edit($id=-1)
    {
        $data['alloc_info']=$this->Allocationinfo->get_allocation_info($id);
        $data['status']    =   $this->Allocationinfo->get_status();

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

        $data['listing_info']=$this->Allocationinfo->get_info($id);

        if($id=='-1')
        {
            $this->db->where('id',$this->input->post('parking'))->set(array('booking_status'=>'1'))->update('parking');
            $reg_data['status'] = '1';
            $this->Allocationinfo->save($id,$reg_data);
            $this->session->set_flashdata('msg',$this->lang->line('allocation_add_success'));
            redirect('allocation');
        }

        else
        {
            $this->Allocationinfo->save($id,$reg_data);
            $this->session->set_flashdata('msg',$this->lang->line('allocation_update_success'));
            redirect('allocation');
        }
    }

    function delete_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admin');
        $this->session->set_flashdata('delete_message', $this->lang->line('allocation_delete_success'));
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

}
