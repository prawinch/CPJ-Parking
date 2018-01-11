<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if(! $this->session->userdata('uid'))
        {
            redirect('login');
        }

        date_default_timezone_set('Europe/Stockholm');
    }

    public function index()
    {
        //echo $date=date('Y-m-d 23:59:59',strtotime("-1 days"));
        $date=date('2017-07-27 23:59:59');
        $curdate='2017-07-27';

        $today=date('Y-m-d',strtotime($curdate));
        $alloc_info=$this->Croninfo->get_alloc($date);
        // echo '<pre>'; print_r($alloc_info);// exit;
        if(!empty($alloc_info))  //confirmation
        {
            echo "Confirmation Start "; echo "<br>";
            $ex_alloc=$this->db->where(array('parking'=>$alloc_info->parking,'status'=>2))->get('parking_allocation')->row();
            $start_date=date('Y-m-d',strtotime($ex_alloc->to_date."+1 days"));
            $reg_data=array('parking'=>$alloc_info->parking,'user'=>$alloc_info->userid,'from_date'=>$start_date);
            $this->Allocationinfo->save(-1,$reg_data); // Parking Confirmation

            $this->db->where('id',$alloc_info->id)->delete('alloc'); //remove confirm parking from alloc

            //$this->Queueinfo->delete($alloc_info->userid);  //remove from queue
            $this->Trackinginfo->update_user_queue($alloc_info->userid);  //position re allocatin
            $this->db->where('userid',$alloc_info->userid)->delete('queue');  // remove from queue
            $this->db->where('userid',$alloc_info->userid)->delete('alloc'); // remove form allocatin

            $parking_info   = $this->Parkinginfo->get_info($alloc_info->parking);
            $user_info      = $this->Reginfo->get_info($alloc_info->userid);
            $username=$user_info->firstname." ".$user_info->lastname;
            $to=$user_info->email;
            $parking=$parking_info->name;
            $table="Dear ".$username.",";
            $table.="<br><br>";
            $table.='Your Parking has Confirmed '.$parking. " from ".$start_date;
            $subject='Confirmed - Parking';

            //  echo $table;     echo "<br>".$subject;        echo "<br>".$to; echo "<br>";
            $this->email_send($table,$subject,$to);
            //Allocation

            $alloc_info_cancel=$this->Croninfo->get_alloc_cancel($alloc_info->parking);
            // print_r($alloc_info_cancel);
            foreach($alloc_info_cancel as $key=>$val){
                $parking_info   = $this->Parkinginfo->get_info($val['parking']);
                $user_info      = $this->Reginfo->get_info($val['userid']);
                $username=$user_info->firstname." ".$user_info->lastname;
                $to=$user_info->email;
                $parking=$parking_info->name;
                $table="Dear ".$username.",";
                $table.="<br><br>";
                $table.='Your Parking is not Allocated '.$parking. " from ".$start_date;
                $subject='Parking - Not Allocated';
                if($val['status']==1){
                    $this->email_send($table,$subject,$to);
                }



                $reg_data=array('position_status'=>1);
                $this->Trackinginfo->save_queue($reg_data,$val['userid']);
            }
            $this->db->where('parking',$alloc_info->parking)->delete('alloc');
            $this->db->where('parking',$alloc_info->parking)->delete('allocation_batch');
            echo "Confirmation End "; echo "<br>";


            //Change Parking Check start
            echo "Change Parking Start "; echo "<br>";
            $this->change_parking($alloc_info->userid,$alloc_info->parking,$date);
            echo "Change Parking End"; echo "<br>";
            //Change Parking Check End
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
        echo "query rows ".$query->num_rows()." date".$date; echo "<br>";
        // $alloc_batch=$this->Croninfo->get_alloc_batch($date);
        if($query->num_rows()>0)
        {
            $alloc_batch=$query->result_array();
            foreach($alloc_batch as $key=>$val){
                echo "<br>todate". $to_date=$val['to_date'];
                echo "<br>batch". $batch=$val['batch'];
                echo "<br>parking id". $parking=$val['parking'];
                $this->next_alloc_send($date,$batch,$parking);
            }
        }

        $end_date=date('Y-m-d',strtotime("-1 days"));
        $rows=$this->Commoninfo->get_count_id('parking_allocation','to_date',$end_date);
        if($rows>0)
            $this->db->where('to_date',$end_date)->update('parking_allocation',array('status'=>'3'));

        // $today=date('Y-m-d');
        $rows=$this->Commoninfo->get_count_id('parking_allocation','from_date',$today);
        if($rows>0)
            $this->db->where('from_date',$today)->update('parking_allocation',array('status'=>'2'));

    }

    function  change_parking($userid,$parking,$date)
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

            $user_info=$this->db->where('id',$change_info['userid'])->get('admin')->row_array();
            $name=$user_info['firstname']." ".$user_info['lastname'];
            $next_month_end = date('Y-m-d',strtotime("last day of next month"));
            $this->db->where(array('parking'=>$id,'user'=>$userid))->update('parking_allocation',array('to_date'=>$next_month_end,'status'=>'2'));

            //Parking Cancel Mail send
            $table="Dear ".$name.",";
            $table.="<br><br>";
            $table.='Your Parking will be cancelled from  '.$next_month_end;
            $to=$user_info['email']; // change it to yours
            $subject='Cancel - Your request Parking';
            $this->email_send($table,$subject,$to);
            //Allocation

            // $alloc_info=$this->Allocationinfo->get_parking_alloc($id);

            $result= $this->Queueinfo->get_queue_user_parked($userid);

            echo "Start Cancel Parking send Allocation "; echo "<br>";
            foreach($result as $key=>$val){


                //  $to_date=date('Y-m-d 23:59:59', strtotime("+".ALLOC_DAYS." days"));

                $to_date=date('Y-m-d 23:59:59', strtotime($date."+".ALLOC_DAYS." days"));

                $reg_data=array(
                    'parking'=>$id,
                    'userid'=>$val['userid'],
                    'position'=>$val['position'],
                    //  'from_date'=>date('Y-m-d H:i:s'),
                    'from_date'=>$date,
                    'to_date'=>$to_date);

                echo '<pre>'; print_r($reg_data);

                $this->db->insert('alloc', $reg_data);

                // $this->Trackinginfo->alloc_save($reg_data,-1);

                $que_data=array(
                    'position_status'=>2
                );

                echo "Allocation Updated User id ".$val['userid']; echo "<br>";
                $alloc_park_id=$id;
                $alloc_position=$val['position'];

                $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update


                $this->db->where('userid', $val['userid'])->update('queue', $que_data);

                $table="Dear ".$val['firstname'].","; echo "<br><br>";
                $table.='You have been placed Change Parking in the Allocation of Id '.$alloc_park_id.' Parking '.$id;

                $this->email->set_newline("\r\n");
                $this->email->set_mailtype("html");
                $this->email->from(ADMIN_MAIL); // change it to yours
                $this->email->to($val['email']); // change it to yours
                $this->email->subject('Queue Details - Parking');
                $this->email->message($table);

                echo "subject : cancel parking allocation"; echo "<br>";
                echo $table; echo "<br>";

                if($this->email->send())
                {
                    echo 'Email sent.';
                }
            }

            echo "End Cancel Parking send Allocation "; echo "<br>";


            $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));
            $this->db->where('id',$change_info['id'])->update('change_parking',array('confirm_date'=>date('Y-m-d',strtotime($date)),'status'=>1));
        }else{

            echo "No change Request Parking"; echo "<br>";
        }
    }





    function next_alloc_send($date,$batch,$parking)
    {
        echo "Next Alloc Send";
        echo "batch ".$batch." date ".$date."   parking ".$parking; echo "<br>";
        $flag=0;

        $result= $this->Queueinfo->get_queue_all($batch);
        // print_r($result); exit;
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

            //  echo "<pre>";print_r($reg_data);

            $this->Trackinginfo->alloc_save($reg_data,-1);

            $que_data=array(
                'position_status'=>2
            );

            // $alloc_park_id=$alloc_info['parking_id'];
            $alloc_park_id=$parking;

            $alloc_position=$val['position'];

            $this->Trackinginfo->save($que_data,$val['id']); //queue allocation update

            $table="Dear ".$val['firstname'].",";
            $table.="<br><br>";
            $table.='You have been placed in the Allocation of Parking <a href="'.site_url().'">Login here</a>';
            $subject='Queue Details - Parking';

            echo "Subject ".$subject; echo "<br>";
            echo "Message ".$table; echo "<br><br>";

            $to=$val['email'];
            $this->email_send($table,$subject,$to);

            $flag=1;
        }

        if($flag==1){
            $this->db->where('parking',$alloc_park_id)->delete('allocation_batch');
            $this->Allocationinfo->save_batch(-1,array('parking'=>$alloc_park_id,'batch'=>$alloc_position,'to_date'=>$to_date));
        }
    }



    function email_send($message,$subject,$to)
    {

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
