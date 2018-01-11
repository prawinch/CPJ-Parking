<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>

       Language Settings

    </h1>

    <div class="col-sm-2 pull-right but">
        <!--<a href="<?php echo base_url()?>/index.php/registration"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Admin Details</button> </a>!-->
    </div>

</section>

<!-- Main content -->
<section class="content">

    <?php if($this->session->flashdata('msg')){?>

        <div class="alert alert-success" style="width: 30%">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check"></i><?php echo $this->session->flashdata('msg')?>
        </div>

    <?php } ?>
<div class="row">

<div class="col-md-8">
    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add / Edit  Details</h3>

        </div>

        <?php $attributes = array("class" => "form-horizontal", "autocomplete" => "off","id" => "form");
        echo form_open("label/label_add/", $attributes);


?>


        <?php
        $i=1;
        if($i=='1')
        {

       ?>
            <div class="box-body">


                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Name</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Name')?>"  name="name_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Name')?>"  name="name_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Email</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Email')?>"  name="email_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Email')?>"  name="email_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Mobile</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Mobile')?>"  name="mobile_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Mobile')?>"  name="mobile_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Address</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Address')?>"  name="address_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Address')?>"  name="address_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">City</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('City')?>"  name="city_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('City')?>"  name="city_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Gender</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Gender')?>"  name="gender_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Gender')?>"  name="gender_arabic">
                    </div>
                </div>

            </div>


            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Add Property</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Add Property')?>"  name="add_property_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Add Property')?>" name="add_property_arabic">
                    </div>
                </div>

            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Listing Type</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Listing Type')?>"  name="listing_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Listing Type')?>"  name="listing_arabic">
                    </div>
                </div>

            </div>


            <div class="box-body">

                <div class="row">
                    <div class="col-xs-3">
                        <label for="inputEmail3" class="control-label">Property Type</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get('Property Type')?>"  name="property_english">
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control"  value="<?php echo $this->Labelinfo->get_arab('Property Type')?>"  name="property_arabic">
                    </div>
                </div>

            </div>


        <?php
        }
        else
        {


        ?>




<?php
        }
      ?>
        <ul class="pagination pull-right">
            <li><a href="">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
        </ul>
                <div class="box-footer">

                    <input type="submit" name="submit" class="btn btn-info pull-left" value="Submit">
                </div>


            </div>

        <?php echo form_close(); ?>



    </div>
    <!-- /.box -->
    <!-- general form elements disabled -->

    <!-- /.box -->

<!--/.col (right) -->
</div>








<!-- /.row -->
</section>
<!-- /.content -->
</div>





<?php
$this->load->view("partial/footer");
?>

<!--<script>
    $('#pagination-demo').twbsPagination({
        totalPages: 5,
// the current page that show on start
        startPage: 1,

// maximum visible pages
        visiblePages: 3,

        initiateStartPageClick: true,

// template for pagination links
        href: false,

// variable name in href template for page number
        hrefVariable: '{{number}}',

// Text labels

       // prev: 'Previous',
       // next: 'Next',

// carousel-style pagination
        loop: false,

// callback function
        onPageClick: function (event, page) {
            $('.page-active').removeClass('page-active');
            $('#page'+page).addClass('page-active');
        },

// pagination Classes
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
         pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled'

    });

</script>
!-->
<!--<style>
.container {
margin-top: 20px;
}
.page {
display: none;
}
.page-active {
display: block;
}

</style> !-->




