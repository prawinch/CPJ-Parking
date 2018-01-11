<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $this->lang->line('parking'); ?>
        </h1>
        <div class="col-sm-1 pull-right but">
            <a href="<?php echo base_url()?>index.php/parking"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('back'); ?></button> </a>
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
                        <h3 class="box-title"><?php echo $this->lang->line('update'). ' '.$this->lang->line('parking'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");
                    echo form_open("parking/save/$listing_info->id", $attributes);


                    ?>
                    <input type="hidden" id="rowid" name="rowid" value="<?php //echo $type_info->Property_type_id ?>">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('parking_name'); ?></label>

                            <div class="col-sm-9">
                                <?php echo $listing_info->name?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('parking_type');?></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type" id="type">
                                    <?php
                                    $CI =& get_instance();
                                    $select='<option value="">'.$this->lang->line('select_parking').'</option>';
                                    foreach($parking_type as $key=>$val){
                                        if($key==false)continue;

                                        $selected=($listing_info->type==$key)?"selected=selected":"";

                                        $select.='<option value='.$key.' '.$selected.'>'.$val.'</option>';
                                    }
                                    echo $select;
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('parking_group'); ?></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="parking_group" id="parking_group">
                                    <?php
                                    $select='<option value="">'.$this->lang->line('select_parking_group').'</option>';
                                    foreach($parking_group as $key=>$val){

                                        $selected=($listing_info->parking_group==$val['id'])?"selected=selected":"";

                                        $select.='<option value='.$val['id'].' '.$selected.'>'.$val['name'].'</option>';
                                    }
                                    echo $select;
                                    ?>
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('amount_annual'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('parking_amount'); ?>" name="amount" id="amount" value="<?php echo $listing_info->amount?>">

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('status'); ?></label>

                            <div class="col-sm-2">

                                <input type="radio" name="status"  value="1" <?php echo ($listing_info->status =='1')?'checked':'' ?> checked> <?php echo $this->lang->line('active'); ?>

                            </div>

                            <div class="col-sm-5">
                                <input type="radio" name="status" value="0" <?php echo ($listing_info->status=='0')?'checked':''?>> <?php echo $this->lang->line('inactive'); ?>

                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                        <input type="submit" name="submit" class="btn btn-primary pull-right" value="<?php echo $this->lang->line('update'); ?>">
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

<script src="<?php echo base_url(); ?>tracker/js/jquery.validate.min.js"></script>

<script>
    (function($,W,D)
    {
        var JQUERY4U = {};
        JQUERY4U.UTIL =
        {
            setupFormValidation: function()
            {

                $("#form").validate({
                    rules: {
                        amount:{
                            required:true,
                            number:true,
                            maxlength:5
                        },
                        type:{
                            required:true
                        },
                        parking_group:{
                            required:true
                        },

                        name:
                        {
                            required:true,
                            remote: {
                                url: "<?php echo site_url()?>/parking/register_parking_exists",
                                type: "post",
                                data:
                                {
                                    name: function(){ return $("#name").val(); }

                                }
                            }
                        }
                    },

                    messages: {
                        name: {
                            remote: '<?php echo $this->lang->line('parking_already_added'); ?>'
                        },
                        type:{
                            required:'<?php echo $this->lang->line('required'); ?>'
                        },
                        parking_group:{
                            required:'<?php echo $this->lang->line('required'); ?>'
                        },
                        amount: {
                            required: '<?php echo $this->lang->line('enter_parking_amount'); ?>',
                            number:'<?php echo $this->lang->line('enter_valid_amount'); ?>',
                            maxlength:'<?php echo $this->lang->line('enter_valid_amount'); ?>'
                        }
                    },

                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            }
        }

        //when the dom has loaded setup form validation rules
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

    })(jQuery, window, document);

</script>

















