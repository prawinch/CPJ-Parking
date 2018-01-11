<?php

$this->load->view("partial/top_header");

$this->load->view("partial/sidebar_menu");

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin'); ?>/fancybox/jquery.fancybox.css" media="screen" />

<link rel="stylesheet" href="<?php echo base_url(); ?>/tracker/css/style.css">

<style>

    *{

    -webkit-box-sizing:none !important;-moz-box-sizing:none !important;box-sizing:none !important}:after,:before{-webkit-box-sizing:none !important;-moz-box-sizing:none !important;box-sizing:none !important}

    .modal-body {

        position: relative;

        overflow-y: auto;

        max-height: 400px;

        padding: 15px;

    }

</style>

<div class="content-wrapper">

<section class="content-header">

    <h1>

        <?php echo $this->lang->line('status_bar'); ?>

    </h1>

    <!--<div class="col-sm-1 pull-right but">

        <a href="<?php echo base_url()?>/index.php/parking"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Back</button> </a>

    </div>-->

</section>

<!-- Main content -->

<section class="content">

    <div class="box box-default">

        <div class="box box-info text-center">

            <?php if($this->session->flashdata('msg')){?>

                <div class="alert alert-success">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                    <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('msg')?>

                </div>

            <?php } ?>

            <!-- /.box-header -->

            <!-- form start -->

            <?php

            $done="done";

            $todo="todo";

            $CI =& get_instance();

            $row = $CI->Trackinginfo->get_user_queue('queue',$userid);

            echo '<ol class="track-progress text-center">';

            foreach($status_info as $key=>$val){

                if($key==0)continue;



                if($key<=$row->position_status)

                    $class=$done;

                else

                    $class=$todo;



                echo '<li class="'.$class.'">

                            <em>'.$key.'</em>

                            <span>'.$val.'</span>

                        </li>';

            }

            echo '</ol>';

            ?>

            <!-- /.box-body -->

            <!-- /.box-footer -->

        </div>

    </div>



    <div class="box box-default">

        <div class="row">

            <div class="col-md-8">

                <!-- Horizontal Form -->

                <div class="box box-info">

                    <!-- /.box-header -->

                    <!-- form start -->



                    <?php

                    if($row->id=='')

                    {

                    ?>

                        <?php $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");

                        echo form_open("parking/save/", $attributes);

                        ?>

                        <div class="box-footer text-center">

                            <h3><?php echo $this->lang->line('click_queue'); ?></h3>

                            <a id="Delete" data-toggle="confirm" data-title="Do you really want to delete this record ?" href="<?php echo site_url('tracking/position/1'); ?>">

                                <button type="button" class="btn  btn-success"><?php echo $this->lang->line('start_queue'); ?></button>

                            </a>

                        </div>

                        <?php echo form_close(); ?>



                    <?php

                    }



                    if($row->position_status>0){

                    ?>

                        <div class="box-footer text-center">

                            <a id="Delete" data-toggle="quit" data-title="Do you really want to delete this record ?" href="<?php echo site_url('tracking/quit'); ?>">

                                <button type="button" class="btn  btn-danger"><?php echo $this->lang->line('quit_queue'); ?> </button>

                            </a>

                        </div>



                       <!-- /.box-footer -->

                        <div class="box-body table-responsive no-padding">



                            <table class="table table-bordered table-striped visible-xs">

                                <?php

                                if($row->position_status==1)

                                {

                                    $status=$this->lang->line('queue');

                                    $label='label-primary';

                                }else if($row->position_status==2){

                                    $status=$this->lang->line('waiting');

                                    $label='label-warning';

                                }

                                echo '<tr>

                                    <th>'.$this->lang->line('your_queue_no').'</th><td>'.$row->position.'</td></tr>

                                    <tr><th>'.$this->lang->line('from_date').'</th><td>'.$row->time.'</td></tr>

                                    <tr><th>'.$this->lang->line('status').'</th><td><span class="label '.$label.'">'.$status.'</span></td>

                                </tr>';

                                ?>

                            <!-- Large view-->

                            <table class="table table-bordered table-striped hidden-xs">

                                <tr><th class="col-md-3"><?php echo $this->lang->line('your_queue_no'); ?></th><th class="col-md-6"><?php echo $this->lang->line('from_date'); ?></th><th class="col-md-3"><?php echo $this->lang->line('status'); ?></th></tr>

                            <?php

                            if($row->position_status==1)

                            {

                                $status=$this->lang->line('queue');

                                $label='label-primary';

                            }else if($row->position_status==2){

                                $status=$this->lang->line('waiting');

                                 $label='label-warning';

                            }

                                echo '<tr>

                                    <td>'.$row->position.'</td>

                                    <td>'.$row->time.'</td>

                                    <td><span class="label '.$label.'">'.$status.'</span></td>

                                </tr>';

                            ?>

                            </table>

                            <!-- large view end -->

                        </div>

                        <!-- /.box-body -->

            <?php if($row->position_status==2){

                            ?>

                        <div class="box-footer">

                            <h3>

                                <?php echo $this->lang->line('parking_allocated'); ?>

                            </h3>

                        </div>

                        <div class="box-body table-responsive no-padding">





                        <table class="table table-bordered table-striped visible-xs">

                            <?php

                            $result_alloc = $CI->Trackinginfo->get_alloc($userid);



                           // print_r($result_alloc);

                           /* echo '<tr>';

                            foreach($alloc_headers as $key=>$val)

                                echo '<th class="col-md-3">'.$val.'</th>';

                            echo '</tr>';*/

                            $cnt=1;

                            foreach($result_alloc as $key=>$alloc){

                                $stat=0;

                                if($alloc['status']==0)

                                {

                                    $status=$this->lang->line('alloted');;

                                    $label='label-primary';

                                    $stat=1;

                                }else{

                                    $status=$this->lang->line('waiting_for_decision');

                                    $label='label-warning';

                                    $stat=2;

                                }



                                echo '<tr><th>'.$alloc_headers['0'].'</th>

                                    <td>'.$alloc['parking_name'].'</td></tr>

                                   <tr><th>'.$alloc_headers['1'].'</th> <td>'.date('Y-m-d', strtotime($alloc['end_date']."+ 1 days")).'</td></tr>

                                    <tr><th>'.$alloc_headers['2'].'</th><td><span class="label '.$label.'">'.$status.'</span></td></tr>



                               <tr> <th>'.$alloc_headers['3'].'</th>';



                                $alloc_count = $CI->Allocationinfo->get_user_alloc_count($this->session->userdata('uid'));

                                $alloc_rows=$CI->Trackinginfo->get_alloc_confirmed_users($alloc['userid'],$alloc['parking']);

                                if($stat!=2){

                                    if($alloc_count==TOTALALLOC)

                                    {

                                        if($alloc_rows==1)

                                            echo '<td><a href="#" class="btn btn-xs btn-success" data-id="3" data-toggle="modal" data-target="#myModal'.$alloc['parking'].'">'.$this->lang->line('confirm').'</button></td>';

                                        ?>



                                        <!-- Modal -->

                                        <div class="modal fade" id="myModal<?php echo $alloc['parking']; ?>" role="dialog">

                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">

                                                    <div class="modal-header">

                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                        <h4 class="modal-title"><?php echo $this->lang->line('parking_change_confirm'); ?></h4>

                                                    </div>

                                                    <?php

                                                    $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "change_parking");

                                                    echo form_open("tracking/alloc_change/", $attributes);

                                                    ?>

                                                    <div class="modal-body">

                                                        <div class="form-group">

                                                            <label for="inputPassword3" class="col-sm-12"><?php echo $this->lang->line('parking_change'); ?></label>

                                                        </div>



                                                        <div class="form-group">

                                                            <?php



                                                            $alloc_info = $CI->Allocationinfo->get_user_alloc($this->session->userdata('uid'));

                                                            if (!empty($alloc_info))

                                                            {

                                                                foreach($alloc_info as $key=>$val){

                                                                    $to_date=($val['to_date']=='0000-00-00')?'':$val['to_date'];

                                                                    echo '<div class="col-sm-6">

                                        <input type="radio" name="status"  value="'.$val['id'].'" > &nbsp;&nbsp;  '.$val['parking_name'].'</div>';

                                                                }

                                                            }

                                                            ?>

                                                            <label  id="error_show" for="name" generated="true" class="error pull-left" style="text-align: center !important;display: none;">Please Select which Parking do you want Change?</label>

                                                        </div>

                                                    </div>

                                                    <input type="hidden" name="parking_id" id="parking_id" value="<?php echo $alloc['parking']; ?>">

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>



                                                        <input type="submit" name="submit" class="btn btn-success pull-right" value="<?php echo $this->lang->line('submit'); ?>">

                                                    </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    <?php

                                    }else{

                                        if($alloc_rows==1)

                                        { ?>

                                            <td><a id="Delete" data-toggle="alloc_confirm" data-title="<?php echo $this->lang->line('thank_you_for_confirmation'); ?>" href="<?php echo site_url('tracking/alloc_confirm/'.$alloc['parking']); ?>">

                                                    <button type="button" class="btn  btn-xs btn-success"><?php echo $this->lang->line('confirm'); ?></button>

                                                </a>

                                        <?php }

                                    }

                                }

                                ?>

                               <td> <a id="Delete" data-toggle="alloc_cancel" data-title="<?php echo $this->lang->line('decline_allocation_msg'); ?>" href="<?php echo site_url('tracking/alloc_cancel/'.$alloc['parking']); ?>">

                                        <button type="button" class="btn btn-xs btn-danger"><?php echo $this->lang->line('decline'); ?></button></td>

                                </a>

                                <?php

                                echo '</tr>';

                             $cnt++;

                            }

                            if($cnt==1)

                            {

                                echo '<tr><td colspan="5">'.$this->lang->line('no_records_available').'</td></tr>';

                            }

                            ?>

                        </table>





                            <table class="table table-bordered table-striped hidden-xs">

                                <?php

                                $cnt=1;

                                $result_alloc = $CI->Trackinginfo->get_alloc($userid);

                                echo '<tr>';

                                foreach($alloc_headers as $key=>$val)

                                    echo '<th class="col-md-3">'.$val.'</th>';

                                echo '</tr>';

                               foreach($result_alloc as $key=>$alloc){

                                   $stat=0;

                                if($alloc['status']==0)

                                {

                                    $status=$this->lang->line('alloted');;

                                    $label='label-primary';

                                    $stat=1;

                                }else{

                                    $status=$this->lang->line('waiting_for_decision');

                                    $label='label-warning';

                                    $stat=2;

                                }



                                echo '<tr>

                                    <td>'.$alloc['parking_name'].'</td>



                                  <td>'.$parking_type[$alloc['park_type']].'</td>

                                    <td>'.date('Y-m-d', strtotime($alloc['end_date']."+ 1 days")).'</td>

                                    <td><span class="label '.$label.'">'.$status.'</span></td>';



                                $alloc_count = $CI->Allocationinfo->get_user_alloc_count($this->session->userdata('uid'));

                                $alloc_rows=$CI->Trackinginfo->get_alloc_confirmed_users($alloc['userid'],$alloc['parking']);

                                if($stat!=2){

                                    if($alloc_count==TOTALALLOC)

                                    {

                                        if($alloc_rows==1)

                                        echo '<td><a href="#" class="btn btn-xs btn-success" data-id="3" data-toggle="modal" data-target="#myModal'.$alloc['parking'].'">'.$this->lang->line('confirm').'</button></td>';

                                    ?>

                                        <!-- Modal -->

                                        <div class="modal fade" id="myModal<?php echo $alloc['parking']; ?>" role="dialog">

                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">

                                                    <div class="modal-header">

                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                        <h4 class="modal-title"><?php echo $this->lang->line('allocation_confirm'); ?></h4>

                                                    </div>

                                                    <?php

                                                    $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "change_parking");

                                                    echo form_open("tracking/alloc_change/", $attributes);

                                                    ?>

                                                    <div class="modal-body">

                                                        <div class="form-group">

                                                            <label for="inputPassword3" class="col-sm-12"><?php echo $this->lang->line('parking_change'); ?></label>

                                                        </div>



                                                        <div class="form-group">

                                                            <?php



                                                            $alloc_info = $CI->Allocationinfo->get_user_alloc($this->session->userdata('uid'));

                                                            if (!empty($alloc_info))

                                                            {

                                                                foreach($alloc_info as $key=>$val){

                                                                    $to_date=($val['to_date']=='0000-00-00')?'':$val['to_date'];

                                                                    echo '<div class="col-sm-6">

                                        <input type="radio" name="status"  value="'.$val['id'].'" > &nbsp;&nbsp;  '.$val['parking_name'].'</div>';

                                                                }

                                                            }

                                                            ?>

                                                            <label  id="error_show" for="name" generated="true" class="error pull-left" style="text-align: center !important;display: none;"><?php echo $this->lang->line('change_parking'); ?></label>

                                                        </div>

                                                    </div>

                                                    <input type="hidden" name="parking_id" id="parking_id" value="<?php echo $alloc['parking']; ?>">

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>



                                                        <input type="submit" name="submit" class="btn btn-success pull-right" value="<?php echo $this->lang->line('submit'); ?>">

                                                    </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    <?php

                                    }else{

                                        if($alloc_rows==1)

                                        { ?>

                                        <td><a id="Delete" data-toggle="alloc_confirm" data-title="<?php echo $this->lang->line('thank_you_for_confirmation'); ?>" href="<?php echo site_url('tracking/alloc_confirm/'.$alloc['parking']); ?>">

                                            <button type="button" class="btn  btn-xs btn-success"><?php echo $this->lang->line('confirm'); ?></button>

                                        </a></td>

                                        <?php }

                                    }

                                }

                                ?>

                                <td><a id="Delete" data-toggle="alloc_cancel" data-title="<?php echo $this->lang->line('decline_allocation_msg'); ?>" href="<?php echo site_url('tracking/alloc_cancel/'.$alloc['parking']); ?>">

                                    <button type="button" class="btn btn-xs btn-danger"><?php echo $this->lang->line('decline'); ?></button></td>

                                </a>

                               <?php

                               echo '</tr>';

                                   $cnt++;

                               }



                                if($cnt==1)

                                {

                                    echo '<tr><td colspan="5" style="text-align:center;">'.$this->lang->line('no_records_available').'</td></tr>';

                                }

                                ?>

                            </table>

                        </div>



                            <!-- /.box-body -->

            <?php } ?>

<?php } ?>



                    <div class="box-footer">

                        <h3>

                            <?php echo $this->lang->line('user_details'); ?>

                        </h3>

                    </div>



                    <div class="box-body table-responsive no-padding">

                        <!--Mobile view -->

                        <table class="table table-bordered table-striped visible-xs">

                            <?php

                           /* echo '<tr>';

                            foreach($alloc_headers_parking as $key=>$val)

                                echo '<th class="col-md-3">'.$val.'</th>';

                            echo '</tr>'; */

                            $next_month_end = date('Y-m-d',strtotime("last day of next month"));

                            //$from_date = date('Y-m-d', strtotime($next_month_end . " +1 days"));



                            $alloc_info = $CI->Allocationinfo->get_user_alloc($this->session->userdata('uid'));

                            if(!empty($alloc_info))

                            {

                                foreach($alloc_info as $key=>$val){

                                    $to_date=($val['to_date']=='0000-00-00')?'':$val['to_date'];

                                    echo '<tr><th>'.$alloc_headers_parking['0'].'</th><td>'.$val['parking_name'].'</td></tr><tr>

                                    <th>'.$alloc_headers_parking['1'].'</th><td>'.$parking_type[$val['type']].'</td></tr><tr>

                                   <th>'.$alloc_headers_parking['2'].'</th> <td>'.$val['from_date'].'</td></tr><tr>

                                   <th>'.$alloc_headers_parking['3'].'</th> <td>'.$to_date.'</td></tr><tr><th>'.$alloc_headers_parking['4'].'</th>';

                                    $name=$this->lang->line('cancel_parking_msg').' <strong> '.$val['parking_name'].' </strong>'. $this->lang->line('from').'<strong> '.$next_month_end.' </strong>';



                                    if($val['status']==1){

                                        ?>

                                        <td><a id="Delete" data-toggle="cancel_parking" data-title="<?php echo $name; ?>" href="<?php echo site_url('tracking/cancel/'. $val['id'].''); ?>">

                                                <i class="ace-icon fa fa-trash-o" title="<?php echo $this->lang->line('cancel_parking'); ?>"></i>

                                            </a></td>

                                    <?php

                                    }else if($val['status']==2){

                                        echo '<td><span class="label label-warning">'.$this->lang->line("end_date_confirmed").'</span></td>';

                                    }else if($val['status']==3){

                                        echo '<td><span class="label label-danger">'.$this->lang->line('closed').'</span></td>';

                                    }

                                  echo '</tr>';

                                }

                            }else

                            {



                                    echo '<tr><td colspan="4" style="text-align:center;">'.$this->lang->line('no_records_available').'</td></tr>';

                            }

                            ?>

                        </table>

                        <!-- Mobile View -->

                        <table class="table table-bordered table-striped hidden-xs">

                            <?php

                            echo '<tr>';

                            foreach($alloc_headers_parking as $key=>$val)

                            echo '<th class="col-md-3">'.$val.'</th>';

                            echo '</tr>';

                            $next_month_end = date('Y-m-d',strtotime("last day of next month"));

                            //$from_date = date('Y-m-d', strtotime($next_month_end . " +1 days"));

                            $alloc_info = $CI->Allocationinfo->get_user_alloc($this->session->userdata('uid'));

                            if (!empty($alloc_info))

                            {

                            foreach($alloc_info as $key=>$val){

                                $to_date=($val['to_date']=='0000-00-00')?'':$val['to_date'];

                            echo '<tr>

                                    <td>'.$val['parking_name'].'</td>

                                    <td>'.$parking_type[$val['type']].'</td>

                                    <td>'.$val['from_date'].'</td>

                                    <td>'.$to_date.'</td>';

                                $name=$this->lang->line('cancel_parking_msg').' <strong> '.$val['parking_name'].' </strong>'. $this->lang->line('from').'<strong> '.$next_month_end.' </strong>';



                                if($val['status']==1){

                                ?>

                                <td><a id="Delete" data-toggle="cancel_parking" data-title="<?php echo $name; ?>" href="<?php echo site_url('tracking/cancel/'. $val['id'].''); ?>">

                                    <i class="ace-icon fa fa-trash-o" title="<?php echo $this->lang->line('cancel_parking'); ?>"></i>

                                </a></td>

                                <?php

                                }else if($val['status']==2){

                                    echo '<td><span class="label label-warning">'.$this->lang->line("end_date_confirmed").'</span></td>';

                                }else if($val['status']==3){

                                    echo '<td><span class="label label-danger">'.$this->lang->line('closed').'</span></td>';

                                }

                                echo '</tr>';

                            }

                            }else

                            {

                                echo '<tr><td colspan="4" style="text-align:center;">'.$this->lang->line('no_records_available').'</td></tr>';

                            }

                            ?>

                        </table>

                    </div>


                    <div class="box-footer text-center hidden-sm-up">
                        mobile view display
                        </div>

                    <div class="box-footer text-center hidden-xs-down">

                        <img src="<?php echo base_url('admin'); ?>/dist/img/Full2.png" alt="Parking" usemap="#Map" class="img-responsive" border="0">
                        <map name="Map" id="Map">
                          <area shape="rect" coords="4,423,521,843" class="fancybox" rel="g1" href="<?php echo base_url('admin'); ?>/dist/img/Area1.png" />
                          <area shape="rect" coords="4,7,521,426" class="fancybox" rel="g2" href="<?php echo base_url('admin'); ?>/dist/img/Area2.png"  />
                          <area shape="rect" coords="523,5,1064,423" class="fancybox" rel="g3" href="<?php echo base_url('admin'); ?>/dist/img/Area3.png" />
                          <area shape="rect" coords="523,423,1068,845" class="fancybox" rel="g4" href="<?php echo base_url('admin'); ?>/dist/img/Area4.png" />
                        </map>
                    </div>
                </div>

                <!-- /.box -->

                <!-- general form elements disabled -->



                <!-- /.box -->

            </div>

            <!--/.col (right) -->

        </div>

        <!-- /.row -->



    </div>

</section>

<!-- /.content -->

</div>




<?php

$this->load->view("partial/footer");

?>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->

   <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->





<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->

<script src="<?php echo base_url(); ?>tracker/js/jquery.validate.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('admin'); ?>/fancybox/jquery.fancybox.js"></script>

<script>
 $(document).ready(function(){
       $('.fancybox').fancybox();
   });
function calling(map)
{
	alert("calling "+map);
}
    (function($,W,D)

    {

        var JQUERY4U = {};

        JQUERY4U.UTIL =

        {

            setupFormValidation: function()

            {



                $("#form").validate({

                    rules: {

                        name:

                        {

                            required:true,

                            remote: {

                                url: "<?php echo site_url()?>/parking/register_parking_exists",

                                type: "post",

                                data:

                                {

                                    name: function(){ return $("#name").val(); }



                                }

                        }

                        }

                    },



                    messages: {

                        name: {



                            remote: 'Parking already Added'

                        }

                    },



                    submitHandler: function(form) {

                        form.submit();

                    }

                });

            }

        }



        //when the dom has loaded setup form validation rules

        $(D).ready(function($) {

            JQUERY4U.UTIL.setupFormValidation();

        });



    })(jQuery, window, document);



   </script>





<script src="<?php echo base_url(); ?>/tracker/js/index.js"></script>





<script>

        $('#myModal').click(function(){

           var  my = $("#myModal").attr('data-id');

            alert(my);

            $("#parking_id").val("2");

        })



    $(document).on("click", "[data-toggle=\"confirm\"]", function (e) {

        e.preventDefault();

        var lHref = $(this).attr('href');

        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({

            message: "<?php echo $this->lang->line('start_from_queue'); ?>",

            size:"small",

            buttons: {

                confirm: {

                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',

                    className: 'btn-success'

                },

                cancel: {

                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',

                    className: 'btn-danger'

                }

            },

            callback: function (result) {

                if(result==true)

                {

                    window.location.href = lHref;

                }



            }

        });

    });





    $(document).on("click", "[data-toggle=\"quit\"]", function (e) {

        e.preventDefault();

        var lHref = $(this).attr('href');

        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({

            message: "<?php echo $this->lang->line('are_you_sure_quit_queue'); ?>",

            size:"small",

            buttons: {

                confirm: {

                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',

                    className: 'btn-success'

                },

                cancel: {

                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',

                    className: 'btn-danger'

                }

            },

            callback: function (result) {

                if(result==true)

                {

                    window.location.href = lHref;

                }



            }

        });

    });





</script>





<script>



    $(document).on("click", "[data-toggle=\"cancel_parking\"]", function (e) {

        e.preventDefault();

        var lHref = $(this).attr('href');

        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({

            message: lText,

            size:"small",

            buttons: {

                confirm: {

                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',

                    className: 'btn-success'

                },

                cancel: {

                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',

                    className: 'btn-danger'

                }

            },

            callback: function (result) {

                if(result==true)

                {

                    window.location.href = lHref;

                }



            }

        });

    });





    $(document).on("click", "[data-toggle=\"alloc_confirm\"]", function (e) {

        e.preventDefault();

        var lHref = $(this).attr('href');

        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({

            message: lText,

            size:"small",

            buttons: {

                confirm: {

                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',

                    className: 'btn-success'

                },

                cancel: {

                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',

                    className: 'btn-danger'

                }

            },

            callback: function (result) {

                if(result==true)

                {

                    window.location.href = lHref;

                }



            }

        });

    });



    $(document).on("click", "[data-toggle=\"alloc_cancel\"]", function (e) {

        e.preventDefault();

        var lHref = $(this).attr('href');

        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({

            message: lText,

            size:"small",

            buttons: {

                confirm: {

                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',

                    className: 'btn-success'

                },

                cancel: {

                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',

                    className: 'btn-danger'

                }

            },

            callback: function (result) {

                if(result==true)

                {

                    window.location.href = lHref;

                }



            }

        });

    });





</script>





<script>

    $("#change_parking").submit(function(){



        $("#error_show").hide();

        if($('input[name=status]:checked').length<=0)

        {

            $("#error_show").show();

            return false;

        }else{



            $("#error_show").hide();

            return true;

        }

    })

</script>