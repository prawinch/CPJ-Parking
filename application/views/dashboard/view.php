<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<style>
    th{
        text-align: center;
        vertical-align: middle !important;
    }
    .first-child{
        width: 10% !important;
    }
    .blink {
        opacity: 0;
        animation: blinking 1s linear infinite;
        color:red;

    }

    @keyframes blinking {
        from,
        49.9% {
            opacity: 0;
        }
        50%,
        to {
            opacity: 1;
        }
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $this->lang->line('dashboard'); ?>
        </h1>
    </section>
    <?php
    //$CI=&get_instance();
    $users=$this->Commoninfo->get_count('admin')-1;
    $parking=$this->Commoninfo->get_count('parking');
    $queue=$this->Commoninfo->get_count('queue');
    $alloc_confirm=$this->Commoninfo->get_count_id('parking_allocation','status','1');
    $alloc_cancel=$this->Commoninfo->get_count_id('parking_allocation','status','2');
    $alloc=$alloc_confirm+$alloc_cancel;
    $parking_used=$this->Parkinginfo->get_parking_count(1);
    $parking_free=$this->Parkinginfo->get_parking_count(0);
    ?>
    <style>
        .small-box{
           cursor: pointer;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6" id="users_box">
                <!-- small box -->

                <div class="small-box bg-aqua" >
                    <div class="inner">
                        <h3><?php echo $users; ?></h3>

                        <p><?php echo $this->lang->line('users'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo site_url('registration'); ?>" class="small-box-footer"><?php echo $this->lang->line('more_info'); ?><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6" id="parking_box">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $parking; ?></h3>
                        <p><?php echo $this->lang->line('parking'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-model-s"></i>
                    </div>
                    <a href="<?php echo site_url('parking'); ?>" class="small-box-footer"><?php echo $this->lang->line('more_info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6" id="allocation_box">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $alloc; ?></h3>
                        <p><?php echo $this->lang->line('allocation'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pull-request"></i>
                    </div>
                    <a href="<?php echo site_url('allocation'); ?>" class="small-box-footer"><?php echo $this->lang->line('more_info'); ?><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6" id="queue_box">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $queue; ?></h3>
                        <p><?php echo $this->lang->line('queue'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="<?php echo site_url('queue'); ?>" class="small-box-footer"><?php echo $this->lang->line('more_info'); ?><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <?php echo $this->lang->line('approve')." ".$this->lang->line('parking'); if(!empty($approve_result)){ ?><span class="blink" style="padding-left: 20px;">&nbsp;&nbsp;<?php echo $this->lang->line('approve'); ?></span><?php } ?> </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <?php
                                $visible=array('','','','','hidden-xs','hidden-xs','hidden-xs','hidden-xs','','');
                                foreach($approve_headers as $key=>$val){
                                    $class=($key==0)?"first-child":'';
                                    echo '<th style="text-align:left;" class="'.$class.' '.$visible[$key].'">'.$val.'</th>';
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i=1;
                            $cnt=1;
                            $CI =& get_instance();
                            $bg_color=array('label-warning','label-success','label-danger','label-grey');
                            foreach ($approve_result as $key=>$row)
                            {
                                $parking_info = $CI->Parkinginfo->get_info($row['parking']);
                                $group= $CI->Parkinginfo->get_parking_group($parking_info->parking_group);

                                //   $parking_type=$parking_info->type;
                                $user_info = $CI->Reginfo->get_info($row['user']);
                                $fdate=$row['from_date'];
                                $edate=($row['to_date']=='0000-00-00')?'':$row['to_date'];

                                $username=$user_info->firstname." ".$user_info->lastname;
                                $parking=$parking_info->name;
                                $persons=$parking_info->used_persons+1;
                                $persons=$CI->Commoninfo->str_pad_left($persons,2);
                                $contract_no=$group['name']."-".$parking."-".$persons;
                                echo '<tr><td>'.$i.'</td>
                                <td>'.$contract_no.'</td>
                                <td>'.$parking.'</td>
                                <td>'.$parking_type[$parking_info->type].'</td>
                                <td class="'.$visible['4'].'">'.$user_info->apartment_no.'</td>
                                <td class="'.$visible['5'].'">'.$username.'</td>
                                <td class="'.$visible['6'].'" >'.$user_info->pin.'</td>
                                <td class="'.$visible['7'].'">'.$user_info->mobile.'</td></tr>';
                                $i++;
                            }
                            if($i==1)
                                echo "<tr><td colspan='8' style='text-align: center;'>".$this->lang->line('no_records_available')."</td></tr>";
                            ?>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->


        <div class="row">

            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('parking'); ?></h3>

                        <div class="box-tools pull-right" style="display: none;">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>


            <div class="col-md-6" >
                <div class="box box-danger">
                    <div class="box-header with-border">


                        <h3 class="box-title"><?php echo $this->lang->line('parking_type'); ?></h3>

                    </div>
                    <?php
                    $i=1;
                    $park_value='';
                    foreach ($parking_type as $key=>$row)
                    {
                        if($key==0)continue;
                        $total_parking=$this->Commoninfo->get_count_id('parking','type',$key);
                        $park_value .= $total_parking.",";
                        $i++;
                    }
                    ?>

                    <div class="box-body text-center">
                        <div id="donut-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body-->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->



        </div>
        <!-- /.row -->




        <div class="row">


            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('queue_members'). " - ".$this->lang->line('top'). " 10 "; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <?php
                                foreach($queue_headers as $keyy=>$vall){
                                    $class=($keyy==0)?"first-child":'';
                                   echo '<th class="'.$class.'">'.$vall.'</th>';
                                }
                                echo '</tr>';
                                $i=1;
                                foreach ($queue_list as $key=>$row)
                                {
                                    $username=ucfirst($row['firstname'])." ".ucfirst($row['lastname']);
                                    $status=$this->Trackinginfo->get_status();
                                    echo '<tr><td>'.$i.'</td>
                                    <td>'.$username.'</td>
                                    <td>'.$row['apartment'].'</td>
                                    <td>'.$status[$row['position_status']].'</td></tr>';
                                    $i++;
                                }
                                if($i==1)
                                    echo "<tr><td colspan='4' style='text-align: center;'>".$this->lang->line('no_records_available')."</td></tr>";

                                ?>

                                                    </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
           </div>
            <!-- /.col -->

            <div class="col-md-6" style="display:none;">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('parking_type'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <?php
                                foreach($parking_headers as $key=>$val)
                                    echo '<th>'.$val.'</th>';
                                echo '</tr>';
                                $i=1;
                                $park=array();
                                $increase=0;
                                foreach ($parking_type as $key=>$row)
                                {
                                    if($key==0)continue;

                                    $total_parking=$this->Commoninfo->get_count_id('parking','type',$key);
                                    echo '<tr><td>'.$i.'</td>
                                    <td>'.$row.'</td>
                                    <td>'.$total_parking.'</td>
                                    </tr>';
                                    if($total_parking<10)
                                        $increase=25;

                                    $park[$i]=$total_parking;
                                    $i++;

                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->






        <input type="hidden" name="spark" id="spark" value="<?php echo $park_value; ?>">
    </section>
    <!-- /.content -->
</div>

<?php
$this->load->view("partial/footer");
?>

<!-- jQuery 2.2.3 -->
<!--<script src="<?php echo base_url('admin'); ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<!-- Bootstrap 3.3.6 -->
<!--<script src="<?php echo base_url('admin'); ?>/bootstrap/js/bootstrap.min.js"></script>-->
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('admin'); ?>/plugins/chartjs/Chart.min.js"></script>

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url('admin'); ?>/plugins/morris/morris.min.js"></script>

<!-- FastClick -->
<script src="<?php echo base_url('admin'); ?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<!--<script src="<?php echo base_url('admin'); ?>/dist/js/app.min.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('admin'); ?>/dist/js/demo.js"></script>
<!-- page script -->

<!-- jQuery Knob -->
<script src="<?php echo base_url('admin'); ?>/plugins/knob/jquery.knob.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('admin'); ?>/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- FLOT CHARTS -->
<script src="<?php echo base_url('admin'); ?>/plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url('admin'); ?>/plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url('admin'); ?>/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?php echo base_url('admin'); ?>/plugins/flot/jquery.flot.categories.min.js"></script>
<!-- Page script -->

<script>
$(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //DONUT CHART
    var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: [ "#f56954", "#00a65a"],
        data: [
            {label: "<?php echo $this->lang->line('available'); ?>", value: <?php echo $parking_free; ?>},
            {label: "<?php echo $this->lang->line('allocated'); ?>", value: <?php echo $parking_used; ?>}
        ],
        hideHover: 'auto'
    });


});

   $("#users_box").click(function()
   {
       document.location.href ="<?php echo site_url('registration'); ?>";

   })

$("#parking_box").click(function()
{
    document.location.href ="<?php echo site_url('parking'); ?>";

})


$("#allocation_box").click(function()
{
    document.location.href ="<?php echo site_url('allocation'); ?>";

})


$("#queue_box").click(function()
{
    document.location.href ="<?php echo site_url('queue'); ?>";

})



$(function () {
    /* jQueryKnob */


    //INITIALIZE SPARKLINE CHARTS
   $(".sparkliene").each(function () {
        var $this = $(this);
        $this.sparkline('html', $this.data(
        ));
    });

   // var values = [33, 32, 33];;
    var spark_value = $('#spark').val().split(",");


    //spark_value[0]='44';
    var donutData = [

        {label: "<?php echo $parking_type['1']; ?><br>" + spark_value[0], data: '<?php echo $park[1]+$increase; ?>', color: "#f39c12"},
        {label: "<?php echo $parking_type['2']; ?><br>" + spark_value[1], data: '<?php echo $park[2]+$increase;; ?>', color: "#f56954"},
        {label: "<?php echo $parking_type['3']; ?><br>" + spark_value[2], data: '<?php echo $park[3]+$increase;; ?>', color: "#00a65a"},
        {label: "<?php echo $parking_type['4']; ?><br>" + spark_value[3], data: '<?php echo $park[4]+$increase;; ?>', color: "#3c8dbc"}
    ];
    $.plot("#donut-chart", donutData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.5,
                label: {
                    show: true,
                    radius: 3 / 4,
                    formatter: labelFormatter,
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    });
    /*
     * END DONUT CHART
     */
    /*
     * Custom Label formatter
     * ----------------------
     */
    function labelFormatter(label, series) {
        return '<div style="font-size:12px; text-align:center; padding:10px; color: #fff; font-weight: 600;">'
            + label  +  "</div>";
    }
});

</script>
</body>
</html>



