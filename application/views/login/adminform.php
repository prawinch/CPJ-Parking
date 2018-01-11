<?php $this->load->view("partial/login_header"); ?>
<body class="hold-transition login-page" style="overflow: hidden">

<div class="login-box">


    <div class="login-logo" style="margin-left:auto;margin-right: auto;display:none;">
        <img src="<?php echo base_url('admin'); ?>/dist/img/logo.jpeg" class="img-center img-responsive">
    </div>


    <?php if($this->session->flashdata('msg')){?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-ban"></i><?php echo $this->session->flashdata('msg')?>
        </div>
    <?php } ?>
    <!-- /.login-logo -->
    <div class="login-box-body" style="background-color: #34495E;">

        <p class="login-box-msg"> <img src="<?php echo base_url('admin'); ?>/dist/img/logo.png" class="img-center img-responsive"></p>
        <p class="login-box-msg"> <i class="fa fa-user"></i> &nbsp; <?php echo $this->lang->line('login_to_your_account'); ?>  </p>
        <!-- <div id="error">
            <?php echo validation_errors(); ?>
        </div> !-->

        <?php echo form_open('admin'); ?>

        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('username'); ?>" name="username" id="username" value="<?php echo set_value('username'); ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="error text-right"><?php echo form_error('username'); ?></span>
        </div>

        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" name="password" id="password" value="<?php echo set_value('password'); ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="error text-right"><?php echo form_error('password'); ?></span>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <!-- <div class="checkbox icheck">
                     <label>
                         <input type="checkbox"> Remember Me
                     </label>
                 </div> !-->
            </div>
            <!-- /.col -->
            <div class="col-xs-4">

                <input type="submit" class="btn btn-primary btn-block btn-flat" value="<?php echo $this->lang->line('login'); ?>"/>
            </div>
            <!-- /.col -->
        </div>
        <?php echo form_close(); ?>




        <!-- <a href="login/forget_password">I forgot my password</a> !-->

        <!-- New User? <a href="signup">Sign Up Here</a>  !-->



    </div>


    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('admin')?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('admin')?>/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('admin')?>/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<style>
    /*.login-box-body {
        border: 1px dashed #f35400;
        outline: 2px dotted #297900;
        box-shadow: 5px 5px 5px 5px;
    }*/

    .error
    {
        color: red;
    }

    .alert-danger {
        background-color: #f2dede !important;
        border-color: #ebccd1 !important;
        color: #a94442 !important;
    }

</style>
</body>