<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<style>
    th{
        text-align: center;
        vertical-align: middle !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
        </h1>

    </section>
    <?php
    //$CI=&get_instance();
    $users=$this->Commoninfo->get_count('admin')-1;
    $parking=$this->Commoninfo->get_count('parking');
    $queue=$this->Commoninfo->get_count('queue');
    $alloc=$this->Commoninfo->get_count('alloc');

    $parking_used=$this->Parkinginfo->get_parking_count(1);
    $parking_free=$this->Parkinginfo->get_parking_count(0);

    ?>

    <!-- Main content -->
    <section class="content">


        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $users; ?></h3>

                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $parking; ?></h3>
                        <p>Parking</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-model-s"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $queue; ?></h3>
                        <p>Queue</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-down-c"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $alloc; ?></h3>
                        <p>Allocation</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-swap"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">


            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Queue Members</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <?php
                                foreach($queue_headers as $key=>$val)
                                    echo '<th>'.$val.'</th>';
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
                                ?>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->


            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Parking</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChart" style="height:250px"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col (LEFT) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php
$this->load->view("partial/footer");
?>


<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('admin'); ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('admin'); ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('admin'); ?>/plugins/chartjs/Chart.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('admin'); ?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('admin'); ?>/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('admin'); ?>/dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        ;

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: <?php echo $parking_used; ?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "Allocated"
            },
            {
                value: <?php echo $parking_free; ?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "Available"
            }
        ];
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

    });
</script>
</body>
</html>



