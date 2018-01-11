<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if (! $this->session->userdata('uid'))
        {
            redirect('login');
        }

        date_default_timezone_set('Europe/Stockholm');
       // $this->lang->load('common','sw');
        $this->lang->load('common',$this->session->userdata('lang'));
     }

    public function index()
    {

       // Europe/Stockholm

        $data['parking_type']=$this->Parkinginfo->parking_type();
        $data['status_info']=$this->Trackinginfo->get_status();
        $data['alloc_headers']=$this->Commoninfo->get_headers_alloted();
        $data['alloc_headers_parking']=$this->Commoninfo->get_headers_parking_confirm();



        $data['userid']=$this->session->userdata('uid');
        $this->load->view("tracking/form",$data);
       /* $data['h']=$this->Parkinginfo->list_select();
        $this->load->view('parking/view', $data); */
    }

    function add($id=-1)
    {
        $data['listing_info']=$this->Parkinginfo->get_info($id);
        $this->load->view("parking/form",$data);
    }

    function edit($id=-1)
    {
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

    function position($pos){
        $reg_data=array();
        date_default_timezone_set('Europe/Stockholm');
      //  $position=$this->db->max('')
        $this->db->select_max('position');
        $result = $this->db->get('queue')->row();
        $position= $result->position+1;
        $reg_data['userid']=$this->session->userdata('uid');
        $reg_data['position']=$position;
        $reg_data['created_on']=date('Y-m-d H:i:s');
        $reg_data['time']=date('Y-m-d H:i:s');
        $reg_data['position_status']=1;
      //  print_r($reg_data); exit;
        $this->Trackinginfo->save($reg_data,$id=-1);


        $get=$this->db->where('userid',$this->session->userdata('uid'))->select('time')->get('queue')->row();

        $table=$this->lang->line('dear')." ".$this->session->userdata('name').",";
        $table.="<br><br>";
        $table.=$this->lang->line('you_start_queue').' '.$get->time;
        $table.="<br><br>";
        $table.='<a href="'.base_url().'"> '.$this->lang->line('login_here').'</a>';


        $table.="<br><br>";
        $table.=REGARDS."<br>";
        $table.=ADMIN_NAME;


        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from(ADMIN_MAIL); // change it to yours
        $this->email->to($this->session->userdata('email')); // change it to yours
        $this->email->subject($this->lang->line('queue_details_parking'));
        $this->send_mail_message($table,$this->lang->line('queue_details_parking'),'developertest@mailinator.com');
        $this->email->message($table);

        if($this->email->send())
        {
        }
        $this->session->set_flashdata('msg',$this->lang->line('status_update'));
        redirect('tracking');
    }

    function quit(){
        date_default_timezone_set('Europe/Stockholm');

        $this->Trackinginfo->update_user_queue($this->session->userdata('uid'));
        $this->db->where('id',$this->session->userdata('uid'))->update('admin',array('queue'=>0));

        $this->db->where('userid', $this->session->userdata('uid'));
        $this->db->delete('queue');
       //Remove from Allocation
        $this->db->where('userid',$this->session->userdata('uid'))->delete('alloc');

        //Cancel Mail send
        $table=$this->lang->line('dear')." ".$this->session->userdata('name').",";
        $table.="<br><br>";
        $table.=$this->lang->line('queue_cance_msg')." ".date('Y-m-d H:i:s');



        $to=$this->session->userdata('email'); // change it to yours
        $subject=$this->lang->line('queue_cancel_parking');

        //echo $table;     echo "<br>".$subject;        echo "<br>".$to;exit;
        $this->send_mail_message($table,$subject,$to);
        //Allocation



        $this->session->set_flashdata('msg',$this->lang->line('quit_from_queue'));
        redirect('tracking');
    }

    function alloc_confirm($parking) //Allocatin Confirm
    {
        $reg_data=array(
            'alloc_date'=>date('Y-m-d H:i:s'),
            'status'=>1);
        $this->Trackinginfo->alloc_save_parking($reg_data,$parking,$this->session->userdata('uid'));

        $this->session->set_flashdata('msg', $this->lang->line('allocation_confirmed_message'));
        redirect('tracking');
    }

    function alloc_cancel($parking)
    {
        $this->db->where(array('userid'=>$this->session->userdata('uid'),'parking'=>$parking))->delete('alloc');
        $reg_data=array('position_status'=>1);


        if($this->is_allocation($parking,$this->session->userdata('uid'))==FALSE)
        $this->Trackinginfo->save_queue($reg_data,$this->session->userdata('uid'));


        $this->session->set_flashdata('msg', $this->lang->line('allocation_decline_success'));
        redirect('tracking');
    }

    function is_allocation($parking,$userid)
    {
        $this->db->where('parking <>',$parking);
        $this->db->where('userid',$userid);
        $query=$this->db->get('alloc');
            if($query->num_rows()>0)
                return true;
            else
                return false;
    }

    function cancel_admin($id,$redirect=0)
    {
        $alloc_park=$this->Allocationinfo->get_parking_alloc($id);

        $alloc_from_date=$alloc_park['from_date'];
        //$next_month_end = date('Y-m-d',strtotime("last day of next month"));
        $next_month_end = date('Y-m-d');
        $this->db->where('id',$id)->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'3'));

        $get_user=$this->db->where('id',$id)->get('parking_allocation')->row_array();
        $user_info=$this->Reginfo->get_info($get_user['user']);
        $name=$user_info->firstname." ".$user_info->lastname;


        $parking_info=$this->Parkinginfo->get_info($alloc_park['parking_id']); //get parking details
        $parking_types=$this->Parkinginfo->parking_type(); //get parking types



        $cancel_date=date('Y-m-d', strtotime($next_month_end."+1 days"));
        //Parking Cancel Mail send
        $table=$this->lang->line('dear')." ".$name.",";
        $table.="<br><br>";

        $table.=$this->lang->line('parking_name'). " ".$parking_info->name." ";
        $table.="<br><br>";
        $table.=$this->lang->line('parking_type'). " ".$parking_types[$parking_info->type]." ";
        $table.="<br><br>";
        $table.=$this->lang->line('your_parking_will_be_cancel_from').' '.$cancel_date;
        $to=$user_info->email; // change it to yours
        $subject=$this->lang->line('cancel_parking_subject');
        $this->send_mail_message($table,$subject,$to);
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
            $subject=$this->lang->line('queue_details_parking');
            $this->email->subject($subject);
            $this->email->message($table);
            if($this->email->send())
            {
               // echo 'Email sent.';
            }
        }
        // exit;

        $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));

        $this->session->set_flashdata('msg', $this->lang->line('parking_cancel_admin'));

        if($redirect==2)
            redirect('approve');
        else
            redirect('allocation');
    }


    function cancel($id,$redirect=0)
    {
        date_default_timezone_set('Europe/Stockholm');

        $next_month_end = date('Y-m-d',strtotime("last day of next month"));
        $this->db->where('id',$id)->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'2'));

        $get_user=$this->db->where('id',$id)->get('parking_allocation')->row_array();
        $user_info=$this->Reginfo->get_info($get_user['user']);
        $name=$user_info->firstname." ".$user_info->lastname;

        $parking_info = $this->Parkinginfo->get_info($get_user['parking']);
        $parking_name=$parking_info->name;

        $parking_types=$this->Parkinginfo->parking_type();
        $park_type=$parking_types[$parking_info->type];

        $cancel_date=date('Y-m-d', strtotime($next_month_end."+1 days"));
        //Parking Cancel Mail send
        $table=$this->lang->line('dear')." ".$name.",";
        $table.="<br><br>";

        $table.=$this->lang->line('parking_name'). " : ".$parking_name." ";
        $table.="<br><br>";
        $table.=$this->lang->line('parking_type'). " : ".$park_type." ";
        $table.="<br><br>";
        $table.=$this->lang->line('your_parking_will_be_cancel_from').' '.$cancel_date;
        $to=$user_info->email; // change it to yours
        $subject=$this->lang->line('cancel_parking_subject');
        $this->send_mail_message($table,$subject,$to);
        //Allocation
        //Billing Mai Mail Send

        $subject=$this->lang->line('biiling_decline_subject');

        $table=$this->lang->line('billing_cancel');
        $table.="<br><br>";

        $table.="<table>";
        $table .= '<tr><td>'.$this->lang->line('user').'</td><td>:</td><td>'.$name.'</td></tr>';

        $table .= '<tr><td>'.$this->lang->line('personal_number').'</td><td>:</td><td>'.$user_info->pin.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_name').'</td><td>:</td><td>'.$parking_name.'</td></tr>';
        $table .= '<tr><td>'.$this->lang->line('parking_type').'</td><td>:</td><td>'.$park_type.'</td></tr>';
        $table .= '</table>';
        //$table.="<br><br>";

        $this->send_mail_message($table,$subject,ACCOUNTS_MAIL);

        //Billing Mail End

        $alloc_info=$this->Allocationinfo->get_parking_alloc($id);

        $result= $this->Queueinfo->get_queue_user_parked($alloc_info['user']);


        if(empty($result))
        {
            $table=$this->lang->line('parking_name'). " : ".$parking_name." ";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_type'). " : ".$park_type." ";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_will_be_cancel_from').' '.$cancel_date;
            $table.="<br><br>";
            $table.=$this->lang->line('empty_queue');

            $subject=$this->lang->line('cancel_parking_subject');

            $this->db->where('id',$get_user['parking'])->update('parking',array('status'=>0));
            //$table.="<br><br>";
            $this->send_mail_message($table,$subject,ADMIN_MAIL);

        }else{

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

            $table.=$this->lang->line('parking_type'). " : ".$parking_types[$alloc_info['parking_type']]." ";
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
              //echo 'Email sent.';
            }
        }
        //exit;
        $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));
        }

        $this->send_mail_message($table,'Parking','developertest@mailinator.com');
        if($redirect==true)
        {
            $this->session->set_flashdata('msg', $this->lang->line('cancel_parking_next_month'));
            redirect('allocation');
        }
        else{

            $this->session->set_flashdata('msg',$this->lang->line('parking_cancel_admin'));
            redirect('tracking');
        }
    }

    function delete_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admin');
        $this->session->set_flashdata('delete_message', $this->lang->line('delete_message'));
        redirect('registration');
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    function alloc_change()
    {
        $id=$this->input->post('status');
        $parking_id=$this->input->post('parking_id');

        // SELECT `id`, `userid`, `parking_id`, `req_date`, `confirm_date`, `status` FROM `change_parking` WHERE 1

        $alloc_info=$this->Allocationinfo->get_parking_alloc($id);
                $reg_data=array(
            'userid'=>$alloc_info['user'],
            'parking_id'=>$alloc_info['parking'],
            'new_parking'=>$parking_id,
            'req_date'=>date('Y-m-d')
        );


        $this->Trackinginfo->save_change($reg_data,-1); //change parking request

        $this->alloc_confirm($parking_id); //load parking confirmation

     /*   $next_month_end = date('Y-m-d',strtotime("last day of next month"));
        $this->db->where('id',$id)->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'2'));

        $result= $this->Queueinfo->get_queue_all();

        foreach($result as $key=>$val){
            $alloc_info=$this->Allocationinfo->get_parking_alloc($id);
            //$alloc_info['parking_id']
            $reg_data=array(
                'parking'=>$alloc_info['parking_id'],
                'userid'=>$val['userid'],
                'position'=>$val['position'],
                'from_date'=>date('Y-m-d H:i:s'),
                'to_date'=>date('Y-m-d H:i:s', strtotime("+".ALLOC_DAYS." days")));

            $this->Trackinginfo->alloc_save($reg_data,-1);

            $que_data=array(
                'position_status'=>2
            );

            $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update

            $table="Dear ".$val['firstname'].",";
            $table.="</br></br>";
            $table.='You have been placed in the Allocation of Parking '.$alloc_info['parking_name'];
            $table.="</br>";
            $table.='Please click here to <a href="https://www.cpjtechnosolutions.com/parking">login  here</a>';

            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->from('info@cpjtechnosolutions.com'); // change it to yours
            $this->email->to($val['email']); // change it to yours
            $this->email->subject('Queue Details - Parking');
            $this->email->message($table);
            if($this->email->send())
            {
                echo 'Email sent.';
            }
        }
        $this->session->set_flashdata('msg', 'Your Parking cancel request has been updated');
        redirect('tracking');

     */


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



    function send_mail_message($message,$subject,$to)
    {

        $message.="<br><br>";
        $message.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';

        $message.="<br><br>";
        $message.=REGARDS."<br>";
        $message.=ADMIN_NAME;
        // echo "message".$message."subject ".$subject."to".$to;

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
