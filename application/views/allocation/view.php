<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<style>
   .label-grey{
       background-color: #777;
   }
</style>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        <?php echo $this->lang->line('allocation')." ".$this->lang->line('Parking'); ?>
    </h1>
    <div class="col-sm-1 pull-right but">
        <a href="<?php echo site_url()?>/allocation/add/"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('add'); ?></button> </a>
    </div>

</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <?php if($this->session->flashdata('delete_message')){?>

                <div class="alert alert-success" style="width: 100%">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('delete_message')?>
                </div>

            <?php } ?>

          <?php if($this->session->flashdata('msg')){?>

                    <div class="alert alert-success" style="width: 100%">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('msg')?>
                    </div>

            <?php } ?>


            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped list">
                    <thead>
                    <tr>
                        <?php

                        $visible=array('','','hidden-xs','hidden-xs','hidden-xs','','','');
                        foreach($headers as $key=>$val){
                            $class=($key==0)?"first-child":'';
                            echo '<th class="'.$class.' '.$visible[$key].'">'.$val.'</th>';
                        }
                        ?>
                      </tr>
                    </thead>
                        <tbody>
                    <?php
                    $i=1;
                    $CI =& get_instance();
                    $bg_color=array('label-warning','label-success','label-danger','label-grey');
                    foreach ($h as $key=>$row)
                    {
                        $parking_info = $CI->Parkinginfo->get_info($row['parking']);
                        $user_info = $CI->Reginfo->get_info($row['user']);
                        $fdate=$row['from_date'];
                        $edate=($row['to_date']=='0000-00-00')?'':$row['to_date'];

                        $next_month_end = date('Y-m-d',strtotime("last day of next month"));

                        $username=$user_info->firstname." ".$user_info->lastname;
                        $parking=$parking_info->name;
                        $name=$this->lang->line('cancel_parking_msg').' <strong> '.$parking_info->name.' </strong>'. $this->lang->line('from').'<strong> '.$next_month_end.' </strong>';

                        echo '<tr><td>'.$i.'</td>
                        <td>'.$parking.'</td>
                        <td class="'.$visible['2'].'">'.$username.'</td>
                        <td class="'.$visible['3'].'">'.$fdate.'</td>
                        <td class="'.$visible['4'].'">'.$edate.'</td>';
                        echo '<td class="text-center"><small class="label '.$bg_color[$row['status']].'">'.$parking_status[$row['status']].'</small></td>';

                        ?>
                        <td>
                            <a class="green get_rowid"  href="<?php echo site_url('allocation/edit/'.$row['id'].'')?>">
                                <i class="ace-icon fa fa-pencil" title="<?php echo $this->lang->line('edit'); ?>"></i>
                            </a>

                            <?php if($row['status']=='0' || $row['status']==1){

                                if($row['status']=='0')
                                    $url=site_url('tracking/cancel_admin/'. $row['id'].'/1');
                                else
                                $url=site_url('tracking/cancel/'. $row['id'].'/1');


                                ?>
                            <a id="Delete" data-toggle="confirm" data-title="<?php echo $name; ?>" href="<?php echo $url; ?>">
                                <i class="ace-icon fa fa-trash-o" title="<?php echo $this->lang->line('delete');?>"></i>
                            </a>
                            <?php } ?>

                        </td>
                        </tr>
                    <?php
                    $i++;
                    }
                    ?>
                    </tbody>
                        </table>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- general form elements disabled -->

            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
</div>

<?php
$this->load->view("partial/footer");
?>
<script>

    $(document).on("click", "[data-toggle=\"confirm\"]", function (e) {
        e.preventDefault();
        var lHref = $(this).attr('href');
        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({
            message: lText,
            size:"small",
            width:"500px",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> <?php echo $this->lang->line('yes'); ?>',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> <?php echo $this->lang->line('no'); ?>',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result==true)
                {
                    window.location.href = lHref;
                }

            }
        });
    });



</script>


