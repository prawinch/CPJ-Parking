<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

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
        $data['headers']=$this->Commoninfo->get_headers_users();
        $this->load->view('registration/admin_view', $data);
    }

    function admin_add($id=-1)
    {
            $reg_data=array();
            foreach($_POST as $key=>$value  )
            {
                if (in_array($key, $this->Reginfo->post_array()))
                    continue;
                $reg_data[$key] = $value;
            }
            $data['admin_info']=$this->Reginfo->get_info($id);

            if($id=='-1')
            {
                $this->load->library('email');
                $randomString=$this->Reginfo->random_string();
                // $reg_data['address']=$randomString;
                $reg_data['password'] = $this->base64encode($randomString);
                $this->Reginfo->saveadmin($id,$reg_data);

                $to=$this->input->post('email');
                $name=$this->input->post('firstname'). "  ".$this->input->post('lastname');

                $table=$this->lang->line('dear')." ".$name.",";

                $table.="<br><br>";

                $table.='<html><body><table>
                <tr><th style="text-align:left">'.$this->lang->line('username').'</th><td>'.$to.'</td></tr>
                <tr><th style="text-align:left">'.$this->lang->line('password').'</th><td>'.$randomString.'</td></tr>
                </table></body><html>';

                $table.=$this->lang->line('click_here_to').' <a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


                $table.="<br><br>";
                $table.=REGARDS."<br>";
                $table.=ADMIN_NAME;


                $this->email->set_newline("\r\n");
                $this->email->set_mailtype("html");
                $this->email->from('info@cpjtechnosolutions.com'); // change it to yours
                $this->email->to($to); // change it to yours
                $this->email->subject($this->lang->line('login_details'));
                $this->email->message($table);
                if($this->email->send())
                {
                    echo 'Email sent.';
                }


                $this->session->set_flashdata('msg',$this->lang->line('user_add_success'));
                redirect('registration');
            }
            else
            {
                $this->Reginfo->saveadmin($id,$reg_data);
                $this->session->set_flashdata('msg',$this->lang->line('user_update_success'));
                redirect('registration');
            }
        }


    function admin_edit($id)
    {
        $this->data['edit_admin']= $this->Reginfo->edit_admin($id);
        $this->load->view('registration/form', $this->data, FALSE);
    }
    function email_exists($col)
    {
        $this->db->where('email', $col);

        $query = $this->db->get('admin');
        if( $query->num_rows() > 0 ){ return TRUE; } else { return FALSE; }
    }

    function email_check($col,$id)
    {
        $this->db->where('email', $col);
        $this->db->where('id <>',$id);
        $query = $this->db->get('admin');
        if( $query->num_rows() > 0 ){ return TRUE; } else { return FALSE; }
    }

    function register_email_exists()
    {
        if (array_key_exists('email',$_POST)) {
            if ( $this->email_exists($this->input->post('email')) == TRUE ) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }
    }


    function register_email_check()
    {
        if (array_key_exists('email',$_POST)) {
            if ( $this->email_check($this->input->post('email'),$this->input->post('id')) == TRUE ) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }
    }





    function register_apartment_exists()
    {
        if (array_key_exists('apartment_no',$_POST)) {
            if ( $this->aparment_exists($this->input->post('apartment_no')) == TRUE ) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }

    }

    function aparment_exists($col)
    {
        $this->db->where('apartment_no', $col);
        $query = $this->db->get('admin');
        if( $query->num_rows() > 0 ){ return TRUE; } else { return FALSE; }
    }

    function update_data($id)
    {
        $data = array(
            'firstname'=> $this->input->post('firstname'),
            'lastname'=>$this->input->post('lastname'),
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('mobile'),
            'password'=>$this->input->post('password')
            );
        $this->db->where('id', $id);
        $this->db->update('admin', $data);
        $this->session->set_flashdata('message', 'Your data updated Successfully..');
        redirect('registration');
    }
    function delete_data($id)
    {
        if($this->Commoninfo->get_count_id('queue','userid',$id)=="0" && $this->Commoninfo->get_count_id('alloc','userid',$id)=="0" && $this->Commoninfo->get_count_id('parking_allocation','user',$id)=="0" &&
        $this->Commoninfo->get_count_id('trans','userid',$id)=="0")
        {
            $this->db->where('id', $id);
            $this->db->delete('admin');
            $this->session->set_flashdata('delete_message', $this->lang->line('delete_message'));
        }else{

            $this->session->set_flashdata('delete', $this->lang->line('no_user_delete'));
        }

        redirect('registration');
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    function add($id=-1)
    {
        $data['admin_info']=$this->Reginfo->get_info($id);
        $this->load->view("registration/form",$data);
    }

    function edit($id=-1)
    {
        $data['admin_info']=$this->Reginfo->get_info($id);
        $this->load->view("registration/edit",$data);
    }


    function base64decode($code){
        return $this->base64decode(base64_encode($code));
    }
    function base64encode($code){
        return base64_encode(base64_encode($code));
    }



}
