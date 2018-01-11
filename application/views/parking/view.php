<?php
$this->load->view("partial/top_header");
$this->load->view("partial/sidebar_menu");
?>
<style>
    /*
    td:nth-child(4)
    {
        text-align: center !important;
    }
    td:nth-child(5)
    {
        text-align: center !important;
    }*/
    th,td{
        text-align: left !important;
    }
</style>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        <?php echo $this->lang->line('parking'); ?>
    </h1>
    <div class="col-sm-1 pull-right but">
        <a href="<?php echo site_url()?>/parking/add/"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" ><?php echo $this->lang->line('add'); ?></button> </a>
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
                            $visible=array('','','hidden-xs','','hidden-xs','hidden-xs','');
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
                    foreach ($h->result() as $row)
                    {
                        $name=$row->name;

                        $count = $CI->Allocationinfo->get_parking_alloc_count($row->id);
                        $group= $CI->Parkinginfo->get_parking_group($row->parking_group);

                        if($count)
                        {
                        $link=site_url('parking/delete/'. $row->id.'');
                            $title='Are you sure want to delete? '.$name;
                            $action='confirm';
                        }
                        else{
                        $link='';
                            $title='The Parking : '.$name. ' is Allocated ';
                            $action='cancel';
                        }

                        $link=site_url('parking/delete/'. $row->id.'');
                        $title=$this->lang->line('user_delete'). " ".$name;
                        $action='confirm';

                        echo '<tr><td>'.$i.'</td>
                        <td>'.$row->name.'</td>
                        <td class="'.$visible['2'].'">'.$group['name'].'</td>
                        <td>'.$parking_type[$row->type].'</td>
                        <td class="'.$visible['3'].'">'.$row->amount.'</td>';
                            if($row->status=='0')
                            {
                                echo '<td class="'.$visible['4'].'"><small class="label bg-red">'.$this->lang->line('inactive').'</small></td>';
                            }
                            else
                            {
                                echo '<td class="'.$visible['4'].'"><small class="label bg-green">'.$this->lang->line('active').'</small></td>';
                            }
                           ?>
                        </td>
                        <td>
                            <a class="green get_rowid"  href="<?php echo site_url('parking/edit/'.$row->id.'')?>">
                                <i class="ace-icon fa fa-pencil" title="<?php echo $this->lang->line('edit'); ?>"></i>
                            </a>


                            <a id="Delete" data-toggle="<?php echo $action; ?>" data-title="<?php echo $title; ?>" href="<?php echo $link; ?>">
                                <i class="ace-icon fa fa-trash-o" title="<?php echo $this->lang->line('delete'); ?>"></i>
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


    $(document).on("click", "[data-toggle=\"cancel\"]", function (e) {
        e.preventDefault();
        var lHref = $(this).attr('href');
        var lText = this.attributes.getNamedItem("data-title") ? this.attributes.getNamedItem("data-title").value : "Are you sure?"; // If data-title is not set use default text
        bootbox.confirm({
            message: lText,
            size:"small",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Ok',
                    className: 'btn-success'
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


