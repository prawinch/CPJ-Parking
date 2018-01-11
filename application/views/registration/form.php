<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        <?php echo $this->lang->line('user_details'); ?>
    </h1>
    <div class="col-sm-1 pull-right but">
        <a href="<?php echo base_url()?>index.php/registration"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('back'); ?></button> </a>
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
            <h3 class="box-title"><?php echo $this->lang->line('add'). " - ".$this->lang->line('user_details'); ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php $attributes = array("class" => "form-horizontal", "enctype"=>"multipart/form-data", "autocomplete" => "off","id" => "form");
        echo form_open("registration/admin_add/$admin_info->id", $attributes);


?>
<input type="hidden" id="rowid" name="rowid" value="<?php echo $admin_info->id ?>">

            <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('first_name'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('first_name'); ?>" name="firstname" id="firstname" value="<?php echo $admin_info->firstname?>">

                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('last_name'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('last_name'); ?>" name="lastname" id="lastname" value="<?php echo $admin_info->lastname?>">

                    </div>
                </div>


                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('apartment_no'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('apartment_no'); ?>" name="apartment_no" id="apartment_no" value="<?php echo $admin_info->apartment_no?>">

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('email'); ?></label>

                    <div class="col-sm-9">
                        <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" name="email" id="email" value="<?php echo $admin_info->email?>">

                    </div>
                </div>


                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('personal_number'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control pin" placeholder="<?php echo $this->lang->line('personal_number'); ?>" name="pin" id="pin" onkeydown="mask(event,this)" onkeyup="mask(event,this)" value="<?php echo $admin_info->pin?>" maxlength="13">
                        <label for="email" generated="true" class=""></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('post_no'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('post_no'); ?>" name="post_no" id="post_no" value="<?php echo $admin_info->post_no?>">

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('post_ort'); ?></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('post_ort'); ?>" name="post_ort" id="post_ort" value="<?php echo $admin_info->post_ort?>" >

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('mobile'); ?></label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" id="mobile" value="<?php echo $admin_info->mobile?>" maxlength="10">

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('address'); ?></label>

                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" name="address" placeholder="<?php echo $this->lang->line('address'); ?>"><?php echo $admin_info->address; ?></textarea>
                    </div>
                </div>


               <!-- <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Photo</label>

                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="userfile" id="userfile" value="">
                    </div>
                </div>-->

               <!-- <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">

                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">


                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Confirm Password</label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" placeholder="Confirm password" id="cpassword" name="cpassword">


                    </div>
                </div>-->

            </div>
            <!-- /.box-body -->
            <div class="box-footer">

                <input type="submit" name="submit" class="btn btn-primary pull-right" value="<?php echo $this->lang->line('submit'); ?>">
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


<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->

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
                        firstname:
                        {
                            required:true
                        },
                        lastname:
                        {
                            required:true
                        },
                        pin:
                        {
                            required:true,
                            minlength:11
                        },
                        post_no:
                        {
                            required:true,
                            number:true
                        },
                        post_ort:
                        {
                            required:true
                        },
                        email:
                        {
                            email:true,
                            required:true,
                            remote: {
                                url: "<?php echo site_url()?>/registration/register_email_exists",
                                type: "post",
                                data:
                                {
                                    email: function(){ return $("#email").val(); },
                                    id:function(){ return $('#rowid').val();
                                    }
                                }
                            }
                        },
                        mobile:
                        {
                            required:true,
                            number:true
                        },
                        apartment_no:
                        {
                            required:true,
                            remote: {
                                url: "<?php echo site_url()?>/registration/register_apartment_exists",
                                type: "post",
                                data:
                                {
                                    apartment_no: function(){ return $("#apartment_no").val(); }

                                }
                            }
                        }
                        /*  password:
                         {
                         required:true,
                         minlength: 6,
                         maxlength: 10
                         },
                         cpassword:
                         {
                         equalTo: "#password",
                         minlength: 6,
                         maxlength: 10
                         }*/
                    },
                    messages: {
                        email: {

                            remote: 'Email already Registered'
                        },
                        apartment_no: {

                            remote: 'Apartment No already Registered'
                        },
                        mobile:{
                            number:"Enter Valid Mobile Number"
                        },
                        post_no:{
                            number:"Enter Valid Post Number"
                        },
                        pin:
                        {
                            minlength:"Enter Valid Personal Number"
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

<script type="text/javascript">
    function mask(e,f){
        var str= f.value;
        var year=str.slice(0, 2);

        var len = f.value.length;
        var key = whichKey(e);
        if(year==19 || year==20)
        {
            if(key>47 && key<58 || key<106 && key>95)
            {
                if( len==8 )f.value=f.value+'-'
                else f.value=f.value;
            }
            else{
                f.value = f.value.replace(/[^0-9-]/,'')
                f.value = f.value.replace('--','-')
            }

        }else{
            if(key>47 && key<58 || key<106 && key>95)
            {
                if( len==6 )f.value=f.value+'-'
                else f.value=f.value;
            }
            else{
                f.value = f.value.replace(/[^0-9-]/,'')
                f.value = f.value.replace('--','-')
            }
            if(len>11)
            {
                var year=str.slice(0, 11);
                f.value=year;
            }
        }

    }

    function whichKey(e) {
        var code;
        if (!e) var e = window.event;
        if (e.keyCode) code = e.keyCode;
        else if (e.which) code = e.which;
        return code
//	return String.fromCharCode(code);
    }

</script>









