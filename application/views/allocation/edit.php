<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Allocation Parking
        </h1>
        <div class="col-sm-1 pull-right but">
            <a href="<?php echo base_url()?>index.php/allocation"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Back</button> </a>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-default">
            <div class="row">

                <div class="col-md-6">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update- Parking Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php

                        $CI =& get_instance();
                        $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");
                        echo form_open("allocation/save/$alloc_info->id", $attributes);

                        $parking_info = $CI->Parkinginfo->get_info($alloc_info->parking);
                        $user_info = $CI->Reginfo->get_info($alloc_info->user);

                        $username=$user_info->apartment_no. ", ". $user_info->firstname." ".$user_info->lastname;
                        $parking=$parking_info->name;

                        ?>
                        <input type="hidden" id="rowid" name="rowid" value="<?php //echo $type_info->Property_type_id ?>">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Parking</label>
                                <div class="col-sm-9">
                                    <?php echo $parking; ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">User</label>
                                <div class="col-sm-9">
                                   <?php echo $username; ?>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">From Date</label>

                                <div class="date col-sm-9">
                                    <!-- <div class="input-group-addon">
                                         <i class="fa fa-calendar"></i>
                                     </div>-->
                                    <input type="text" placeholder="Select From Date" class="form-control pull-right" name="from_date" id="datepicker" value="<?php echo $alloc_info->from_date; ?>">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->


                            <!-- Date -->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">To Date</label>

                                <div class="col-sm-9">
                                    <!--<div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>-->
                         <?php   $to_date=($alloc_info->to_date=='0000-00-00')?'':$alloc_info->to_date; ?>
                                    <input type="text" placeholder="Select End Date" class="form-control pull-right" name="to_date" id="datepicker2" value="<?php echo $to_date; ?>">

                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->


                          <!--  <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="status" id="status">
                                        <?php

                                        $select='<option value="">Select Status</option>';
                                        foreach($status as $key=>$val){
                                            if($key==0)continue;

                                            $selected=($alloc_info->status==$key)?'Selected="selected"':'';
                                            $select.='<option value='.$key.' '.$selected.'>'.$val.'</option>';
                                        }
                                        echo $select;
                                        ?>
                                    </select>

                                </div>
                            </div>-->


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">

                            <input type="submit" name="submit" class="btn btn-primary pull-right" value="<?php echo $this->lang->line('update'); ?>">
                        </div>
                        <!-- /.box-footer -->
                        <?php echo form_close(); ?>

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

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script>

    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format:'yyyy-mm-dd'
    });

    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true,
        format:'yyyy-mm-dd'
    });

    (function($,W,D)
    {
        var JQUERY4U = {};
        JQUERY4U.UTIL =
        {
            setupFormValidation: function()
            {

                $("#form").validate({
                    rules: {
                        parking:
                        {
                            required:true
                        },
                        user:
                        {
                            required:true
                        },
                        from_date:
                        {
                            required:true
                        }
                    },

                    messages: {
                        parking: {

                            required: 'Please Select Parking'
                        },
                        user:
                        {
                            required: 'Please Select User'
                        },
                        from_date:
                        {
                            required: 'Please Select Start Date'
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








