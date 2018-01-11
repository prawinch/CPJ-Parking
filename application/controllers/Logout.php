<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function index()
    {
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('firstname');
        $this->session->sess_destroy();
        redirect('login','refresh');
    }
}
