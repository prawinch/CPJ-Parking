<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Super Admin
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Superadmin</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
    <div class="col-xs-12">

        <?php if($this->session->flashdata('message')){?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4> <?php echo $this->session->flashdata('message')?>
        </div>

        <?php } ?>

    <div class="box">
    <div class="box-header">
        <h3 class="box-title">List of View</h3>

        <a href="<?php echo site_url('superadmin/add'); ?>" class="btn btn-info pull-right">Add</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
        <?php foreach ($headers as $header) { ?>
            <th><?php echo $header; ?></th>
        <?php } ?>
    </tr>
    </thead>

        <tbody>
        <?php


        $i=1;

        foreach($reg as $key=>$row)
        {

            ?>
            <tr>
                <td>

                    <?php

                    echo '<a href="#" class="flw_detail" data-toggle="modal" data-target="#fModal" data-id="'.$row['id'].'">'.$i.'</a>';
                    ;
                    ?>
                </td>
  <td>
                    <?php echo $row['school']; ?>
                </td>

                <?php echo '<td>'.$row['username'].'</td>'; ?>


                <td>
                    <?php echo base64_decode(base64_decode($row['password'])); ?>
                </td>

                <td>
                    <?php echo date('d-m-Y',strtotime($row['from_date'])); ?>
                </td>

                <td>
                    <?php echo date('d-m-Y',strtotime($row['to_date'])); ?>
                </td>

                <td>
                    <?php echo $plan[$row['plan']]; ?>
                </td>

                <td>
                    <?php echo $row['status']?'Active':'In Active '; ?>
                </td>


                <td class="td-actions">
                    <div class="hidden-phone visible-desktop action-buttons">
                        <a class="green get_rowid"  href="<?php echo site_url(); ?>/superadmin/add/<?php echo $row['id']; ?>" >
                            <i class="ace-icon fa fa-edit bigger-120"></i>
                        </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                       <!-- <a class="green get_rowid"  href="<?php echo site_url(); ?>/profile/delete/<?php echo $row['id']; ?>" >
                            <i class="ace-icon fa fa-trash bigger-120"></i>
                        </a>-->

                    </div>
                </td>

            </tr>

        <?php $i++; }?>

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
    </section>
    <!-- /.content -->

</div>


<?php
$this->load->view("partial/footer");
?>



<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
</body>
</html>
