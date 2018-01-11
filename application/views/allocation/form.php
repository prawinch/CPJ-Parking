<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<div class="content-wrapper">
<section class="content-header">
    <h1>
        <?php echo $this->lang->line('allocation')." ".$this->lang->line('parking'); ?>
    </h1>
    <div class="col-sm-1 pull-right but">
        <a href="<?php echo base_url()?>index.php/allocation"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('back'); ?></button> </a>
    </div>

</section>

<!-- Main content -->
<section class="content">

    <div class="box box-default">

<div class="row">

<div class="col-md-6">
    <!-- Horizontal Form -->
    <div class="box box-info text-center">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $this->lang->line('add'); ?> </h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");
        echo form_open("allocation/save/", $attributes);


?>
<input type="hidden" id="rowid" name="rowid" value="<?php //echo $type_info->Property_type_id ?>">

            <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('parking'); ?></label>
                <div class="col-sm-9">
                    <select class="form-control select2" name="parking" id="parking">
                        <?php
                        $select='<option value="">'.$this->lang->line('select_parking').'</option>';
                        foreach($parking_info as $key=>$val){
                            $select.='<option value='.$val['id'].'>'.$val['name'].'</option>';
                        }
                        echo $select;
                        ?>
                    </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('user'); ?></label>
                    <div class="col-sm-9">
                        <select class="form-control select2" name="user" id="user">
                            <?php

                            $CI =& get_instance();
                            $select='<option value="">'.$this->lang->line('select_user').'</option>';
                            foreach($user_info as $key=>$val){

                                $count = $CI->Allocationinfo->get_user_alloc_count($val['id']);
                                //if($count>=2)continue;

                                $select.='<option value='.$val['id'].'>'.$val['apartment_no'].    ', '.$val['firstname']. '' .$val['lastname'].'</option>';
                            }
                            echo $select;
                            ?>
                        </select>

                    </div>
                </div>



                <!-- Date -->
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('from_date'); ?></label>

                    <div class="date col-sm-9">
                       <!-- <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>-->
                        <input type="text" placeholder="<?php echo $this->lang->line('select'). " ".$this->lang->line('from_date'); ?>" class="form-control pull-right" name="from_date" id="datepicker" value="<?php //echo $academic_info->from_date; ?>">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->


                <!-- Date -->
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('to_date'); ?></label>

                    <div class="col-sm-9">
                        <!--<div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>-->
                        <input type="text" placeholder="<?php echo $this->lang->line('select'). " ".$this->lang->line('to_date'); ?>" class="form-control pull-right" name="to_date" id="datepicker2" value="<?php //echo $academic_info->to_date; ?>">

                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->


                <!--<div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="status" id="status">
                            <?php

                            $select='<option value="">Select Status</option>';
                            foreach($status as $key=>$val){
                                if($key==0)continue;
                                $select.='<option value='.$key.'>'.$val.'</option>';
                            }
                            echo $select;
                            ?>
                        </select>

                    </div>
                </div>-->



            </div>
            <!-- /.box-body -->
            <div class="box-footer">

                <input type="submit" name="submit" class="btn btn-primary pull-right" value="<?php echo $this->lang->line('submit'); ?>">
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

<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->
<script src="<?php echo base_url(); ?>tracker/js/jquery.validate.min.js"></script>

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








