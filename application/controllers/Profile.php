<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
        $data['admin_info']=$this->Reginfo->get_info($this->session->userdata('uid'));
        $this->load->view("profile/edit",$data);
    }

    function admin_add()
    {

        $this->lang->load('common',$this->session->userdata('lang'));

        $reg_data=array();
       $id= $this->session->userdata('uid');

        foreach($_POST as $key=>$value  )
        {
            if (in_array($key, $this->Reginfo->post_array()))
                continue;
            $reg_data[$key] = $value;
        }

        $data['admin_info']=$this->Reginfo->get_info($id);

            $this->Reginfo->saveadmin($id,$reg_data);
            $this->session->set_flashdata('msg','Msg Update');
            redirect('profile');

    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

}
