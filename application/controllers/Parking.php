<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parking extends CI_Controller {

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
        $data['status']=$this->Parkinginfo->parking_status();
    }

    public function index()
    {
        $data['parking_type']=$this->Parkinginfo->parking_type();
        $data['headers']=$this->Commoninfo->get_headers_parking();
        $data['h']=$this->Parkinginfo->list_select();
        $this->load->view('parking/view', $data);
    }

    function add($id=-1)
    {

        $data['parking_group']=$this->Parkinginfo->parking_group();
        $data['parking_type']=$this->Parkinginfo->parking_type();
        $data['listing_info']=$this->Parkinginfo->get_info($id);
        $this->load->view("parking/form",$data);
    }

    function edit($id=-1)
    {

        $data['parking_group']=$this->Parkinginfo->parking_group();
        $data['parking_type']=$this->Parkinginfo->parking_type();
        $data['listing_info']=$this->Parkinginfo->get_info($id);
        $this->load->view("parking/edit",$data);
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

        $data['listing_info']=$this->Parkinginfo->get_info($id);

        if($id=='-1')
        {
            $this->Parkinginfo->save($id,$reg_data);
            $this->session->set_flashdata('msg',$this->lang->line('park_add_success'));
            redirect('parking');
        }

        else
        {
            $this->Parkinginfo->save($id,$reg_data);
            $this->session->set_flashdata('msg',$this->lang->line('park_update_success'));
            redirect('parking');
        }
    }

    function delete($id)
    {
        if($this->Commoninfo->get_count_id('alloc','parking',$id)=="0" && $this->Commoninfo->get_count_id('parking_allocation','parking',$id)=="0" &&
            $this->Commoninfo->get_count_id('trans','parking',$id)=="0")
        {
            $this->db->where('id', $id);
            $this->db->delete('parking');
            $this->session->set_flashdata('delete_message', $this->lang->line('delete_success'));
        }else{

            $this->session->set_flashdata('delete', $this->lang->line('parking_delete'));
        }

        redirect('parking');
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
