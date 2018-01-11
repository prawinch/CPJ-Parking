<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    function __construct()
    {
        parent::__construct();

        //Make sure the report is not cached by the browser
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        if(!$this->session->userdata('uid'))
        {
            redirect('login');
        }

        $this->lang->load('common',$this->session->userdata('lang'));
    }

    public function index()
    {
        $data['password']=$this->db->where('id',$this->session->userdata('uid'))->select('password')->from('admin')->get()->row_array();
        $this->load->view('password/form',$data);
    }


    function save()
    {

        $post_data['password'] =$this->base64encode($this->input->post('npassword'));

        if($this->Passwordinfo->save($post_data,$this->session->userdata('uid')))
        {
            $this->session->set_flashdata('message', $this->lang->line('password_update'));
            //$this->load->view('registration');
            redirect('password');
        }
        else{
            $this->session->set_flashdata('danger', 'Please Fill Required Details');
            $this->load->view('password');
        }
    }


    function base64decode($code){
        return $this->base64decode(base64_encode($code));
    }
    function base64encode($code){
        return base64_encode(base64_encode($code));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */