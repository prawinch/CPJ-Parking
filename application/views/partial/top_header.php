<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Parking</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/select2/select2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
     <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/plugins/fullcalendar/fullcalendar.print.css" media="print">
  <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/dist/css/skins/_all-skins.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


       <![endif]-->
<!--flag-->


    <link href="<?php echo base_url('admin'); ?>/flags/css/flag-icon.css" rel="stylesheet">
</head>
<style>
    label .error{
        text-align: right !important;
        font-style:italic;
    }

    .first-child{
        width: 5% !important;
    }
    .list th{
        text-align: center;
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .sidebrar{
            display: none;
        }
    }
</style>
<?php


$this->lang->load('common',$this->session->userdata('lang'));
//$this->lang->load('common','sw');

$access_array=array('dashboard','registration','parking','allocation','approve','queue','cron','reports');
if(!in_array($this->session->userdata('uid'),$this->Reginfo->get_admin_access())){
    if(in_array($this->uri->segment(1),$access_array))
        redirect('profile');
}else{

}

?>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">

<header class="main-header">
<!-- Logo -->
<a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>PARK</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Parking</b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>

<div class="navbar-custom-menu">
<ul class="nav navbar-nav">

    <li class="btn-group dropdown-select dropdown user user-menu">
        <a href="#" class="dropdown-toggle dropdown-select" data-toggle="dropdown">

            <?php echo ($this->session->userdata('lang')=='en')?'<span class="flag-icon flag-icon-gb"></span> English':'<span class="flag-icon flag-icon-se"></span> Svenska'; ?>
        </a>
        <ul class="dropdown-menu">

            <li class="user-body">
                <a href="<?php echo site_url('dashboard/lang/en/'.$this->uri->segment(1)); ?>" >
                    <span class="flag-icon flag-icon-gb"></span>
                    English</a></li>
            <li class="user-body"><a href="<?php echo site_url('dashboard/lang/sw/'.$this->uri->segment(1)); ?>" ><span class="flag-icon flag-icon-se"></span>
                    Svenska</a></li>
        </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->

<!-- User Account: style can be found in dropdown.less -->

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo base_url('admin'); ?>/dist/img/avatar_grey.jpg" class="user-image" alt="User Image">
        <span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <img src="<?php echo base_url('admin'); ?>/dist/img/avatar_grey.jpg" class="img-circle" alt="User Image">

            <p>
                <?php echo $this->session->userdata('name'). " " .$this->session->userdata('lastname'); ?>
               <!-- <small>Member since Nov. 2012</small>-->
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body" style="display: none;">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer" style="background-color: #fff !important;border: 2px solid #3c8dbc;">
            <div class="pull-left">
                <a href="<?php echo site_url(''); ?>/profile" class="btn btn-default btn-flat"><?php echo $this->lang->line('profile'); ?></a>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url(''); ?>/registration/logout" class="btn btn-default btn-flat"><?php echo $this->lang->line('sign_out'); ?></a>
            </div>
        </li>
    </ul>
</li>
<!-- Control Sidebar Toggle Button -->
<li>
    <a href="<?php echo site_url(''); ?>/registration/logout"><i class="fa fa-sign-out"></i></a>
</li>
</ul>
</div>
</nav>
</header>

<style>

.but
{
    position:relative;top:-23px
}
.alert-success {
    color: #3c763d !important;
    background-color: #cbe7bf !important;
    border-color: #d6e9c6 !important;
}

</style>

<?php
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}
?>



