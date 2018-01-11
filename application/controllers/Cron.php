<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
    function __construct()
    {
        parent::__construct();
      //  $this->load->helper(array('form','url','html'));
      //  $this->load->library(array('session', 'form_validation'));
      //  if(! $this->session->userdata('uid'))
     //   {
           // redirect('login');
     //   }
        date_default_timezone_set('Europe/Stockholm');
        $this->lang->load('common','sw');
    }

    
 function index()
    {

                $this->cronfunction();
}

 public function sendtestemail()
    {
                  $this->cronfunction();
}

    public function cronfunction()
    {
        $date=date('Y-m-d 23:59:59',strtotime("-1 days"));
        $today=date('Y-m-d',strtotime("-1 days"));

        $alloc_count=$this->Croninfo->get_alloc_count($date);
        $parking_types=$this->Parkinginfo->parking_type();

       for($i=0;$i<$alloc_count->num_rows();$i++){
           $alloc_fetch=$this->Croninfo->get_alloc($date);

           // if(!empty($alloc_info))  //confirmation
            foreach($alloc_fetch as $key => $alloc_info)
            {
                    $ex_alloc=$this->db->where(array('parking'=>$alloc_info['parking'],'status'=>2))->get('parking_allocation')->row();
                    $start_date=date('Y-m-d',strtotime($ex_alloc->to_date."+1 days"));
                    //$reg_data=array('parking'=>$alloc_info['parking'],'user'=>$alloc_info['userid'],'from_date'=>$start_date);
                    //$this->Allocationinfo->save(-1,$reg_data); // Parking Confirmation

                $reg_data=array('parent_id'=>$alloc_info['parent_id'],'parking'=>$alloc_info['parking'],'user'=>$alloc_info['userid'],'from_date'=>$start_date);
                $this->Allocationinfo->save_approve(-1,$reg_data); // Parking Confirmation to approve Admin

                $this->db->where('id',$alloc_info['id'])->delete('alloc'); //remove confirm parking from alloc

                //$this->Queueinfo->delete($alloc_info->userid);  //remove from queue
                $this->Trackinginfo->update_user_queue($alloc_info['userid']);  //position re allocatin
                $this->db->where('userid',$alloc_info['userid'])->delete('queue');  // remove from queue
                //Check if this person next parking allocation or batch and reset batch
                $this->reset_batch($alloc_info['parking'],$alloc_info['userid']);

                $this->db->where('userid',$alloc_info['userid'])->delete('alloc'); // remove form allocatin

                //User Mail Start
                $parking_info   = $this->Parkinginfo->get_info($alloc_info['parking']);
                $user_info      = $this->Reginfo->get_info($alloc_info['userid']);
                $username=$user_info->firstname." ".$user_info->lastname;
                $pin  =$user_info->pin;
                $to=$user_info->email;
                $parking=$parking_info->name;
                $parking_type=$parking_types[$parking_info->type];
                $table=$this->lang->line('dear')." ".$username.",";
                $table.="<br><br>";
                // $table.=$this->lang->line('your_parking_confirmed').' '.$parking. " ".$this->lang->line('from')." ".$start_date;

                $table.=$this->lang->line('your_parking_confirmed').' '.$this->lang->line('parking_name')." ".$parking.", ".$this->lang->line('parking_type')." ".$parking_type." ".$this->lang->line('has_been_confirmed_you');
                $warning_date=date('Y-m-d',strtotime($today."+".ALLOC_DAYS." days"));
                $table.="<br><br>";
                $table.=$this->lang->line('kindly_contact_before')." ".$warning_date;

                $table.="<br><br>";
                $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';

                $subject=$this->lang->line('confirmed_parking_subject');
                $this->send_mail_message($table,$subject,$to);
                //Allocation

                //User Mail End
                //Admin mail Start
                $table=$this->lang->line('dear')." ".$this->lang->line('admin').",";
                $table.="<br><br>";
                $table.=$this->lang->line('parking_name')." ".$parking.", ".$this->lang->line('parking_type')." ".$parking_type." ".$this->lang->line('has_been_confirmed_to')." ".$username."[".$pin."]";

                $table.="<br><br>";
                $table.=$this->lang->line('kindly_contract_approve');
                $table.="<br><br>";
                $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


                $subject=$this->lang->line('confirmed_parking_subject');

                $this->send_mail_message($table,$subject,ADMIN_MAIL);
                //Admin mail End

                $alloc_info_cancel=$this->Croninfo->get_alloc_cancel($alloc_info['parking']);
               // print_r($alloc_info_cancel);
                foreach($alloc_info_cancel as $key=>$val){
                    $parking_info   = $this->Parkinginfo->get_info($val['parking']);
                    $user_info      = $this->Reginfo->get_info($val['userid']);
                    $username=$user_info->firstname." ".$user_info->lastname;
                    $to=$user_info->email;
                    $parking=$parking_info->name;
                    $table=$this->lang->line('dear')." ".$username.",";
                    $table.="<br><br>";
                    $table.=$this->lang->line('your_parking_not_alloted').' '.$parking. " ".$this->lang->line('from'). " ".$start_date;

                    $table.="<br><br>";
                    $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';

                    $subject=$this->lang->line('parking_not_alloted_subject');
                    if($val['status']==1){
                        $this->send_mail_message($table,$subject,$to);
                    }

                    //is allocation
                    $reg_data=array('position_status'=>1);

                    if($this->is_allocation_this_parking($val['userid'],$val['parking'])==FALSE) //check This parking only
                        $this->Trackinginfo->save_queue($reg_data,$val['userid']);

                    //if($this->is_allocation($val['userid'])==FALSE)
                    //$this->Trackinginfo->save_queue($reg_data,$val['userid']);
                }
                $this->db->where('parking',$alloc_info['parking'])->delete('alloc');
                $this->db->where('parking',$alloc_info['parking'])->delete('allocation_batch');

                $this->change_parking($alloc_info['userid'],$alloc_info['parking'],$date);
            }

       }
        //No one Allocation Confirmed
        $no_alloc=$this->Croninfo->get_alloc_not_confirmation($date);
        if(!empty($no_alloc))
        {
            $this->db->where('parking',$no_alloc->parking);
            $result=$this->db->get('alloc')->result_array();

          //  print_r($result);
            foreach($result as $key=>$val){
                $this->db->where('userid',$val['userid'])->delete('alloc');
                $reg_data=array('position_status'=>1);
                $this->Trackinginfo->save_queue($reg_data,$val['userid']);

            }
        }

        //Next Batch allocation mail send
        $query=$this->db->where('to_date<=',$date)->get('allocation_batch');

        if($query->num_rows()>0)
        {
            $alloc_batch=$query->result_array();
            foreach($alloc_batch as $key=>$val){
              $to_date=$val['to_date'];
              $batch=$val['batch'];
              $parking=$val['parking'];
              $this->next_alloc_send($date,$batch,$parking);
            }
        }


        $end_date=date('Y-m-d',strtotime($today."-1 days"));
        $rows=$this->Commoninfo->get_count_id('parking_allocation','to_date',$end_date);
        if($rows>0)
        {
            $this->db->where('to_date',$end_date)->update('parking_allocation',array('status'=>'3'));
            $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,ad.firstname,ad.lastname,ad.email');
            $this->db->from('parking_allocation as ac');
            $this->db->join('parking as p','ac.parking=p.id');
            $this->db->join('admin as ad','ac.user=ad.id');
            $this->db->where('ac.to_date',$end_date);
            $data['reports']= $this->db->get()->result_array();

            foreach($data['reports'] as $key=>$val){
              //  $post_data=array('userid'=>$val['user'], 'parking'=>$val['parking'], 'from_date'=>$from_date, 'to_date'=>$to_date,'create_date'=>$today, 'amount'=>$val['amount']);

                $user=$val['firstname']." ".$val['lastname'];
                $to=$val['email'];
                $table=$this->lang->line('dear')." ".$val['user'].",";
                $table.="<br><br>";
                $table.=$this->lang->line('your_parking').' '.$val['parking_name']. " ".$this->lang->line('closed')." ".$end_date;

                $table.="<br><br>";
                $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


                $subject=$this->lang->line('parking_closed');

                $this->send_mail_message($table,$subject,$to);
                //Allocation

            }
        }
        //$today=date('Y-m-d');
       // $rows=$this->Commoninfo->get_count_id('parking_allocation','from_date',$today);

        $rows=$this->db->where(array('from_date'=>$today,'approve'=>1))->get('parking_allocation')->num_rows(); //approve person
        if($rows>0){

            $this->db->where(array('from_date'=>$today,'approve'=>1))->update('parking_allocation',array('status'=>'1'));
            $this->db->select('ac.*,p.id as parking_id,p.name as parking_name,p.type,ad.firstname,ad.lastname,ad.email,ad.pin');
            $this->db->from('parking_allocation as ac');
            $this->db->join('parking as p','ac.parking=p.id');
            $this->db->join('admin as ad','ac.user=ad.id');
            $this->db->where('ac.from_date',$today);
            $this->db->where('ac.approve',1);

            $data['reports']= $this->db->get()->result_array();
            foreach($data['reports'] as $key=>$val){

                $user=$val['firstname']." ".$val['lastname'];
                $to=$val['email'];
                $table=$this->lang->line('dear')." ".$user.",";
                $table.="<br><br>";
                $table.=$this->lang->line('your_parking').' '.$val['parking_name']. " ".$this->lang->line('confirmed')." ".$today;

                $table.="<br><br>";
                $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';


                $subject=$this->lang->line('parking_confirmed');


                $this->send_mail_message($table,$subject,$to);
                //Allocation



                $parking_types=$this->Parkinginfo->parking_type(); //get parking types
                //Billing Mail Start
                $table='';
                $subject=$this->lang->line('biiling_confirm_subject');
                $table="<table>";
                $table .= '<tr><td>'.$this->lang->line('user').'</td><td>:</td><td>'.$user.'</td></tr>';
                $table .= '<tr><td>'.$this->lang->line('personal_number').'</td><td>:</td><td>'.$val['pin'].'</td></tr>';
                $table .= '<tr><td>'.$this->lang->line('parking_name').'</td><td>:</td><td>'.$val['parking_name'].'</td></tr>';
                $table .= '<tr><td>'.$this->lang->line('parking_type').'</td><td>:</td><td>'.$parking_types[$val['type']].'</td></tr>';
                $table .= '<tr><td>'.$this->lang->line('start_from').'</td><td>:</td><td>'.$today.'</td></tr>';
                $table .= '</table>';
                $table.="<br><br>";
                $table.=$this->lang->line('billing_details');
                $this->send_mail_message($table,$subject,ACCOUNTS_MAIL);
                //Billing Mail End

            }


;
        }
    }

    //Change parking cancel
    function change_parking($userid,$parking,$date)
    {
        $this->db->from('change_parking');
        $this->db->where('userid',$userid);
        $this->db->where('status','0');
        $this->db->where('new_parking',$parking);
        $this->db->group_by('new_parking');
        $query = $this->db->get();
        if($query->num_rows()>=1)
        {
            $change_info=$query->row_array();
            //SELECT `id`, `userid`, `parking_id`, `req_date`, `confirm_date`, `status` FROM `change_parking` WHERE 1
            //Cancel Existing Parking as requested
            $id=$change_info['parking_id'];

            $parking_info=$this->Parkinginfo->get_info($id); //get parking details
            $parking_types=$this->Parkinginfo->parking_type(); //get parking types

            $user_info=$this->db->where('id',$change_info['userid'])->get('admin')->row_array();
            $name=$user_info['firstname']." ".$user_info['lastname'];
            $next_month_end = date('Y-m-d',strtotime("last day of next month"));
            $this->db->where(array('parking'=>$id,'user'=>$userid))->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'2'));

            //Parking Cancel Mail send
            $table=$this->lang->line('dear')." ".$name.",";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_name'). " ".$parking_info->name." ";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_type'). " ".$parking_types[$parking_info->type]." ";
            $table.="<br><br>";
            $table.=$this->lang->line('your_parking_will_cancel').' '.$next_month_end;
            $table.="<br><br>";
            $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';

            $to=$user_info['email']; // change it to yours
            $subject=$this->lang->line('cancel_request_parking');
            $this->send_mail_message($table,$subject,$to);
            //Allocation


            //Billing Mail Start
            $table='';
            $subject=$this->lang->line('cancel_request_parking');
            $table="<table>";
            $table .= '<tr><td>'.$this->lang->line('user').'</td><td>:</td><td>'.$name.'</td></tr>';
            $table .= '<tr><td>'.$this->lang->line('personal_number').'</td><td>:</td><td>'.$user_info['pin'].'</td></tr>';
            $table .= '<tr><td>'.$this->lang->line('parking_name').'</td><td>:</td><td>'.$parking_info->name.'</td></tr>';
            $table .= '<tr><td>'.$this->lang->line('parking_type').'</td><td>:</td><td>'.$parking_types[$parking_info->type].'</td></tr>';
            $table .= '<tr><td>'.$this->lang->line('your_parking_will_cancel').'</td><td>:</td><td>'.$next_month_end.'</td></tr>';
            $table .= '</table>';
            $table.="<br><br>";
            $table.=$this->lang->line('billing_details');
            $this->send_mail_message($table,$subject,ACCOUNTS_MAIL);
            //Billing Mail End


           // $alloc_info=$this->Allocationinfo->get_parking_alloc($id);
            $result= $this->Queueinfo->get_queue_user_parked($userid);

            foreach($result as $key=>$val){
                //$to_date=date('Y-m-d 23:59:59', strtotime("+".ALLOC_DAYS." days"));
                $to_date=date('Y-m-d 23:59:59', strtotime($date."+".ALLOC_DAYS." days"));

                $reg_data=array(
                    'parking'=>$id,
                    'userid'=>$val['userid'],
                    'position'=>$val['position'],
                     //'from_date'=>date('Y-m-d H:i:s'),
                    'from_date'=>$date,
                    'to_date'=>$to_date);


                $this->db->insert('alloc', $reg_data);

               // $this->Trackinginfo->alloc_save($reg_data,-1);

                $que_data=array(
                    'position_status'=>2
                );

                $alloc_park_id=$id;
                $alloc_position=$val['position'];


                $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update

                $this->db->where('userid', $val['userid'])->update('queue', $que_data);

                $table=$this->lang->line('dear')." ".$val['firstname'].",";
                $table.="<br><br>";

                $table.=$this->lang->line('parking_name'). " : ".$parking_info->name." ";
                $table.="<br><br>";
                $table.=$this->lang->line('parking_type'). " : ".$parking_types[$parking_info->type]." ";
                $table.="<br><br>";
                $table.=$this->lang->line('your_allocation');
                $table.="<br><br>";
                $table.='<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';

                $this->email->set_newline("\r\n");
                $this->email->set_mailtype("html");
                $this->email->from(ADMIN_MAIL); // change it to yours
                $this->email->to($val['email']); // change it to yours
                $this->email->subject($this->lang->line('queue_details_parking'));
                $this->email->message($table);


                if($this->email->send())
                {
                    echo 'Email sent.';
                }
            }

            $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));
           // $this->db->where('id',$change_info['id'])->update('change_parking',array('confirm_date'=>date('Y-m-d',strtotime($date)),'status'=>1));
            $this->db->where('id',$change_info['id'])->delete('change_parking');

        }
    }


     function is_allocation($userid)
     {
         $query=$this->db->where('userid',$userid)->get('alloc');
         if($query->num_rows()>0)
             return true;
         else
             return false;
     }

    function is_allocation_this_parking($userid,$parking)
    {
        $this->db->where('userid',$userid);
        $this->db->where('parking !=',$parking);
        $query=$this->db->get('alloc');
        if($query->num_rows()>0)
            return true;
        else
            return false;
    }

    function reset_batch($parking,$userid)
    {
        $this->db->from('alloc');
        $this->db->where('parking <>',$parking);
        $this->db->where('userid',$userid);
        $data=$this->db->get()->result_array();
        foreach($data as $key => $val)
        {
            $this->db->where('parking',$val['parking']);
            $this->db->set('batch', '`batch`- 1', FALSE);
            $this->db->update('allocation_batch');
        }
    }

    function next_alloc_send($date,$batch,$parking)
    {
        $flag=0;
        $result= $this->Queueinfo->get_queue_all($batch);
       // print_r($result); exit;
        if(empty($result))
        {
            $parking_info = $this->Parkinginfo->get_info($parking);
            $parking_name=$parking_info->name;


            $parking_alloc=$this->db->where(array('parking'=>$parking,'status'=>2))->get('parking_allocation')->row();
            $end_date=$parking_alloc->to_date;

           $cancel_date=date('Y-m-d', strtotime($end_date."+1 days"));


            $parking_types=$this->Parkinginfo->parking_type();
            $park_type=$parking_types[$parking_info->type];

            $table=$this->lang->line('parking_name'). " : ".$parking_name." ";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_type'). " : ".$park_type." ";
            $table.="<br><br>";
            $table.=$this->lang->line('parking_will_be_cancel_from').' '.$cancel_date;
            $table.="<br><br>";
            $table.=$this->lang->line('empty_queue');

            $subject=$this->lang->line('cancel_parking_subject');

            $this->db->where('id',$parking)->update('parking',array('status'=>0));
            //$table.="<br><br>";
            $this->send_mail_message($table,$subject,ADMIN_MAIL);

            $this->db->where('parking',$parking)->delete('allocation_batch');

        }else{
        foreach($result as $key=>$val){
            $alloc_info=$this->Allocationinfo->get_parking_alloc($parking);
            $to_date=date('Y-m-d 23:59:59', strtotime($date."+".ALLOC_DAYS." days"));
            $reg_data=array(
                 //'parking'=>$alloc_info['parking_id'], //parking id
                'parking'=>$parking, //parking id
                'userid'=>$val['userid'],
                'position'=>$val['position'],
                'from_date'=>$date,
                'to_date'=>$to_date);


            $this->Trackinginfo->alloc_save($reg_data,-1);

            $que_data=array(
                'position_status'=>2
            );

            //$alloc_park_id=$alloc_info['parking_id'];
            $alloc_park_id=$parking;

            $alloc_position=$val['position'];

            $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update

            $table=$this->lang->line('dear')." ".$val['firstname'].",";
            $table.="<br><br>";
            $table.=$this->lang->line('your_allocation'). '<a href="'.site_url().'">'.$this->lang->line('login_here').'</a>';
            $subject=$this->lang->line('queue_details_parking');

            $to=$val['email'];
            $this->send_mail_message($table,$subject,$to);
            $flag=1;
        }
    }
        if($flag==1){
            $this->db->where('parking',$alloc_park_id)->delete('allocation_batch');
            $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));
        }
    }



    function send_mail_message($message,$subject,$to)
    {
        $message.="<br><br>";
        $message.=REGARDS."<br>";
        $message.=ADMIN_NAME;
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
