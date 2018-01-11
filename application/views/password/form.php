<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>

<style>

    #registration label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: right;
        font-size:12px;
        font-style: italic;
        margin-left:6px;
        width:99%;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
         <?php echo $this->lang->line('password')."<small>".$this->lang->line('update').'</small>'; ?>

    </h1>
    <ol class="breadcrumb" style="display: none;">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('password'); ?>">List</a></li>
        <li class="active">Add</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="box box-default">


<div class="row">
<!-- left column -->
<div class="col-md-6">
    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $this->lang->line('update_password'); ?></h3>
        </div>

        <?php if($this->session->flashdata('message')){?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('message')?>
            </div>

        <?php } ?>


        <?php if($this->session->flashdata('danger')){?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4> <?php echo $this->session->flashdata('danger')?>
            </div>

        <?php } ?>


        <!-- /.box-header -->
        <!-- form start -->
        <form  class="form-horizontal" action="<?php echo site_url();?>/password/save/" name="registration" id="registration" enctype="multipart/form-data"   method="post">

            <div class="box-body">



                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('old_password'); ?></label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $this->lang->line('old_password'); ?>" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('new_password'); ?></label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="npassword" id="npassword" placeholder="<?php echo $this->lang->line('new_password'); ?>" value="">
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('confirm_password'); ?></label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" value="">
                    </div>
                </div>

                <input type="hidden" class="form-control" name="oldpass" id="oldpass" placeholder="Confirm Password" value="<?php echo base64_decode(base64_decode($password['password'])); ?>">


                <!--  <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-9">
                          <div class="checkbox">
                              <label>
                                  <input type="checkbox"> Remember me
                              </label>
                          </div>
                      </div>
                  </div>-->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <input type="submit" name="submit" value="<?php echo $this->lang->line('update'); ?>"  class="btn btn-info pull-right" id="submit"/>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
    <!-- /.box -->

</div>
<!--/.col (left) -->

</div>
<!-- /.row -->

</div> <!--box body end-->

</section>
<!-- /.content -->
</div>


<?php
$this->load->view("partial/footer");
?>



<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>



<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>



<!-- Select2 -->
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>






<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url(); ?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        //Date picker
        $('#datepicker2').datepicker({
            autoclose: true
        });


        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
    });
</script>


<!-- //login -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-3.1.1.min.js"></script>


<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>-->
<script src="<?php echo base_url(); ?>tracker/js/jquery.validate.min.js"></script>

<script src="<?php echo base_url(); ?>tracker/js/additional-methods.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>tracker/js/additional-methods.min.js"></script>

<script>
    (function($,W,D)
    {
        var JQUERY4U = {};
        JQUERY4U.UTIL =
        {
            setupFormValidation: function()
            {

                $("#registration").validate({
                    rules: {

                        password:
                        {
                            required:true,
                            equalTo:"#oldpass"
                           // remote: {url: "password/old", type : "post"}
                        },
                        npassword:
                        {
                            required:true
                        }
                        ,cpassword:
                        {
                            required:true,
                            equalTo:'#npassword'
                        }

                    },
                    messages: {
                        password:
                        {
                            required:"<?php echo $this->lang->line('please_enter_old_password'); ?>",
                            equalTo:"<?php echo $this->lang->line('please_enter_valid_password'); ?>"
                           // remote:"Please Enter Correct Password"
                        }                        ,
                        npassword:
                        {
                            required:"<?php echo $this->lang->line('please_enter_new_password'); ?>"
                        },
                        cpassword:
                        {
                            required:"<?php echo $this->lang->line('please_enter_re_type_password'); ?>",
                            equalTo:"<?php echo $this->lang->line('please_enter_confirm_password'); ?>"
                        }

                    },
                    submitHandler: function(form) {
                        $("#submit").hide();
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


    </body>
</html>


