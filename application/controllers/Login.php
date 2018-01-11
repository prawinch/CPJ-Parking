<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));

        $this->session->set_userdata('lang','sw');
        $this->lang->load('common',$this->session->userdata('lang'));
    }
    public function index()
    {
        $email = $this->input->post("username");
        $password = $this->input->post("password");

        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "Password", "required");



        if ($this->form_validation->run() == FALSE)
        {
            // validation fail
            $this->load->view('login/form');
        }
        else
        {
            // check for user credentials
            $uresult = $this->Reginfo->get_superadmin($email, $this->Reginfo->base64encode($password));
          //  exit;
            if (count($uresult) > 0)
            {


                $this->lang->load('common',$this->session->userdata('lang'));
                $sess_data = array('login' => TRUE, 'name' => ucfirst($uresult[0]->firstname),'lastname' => ucfirst($uresult[0]->lastname), 'email' => $uresult[0]->email,'uid' => $uresult[0]->id);
                $this->session->set_userdata($sess_data);
                if(in_array($this->session->userdata('uid'),$this->Reginfo->get_admin_access()))
                redirect("dashboard");
                else
                {
                    if($uresult[0]->first_login==0)
                    {
                        $this->db->where('id',$uresult[0]->id)->update('admin',array('first_login'=>'1'));
                        redirect('password');
                    }else{

                        redirect("tracking");
                    }
                }
            }
            else
            {
                $this->session->set_flashdata('msg', '<strong>'.$this->lang->line('invalid_credentials').'</strong>');
                redirect('login');
            }
        }
    }



}
