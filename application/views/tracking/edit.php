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
            <a href="<?php echo base_url()?>/index.php/parking"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Back</button> </a>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-default">
        <div class="row">

            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update - Parking Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");
                    echo form_open("parking/save/$listing_info->id", $attributes);


                    ?>
                    <input type="hidden" id="rowid" name="rowid" value="<?php //echo $type_info->Property_type_id ?>">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Parking</label>

                            <div class="col-sm-9">
                                <?php echo $listing_info->name?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Description" name="description" id="description" value="<?php echo $listing_info->description; ?>">

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Status</label>

                            <div class="col-sm-2">

                                <input type="radio" name="status"  value="1" <?php echo ($listing_info->status =='1')?'checked':'' ?> checked> Active

                            </div>

                            <div class="col-sm-5">
                                <input type="radio" name="status" value="0" <?php echo ($listing_info->status=='0')?'checked':''?>> Inactive

                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                        <input type="submit" name="submit" class="btn btn-info pull-right" value="Submit">
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?>

                </div>
                <!-- /.box -->
                <!-- general form elements disabled -->

                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->

        </div>
    </section>
    <!-- /.content -->
</div>

<?php
$this->load->view("partial/footer");
?>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>








