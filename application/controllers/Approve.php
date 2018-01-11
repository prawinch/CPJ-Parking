<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include_once()

class Approve extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if (! $this->session->userdata('uid'))
        {
            redirect('login');
        }
        //       $this->load->library('../controllers/queue');


        $this->lang->load('common',$this->session->userdata('lang'));
    }

    public function index()
    {
        //$this->queue->checktest(); exit;

        $data['h']=$this->Allocationinfo->get_parking_waiting_confirmation();
        $data['headers']=$this->Commoninfo->get_headers_approve();
        $data['parking_type']=$this->Parkinginfo->parking_type();
        //Parking Status
        $data['parking_status']=$this->Parkinginfo->parking_status();
        $this->load->view('approve/view', $data);
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

    function confirm($id,$approve_id)//Approve confirm flow
    {

        $row_approve=$this->Allocationinfo->get_approve_info($approve_id);

      //  $start_date=date('Y-m-d',strtotime($row_approve->to_date."+1 days"));
        $start_date=$row_approve->from_date;

        $reg_data=array('parking'=>$row_approve->parking,'approve'=>'1','user'=>$row_approve->user,'from_date'=>$start_date);
        $this->Allocationinfo->save(-1,$reg_data); // Parking Confirmation



        $row=$this->Allocationinfo->get_approve_info($approve_id);
        //$parking_type=$parking_info->type;
        $user_info = $this->Reginfo->get_info($row->user);

       // $start_date=date('Y-m-d',strtotime($row->to_date."+1 days"));
        $fdate=$row->from_date;
        $edate=($row->to_date=='0000-00-00')?'':$row->to_date;

        $username=$user_info->firstname." ".$user_info->lastname;
        $to=$user_info->email;

        $parking_info = $this->Parkinginfo->get_info($row->parking);
        $parking_name=$parking_info->name;
        $persons=$parking_info->used_persons+1;
        $contract_no=$this->Commoninfo->str_pad_left($persons,2);

        $parking_types=$this->Parkinginfo->parking_type();
        $park_type=$parking_types[$parking_info->type];

        $table=$this->lang->line('dear')." ".$username.",";
        $table.="<br><br>";
        $table.=$this->lang->line('contract_sign').' '.$park_type." - ".$parking_name. ". ".$this->lang->line('parking_start_from')." ".$fdate;

        $table.="<br><br>";
        $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


        $subject=$this->lang->line('parking_confirmed');

        // echo $table;     echo "<br>".$subject;        echo "<br>".$to; echo "<br>"; exit;
         $this->send_mail_message($table,$subject,$to);
        //Allocation

        $this->db->where('id',$parking_info->id)->update('parking',array('used_persons'=>$contract_no));
        $this->db->where('id',$id)->update('parking_allocation',array('approve'=>1,'contract_no'=>$contract_no));

        //Billing Company Mail Send

        $table='';
        $subject=$this->lang->line('biiling_confirm_subject');
        $table="<table>";
        $table .= '<tr><td>'.$this->lang->line('user').'</td><td>:</td><td>'.$username.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('personal_number').'</td><td>:</td><td>'.$user_info->pin.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_name').'</td><td>:</td><td>'.$parking_name.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_type').'</td><td>:</td><td>'.$park_type.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('start_from').'</td><td>:</td><td>'.$fdate.'</td></tr>';
        $table .= '</table>';
        $table.="<br><br>";
        $table.=$this->lang->line('billing_details');
        $this->send_mail_message($table,$subject,ACCOUNTS_MAIL);

        $this->session->set_flashdata('msg',$this->lang->line('approve_confirm_messge'));


        $this->db->where('id', $approve_id);
        $this->db->delete('parking_approve');
        redirect('approve');
    }

    function cancel($id,$approve_id)//Approve Decline flow
    {
        $row=$this->Allocationinfo->get_approve_info($approve_id);

        //   $parking_type=$parking_info->type;
        $user_info = $this->Reginfo->get_info($row->user);
        $fdate=$row->from_date;
        $edate=($row->to_date=='0000-00-00')?'':$row->to_date;

        $username=$user_info->firstname." ".$user_info->lastname;
        $to=$user_info->email;


        $parking_info = $this->Parkinginfo->get_info($row->parking);
        $parking_name=$parking_info->name;

        $parking_types=$this->Parkinginfo->parking_type();
        $park_type=$parking_types[$parking_info->type];

        $parking_details=$parking_name. " - ".$park_type;

        $table=$this->lang->line('dear')." ".$username.",";
        $table.="<br><br>";
        $table.=str_replace('<parking_no>',$parking_details,$this->lang->line('parking_decline'));

        $table.="<br><br>";
        $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


        $subject=$this->lang->line('confirm_parking_cancel');

      //   echo $table;     echo "<br>".$subject;        echo "<br>".$to; echo "<br>";
        $this->send_mail_message($table,$subject,$to);
        //Allocation

     //   $this->db->where('id',$id)->update('parking_allocation',array('approve'=>2));

        //Billing Company Mail Send

      /*  $table='';

        $subject=$this->lang->line('biiling_decline_subject');

        $table=$this->lang->line('billing_cancel');
        $table.="<br><br>";

        $table.="<table>";
        $table .= '<tr><td>'.$this->lang->line('user').'</td><td>:</td><td>'.$username.'</td></tr>';

        $table .= '<tr><td>'.$this->lang->line('personal_number').'</td><td>:</td><td>'.$user_info->pin.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_name').'</td><td>:</td><td>'.$parking_name.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_type').'</td><td>:</td><td>'.$park_type.'</td></tr>';
        $table .= '</table>';
        //$table.="<br><br>";
        $this->send_mail_message($table,$subject,ACCOUNTS_MAIL);

        $this->session->set_flashdata('msg',$this->lang->line('approve_cancel_messge')); */

        $this->cancel_parking($id,$redirect=2); //Cancel Parking to allocation members


        $this->db->where('id', $approve_id);
        $this->db->delete('parking_approve');
       redirect('approve');

    }



    function cancel_parking($id,$redirect=0)//Decline Parking cancel allocation to queue members
    {
        $alloc_park=$this->Allocationinfo->get_parking_alloc($id);

        $alloc_from_date=$alloc_park['from_date'];
        //$next_month_end = date('Y-m-d',strtotime("last day of next month"));
        //$next_month_end = date('Y-m-d');
      // $this->db->where('id',$id)->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'2'));

        $get_user=$this->db->where('id',$id)->get('parking_allocation')->row_array();
        $user_info=$this->Reginfo->get_info($get_user['user']);
        $name=$user_info->firstname." ".$user_info->lastname;

        //Allocation
        $alloc_info=$this->Allocationinfo->get_parking_alloc($id);

        $result= $this->Queueinfo->get_queue_user_parked($alloc_info['user']);

        foreach($result as $key=>$val){
            $to_date=date('Y-m-d 23:59:59', strtotime("+".ALLOC_DAYS." days"));
            $reg_data=array(
                'parking'=>$alloc_info['parking_id'],
                'userid'=>$val['userid'],
                'position'=>$val['position'],
                'from_date'=>date('Y-m-d H:i:s'),
                'to_date'=>$to_date);

            $this->Trackinginfo->alloc_save($reg_data,-1);

            $que_data=array(
                'position_status'=>2
            );

            $alloc_park_id=$alloc_info['parking_id'];
            $alloc_position=$val['position'];

            $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update

            $table=$this->lang->line('dear')." ".$val['firstname'].",";
            $table.="<br><br>";
            $table.=$this->lang->line('your_allocation').' '.$alloc_info['parking_name'];

            $table.="<br><br>";
            $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


            $table.="<br><br>";
            $table.=REGARDS."<br>";
            $table.=ADMIN_NAME;

            //echo "message".$table." to".$val['email']; echo '<br>';
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->from(ADMIN_MAIL); // change it to yours
            $this->email->to($val['email']); // change it to yours
            $this->email->subject($this->lang->line('queue_details_parking'));
            $this->email->message($table);
            if($this->email->send())
            {
              //  echo 'Email sent.';
            }
        }
        // exit;
        $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));


        $this->session->set_flashdata('msg', $this->lang->line('parking_cancel_admin'));

          //  redirect('approve');


    }


    function send_mail_message($message,$subject,$to)
    {
        $message.="<br><br>";
        $message.=REGARDS."<br>";
        $message.=ADMIN_NAME;

        echo "<br>Subject ".$subject;        echo "<br> To".$to; echo "<br>"; echo "Message ".$message; echo "<br>";

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from(ADMIN_MAIL); // change it to yours
        $this->email->to($to); // change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send())
        {
            return true;
        }
    }



}
