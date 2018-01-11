<?php $this->load->view("partial/login_header"); ?>
<body class="hold-transition login-page" style="background-color: #3bc4ec; overflow: hidden">
<div class="register-box">
    <div class="login-logo">
        <img src="<?php echo base_url('admin'); ?>/dist/img/oman_logo.png" height="100">
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <?php echo form_open('signup'); ?>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="<?php echo set_value('firstname')?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span class="error"><?php echo form_error('firstname')?></span>
            </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="<?php echo set_value('lastname')?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="error"><?php echo form_error('lastname')?></span>
        </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo set_value('email')?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <span class="error"><?php echo form_error('email')?></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <span class="error"><?php echo form_error('password')?></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Retype password" id="cpassword" name="cpassword">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                <span class="error"><?php echo form_error('cpassword')?></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                   <!-- <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                        </label>
                    </div> !-->
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                     <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                Google+</a>
        </div> !-->

        Already Register - <a href="login" class="text-center"> Login Here </a>
    </div>
    <!-- /.form-box -->
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
    .login-box-body {
        border: 1px dashed #f35400;
        outline: 2px dotted #297900;
        box-shadow: 5px 5px 5px 5px;
    }

    .error
    {
        color: red;
    }

</style>
</body>