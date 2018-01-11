<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    
    <?php
        $filename=$_SERVER['PHP_SELF'];
        $tmp=explode('/',$filename);
    $fname=end($tmp);
        $file_array=array('enquiry_detail.php','confirm_detail.php','payment_detail.php','voucher_detail.php','lic_new_deatil.php');
        $master_array=array('license_type_detail.php');
        // $table_array=array('book_fee_details.php','login_details.php','trans_fee_details.php','school_fee_details.php','entry_fee_details.php');
        ?>
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>!-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
        
             <li <?php if($fname=='userdetails.php') { echo 'class="active"'; } ?>>
                <a href="userdetails.php">
                    <i class="fa fa-user"></i> <span>User Details</span>
              </a>
            </li>
            <li <?php if($fname=='hall.php') { echo 'class="active"'; } ?>>
                <a href="hall.php">
                    <i class="fa fa-building-o"></i> <span>Hall Details</span>
              </a>
            </li>
             <li <?php if($fname=='gym.php') { echo 'class="active"'; } ?>>
                <a href="gym.php">
                    <i class="fa fa-road"></i> <span>Gym Details</span>
              </a>
            </li>
            <li <?php if($fname=='hallbook_details.php') { echo 'class="active"'; } ?>>
                <a href="hallbook_details.php">
                    <i class="fa fa-building-o"></i> <span>Hall Booking Details</span>
              </a>
            </li>
            <li <?php if($fname=='gymbook_details.php') { echo 'class="active"'; } ?>>
                <a href="gymbook_details.php">
                    <i class="fa fa-road"></i> <span>Gym Booking Details</span>
              </a>
            </li>
            <li <?php if($fname=='payment.php') { echo 'class="active"'; } ?>>
                <a href="payment.php">
                    <i class="fa fa-credit-card"></i> <span>Payment Transaction</span>
                </a>
            </li>
            <!-- <li <?php if($fname=='poolbook_details.php') { echo 'class="active"'; } ?>>
                <a href="poolbook_details.php">
                    <i class="fa fa-stumbleupon"></i> <span>Swimming Booking Details</span>
              </a>
            </li> !-->
             <li <?php if($fname=='login_detail.php') { echo 'class="active"'; } ?>>
                <a href="login_detail.php">
                    <i class="fa fa-user"></i> <span>Login Detail</span>
              </a>
            </li>
            
              </ul>
    </section>
    <!-- /.sidebar -->
</aside>