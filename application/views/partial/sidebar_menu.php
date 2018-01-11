<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('admin'); ?>/dist/img/avatar_grey.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('name'). " ".$this->session->userdata('lastname'); ?></p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>
        <!-- search form -->
       <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->

        <?php

        $master_array=array('dashboard','registration','parking','allocation','approve','queue','reports');

        $display_array=array('dashboard'=>'dashboard','registration'=>'user_details','parking'=>'parking','allocation'=>'allocation','approve'=>'approve','queue'=>'queue','reports'=>'reports');
        $display_icons=array('dashboard'=>'fa-dashboard','registration'=>'fa-user','parking'=>'fa-building-o','allocation'=>'fa-road','approve'=>'fa-check','queue'=>'fa-hand-pointer-o','reports'=>'fa-file');

        ?>

        <ul class="sidebar-menu"><?php
            if(in_array($this->session->userdata('uid'),$this->Reginfo->get_admin_access())){ ?>

            <?php
                foreach($display_array as $key=>$val){
                    if($this->uri->segment(1)==$key){ $class='active'; } else { $class='';}
                        echo '<li class="'.$class.'"><a href="'.site_url($key).'"> <i class="fa fa-fw '.$display_icons[$key].'"></i>    <span>'.$this->lang->line($val).'</span></a></li>';
                   }
            ?>
            <?php } else{?>
            <li><a href="<?php echo site_url('tracking');?>"><i class="fa fa-circle-o text-yellow"></i> <span><?php echo $this->lang->line('parking_status'); ?></span></a></li>
            <?php }?>

            <li><a href="<?php echo site_url('password');?>"><i class="fa fa-key text-red"></i> <span><?php echo $this->lang->line('change_password'); ?></span></a></li>
            <li><a href="<?php echo site_url('logout');?>"><i class="fa fa-circle-o text-aqua"></i> <span><?php echo $this->lang->line('logout'); ?></span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>