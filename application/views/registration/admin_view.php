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
        <?php echo $this->lang->line('user_details'); ?>
    </h1>
    <div class="col-sm-2 pull-right but">
        <a href="<?php echo site_url()?>/registration/add"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('add_user'); ?></button> </a>
    </div>

</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <?php if($this->session->flashdata('delete_message')){?>

                <div class="alert alert-success" >
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('delete_message')?>
                </div>

            <?php } ?>

          <?php if($this->session->flashdata('msg')){?>

                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('msg')?>
                    </div>

            <?php } ?>


            <?php if($this->session->flashdata('delete')){?>

                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('delete')?>
                </div>

            <?php } ?>

            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped list">
                    <thead>
                    <tr>
                        <?php

                        $visible=array('','hidden-xs','hidden-xs','hidden-xs','hidden-xs','hidden-xs','','','');
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

                            $bg_color=array('label-warning','label-primary','label-danger','label-grey');
                            foreach ($h->result() as $row)
                            {
                                if($row->id==1)continue;

                                $parking_info = $CI->Allocationinfo->get_user_alloc($row->id);
                               // print_r($parking_info);
                                $name=ucfirst($row->firstname). " ".ucfirst($row->lastname);

                                ?><tr>
                                <td><?php echo $i;?></td>
                                <td class="hidden-xs"><?php echo ucfirst($row->firstname);?></td>
                                <td class="hidden-xs"><?php echo ucfirst($row->lastname);?></td>
                                <td class="hidden-xs"><?php echo $row->mobile;?></td>
                                <td class="hidden-xs"><?php echo $row->email;?></td>
                                <td class="hidden-xs"><?php echo $row->address;?></td>
                                <td><?php echo $row->apartment_no;?></td>
                                <td class="col-md-2">
                                    <?php
                                    foreach($parking_info as $key=>$val)
                                    {

                                        echo '<span class="label '.$bg_color[$val['status']].'">'.$val['parking_name'].'</span>&nbsp;';


                                      //  echo '<span class="label label-primary">'.$val['parking_name'].'</span> &nbsp;';
                                        }
                                        ?>

                                        </td>
                                <td>
                                    <a class="green get_rowid"  href="<?php echo site_url('registration/edit/'.$row->id.'')?>">
                                        <i class="ace-icon fa fa-pencil" title="<?php echo $this->lang->line('edit'); ?>"></i>
                                    </a>
                                    <a id="Delete" data-toggle="confirm" data-title="<?php echo $name; ?>" href="<?php echo site_url('registration/delete_data/'. $row->id.''); ?>">
                                        <i class="ace-icon fa fa-trash-o" title="<?php echo $this->lang->line('delete'); ?>"></i>
                                    </a>
                                </td>
                                </tr>
                            <?php $i++; }
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

<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>-->


<script>

 /*   $(document).ready(function() {
        $('#example1').DataTable( {
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "Nothing found - sorry",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        } );
    } ); */



    $(document).on("click", "[data-toggle=\"confirm\"]", function (e) {
        e.preventDefault();
        var lHref = $(this).attr('href');
        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text

        bootbox.confirm({
            message: "Are you sure want to delete " +lText+" ?",
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


