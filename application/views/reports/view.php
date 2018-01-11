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
        <?php echo $this->lang->line('reports'); ?>
    </h1>

    <div class="col-sm-2 pull-right but">
        <a href="<?php echo site_url()?>/reports/generate/"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('generate_month_report'); ?></button> </a>
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
                       foreach($headers as $key=>$val)
                       {
                           $class=($key==0)?"first-child":"";
                              echo '<th class="'.$class.'">'.$val.'</th>';
                       }
                        ?>
                      </tr>
                    </thead>
                        <tbody>
                    <?php
                    $i=1;
                    $CI =& get_instance();
                    $bg_color=array('label-warning','label-success','label-danger','label-grey');
                    foreach ($list as $key=>$val)
                    {
                        echo '<tr><td>'.$i.'</td>
                        <td>'.$val['create_date'].'</td>
                        <td>'.date('F Y',strtotime($val['from_date'])).'</td>';
                         $year=date('Y/m/d',strtotime($val['create_date']));
                        ?>
                        <td>
                            <a class="green get_rowid"  href="<?php echo site_url('reports/reports_pdf/'.$year.'')?>">
                                <i class="red ace-icon fa  fa-file-pdf-o text-red" title="View Reports"></i>
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
            message: "Are you sure want to delete this record ?",
            size:"small",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> No',
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


