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
        <?php echo $this->lang->line('approve')." ".$this->lang->line('parking'); ?>
    </h1>

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
                        $visible=array('','','','','hidden-xs','hidden-xs','hidden-xs','hidden-xs','','');
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
                        <td class="'.$visible['7'].'">'.$user_info->mobile.'</td>';

                        $msg=$this->lang->line("do_you_want_approve")." ".$this->lang->line('parking_name')." ".$parking." - ".$parking_type[$parking_info->type];

                        ?>
                        <td>
                            <a id="Delete" data-toggle="alloc_confirm" data-title="<?php echo $msg; ?>" href="<?php echo site_url('approve/confirm/'.$row['parent_id'].'/'.$row['id']); ?>">
                                <button type="button" class="btn  btn-xs btn-success"><?php echo $this->lang->line('approve'); ?></button>
                            </a>
                            <a id="Delete" data-toggle="alloc_cancel" data-title="<?php echo $this->lang->line('decline_parking_msg'); ?>" href="<?php echo site_url('approve/cancel/'.$row['parent_id'].'/'.$row['id']); ?>">
                                <button type="button" class="btn btn-xs btn-danger"><?php echo $this->lang->line('decline'); ?></button></td>
                        </a>
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
            message: "<?php echo $this->lang->line('delete_parking_msg'); ?> " +lText+" ?",
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





    $(document).on("click", "[data-toggle=\"alloc_confirm\"]", function (e) {
        e.preventDefault();
        var lHref = $(this).attr('href');
        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text
        bootbox.confirm({
            message: lText,
            size:"small",
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

    $(document).on("click", "[data-toggle=\"alloc_cancel\"]", function (e) {
        e.preventDefault();
        var lHref = $(this).attr('href');
        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text
        bootbox.confirm({
            message: lText,
            size:"small",
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


