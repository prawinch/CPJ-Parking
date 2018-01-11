<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if (!$this->session->userdata('uid'))
        {
            redirect('login');
        }

        $this->lang->load('common',$this->session->userdata('lang'));
    }

    public function index()
    {

        $data['h']=$this->Reginfo->admin_select();
        $data['queue_headers']=$this->Commoninfo->get_queue_headers_dashboard();
        $data['parking_headers']=$this->Commoninfo->get_parking_headers_dashbard();

        $data['parking_type']=$this->Parkinginfo->parking_type();
        $data['queue_list']=$this->Queueinfo->list_select(10);

        //Approve List
        $data['approve_result']=$this->Allocationinfo->get_parking_waiting_confirmation();
        $data['approve_headers']=$this->Commoninfo->get_headers_approve_dashboard();
        //Parking Status
        $data['parking_status']=$this->Parkinginfo->parking_status();

        $this->load->view('dashboard/view', $data);
    }

    function lang($lang,$url)
    {
        $this->session->set_userdata('lang',$lang);
        $this->lang->load('common',$this->session->userdata('lang'));
        redirect($url);
    }

    function lang_select()
    {
        $this->session->unset_userdata('lang');
        $lang= $this->input->post('val');
        echo $lang;
        $this->session->set_userdata('lang', $lang);
        redirect('registration');
    }


}
