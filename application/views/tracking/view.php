<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>

        Parking

    </h1>
    <div class="col-sm-1 pull-right but">
        <a href="<?php echo site_url()?>/parking/add/"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Add</button> </a>
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
                    <table id="example1" class="table table-bordered table-striped">

                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Parking</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                        <tbody>
                    <?php
                    $i=1;
                    foreach ($h->result() as $row)
                    {
                        echo '<tr><td>'.$i.'</td>
                        <td>'.$row->name.'</td>
                        <td>'.$row->description.'</td>';
                            if($row->status=='0')
                            {
                                echo '<td><small class="label bg-red">Inactive</small></td>';
                            }
                            else
                            {
                                echo '<td><small class="label bg-green">Active</small></td>';
                            }

                           ?>
                        </td>
                        <td>
                            <a class="green get_rowid"  href="<?php echo site_url('parking/edit/'.$row->id.'')?>">
                                <i class="ace-icon fa fa-pencil" title="Edit Here"></i>
                            </a>



                           <!-- <a id="Delete" data-toggle="confirm" data-title="Do you really want to delete this record ?" href="<?php echo site_url('listingtype/delete_data/'. $row->Listing_id.''); ?>">
                                <i class="ace-icon fa fa-trash-o" title="Delete"></i>
                            </a> !-->

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


