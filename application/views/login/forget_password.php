<?php $this->load->view("partial/login_header"); ?>
<body class="hold-transition login-page" style="background-color: #3bc4ec; overflow: hidden">
<div class="login-box">
    <div class="login-logo">
        <img src="dist/img/oman_logo.png" height="100">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"> <i class="fa fa-envelope"></i> &nbsp; Forget your Password ? </p>

        <form action="../../index2.html" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Enter your Email Address">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <!-- <div class="checkbox icheck">
                         <label>
                             <input type="checkbox"> Remember Me
                         </label>
                     </div> !-->
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">  Send </button>
                </div>
                <div class="col-xs-4">
                    <!-- <div class="checkbox icheck">
                         <label>
                             <input type="checkbox"> Remember Me
                         </label>
                     </div> !-->
                </div>
                <!-- /.col -->
            </div>
        </form>


        <!-- /.social-auth-links -->
        <a href="index.php">Return to Login</a>


    </div>


    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
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
</style>
</body>