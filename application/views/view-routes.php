<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>css/mine.css" />
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 13px;
        background-color:#FFFFFF;
    }   

</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                    <a href="javascript:void(0);" class="add_user" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square"></i> <span> New</span> </a>
                    <h3 class="content-header">Pay bus routes</h3>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <div class="alert alert-info" id="status"></div>
                <div class="porlets-content">


                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                     <th>Company</th>
                                    <th>Route Name</th>
                                    <th>Start point</th>
                                    <th>End point</th>
                                    <th class="hidden-phone">Cost</th>
                                     <th class="hidden-phone">Start time</th>
                                    <th class="hidden-phone">End time</th>
                                    <th class="hidden-phone">Distance</th>
                                    <th class="hidden-phone">Created</th>
                                    <th class="hidden-phone">Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($clients) && count($clients)) {
                                    foreach ($clients as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            
                                            <td id="name:<?php echo $loop->id; ?>" contenteditable="false">
                                                <?php echo $loop->id; ?>
                                            </td>
                                            <td >
                                                <?php echo $loop->company; ?>
                                            </td>
                                            <td id="name:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->name; ?>
                                            </td>

                                            <td id="startp:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->startp; ?></td>
                                            <td id="endp:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->endp; ?>
                                            </td>
                                            <td id="cost:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->cost; ?></td>
                                              <td id="start_time:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->start_time; ?></td>
                                            <td id="end_time:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->end_time; ?></td>
                                            <td id="distance:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->distance; ?></td>
                                            <td id="created:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->created; ?></td>

                                            <td class="edit_td">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/route/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

                                            </td> 

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>

                        </table>
                    </div><!--/table-responsive-->
                </div><!--/porlets-content-->


            </div><!--/block-web--> 
        </div><!--/col-md-12--> 
    </div><!--/row-->           
</div><!--/page-content end--> 
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Route</h4>
            </div>
            <div class="modal-body">             
                <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/route/create'  method="post">

                    <div class="form-group">
                            <input type="text" name="name" placeholder="Name" id="name" required class="form-control"/>
                   
                    </div>                  


                    <div class="form-group">
                            <input type="text" name="startp" placeholder="Starting point"  class="form-control"/>
                      
                    </div>

                    <div class="form-group">
                            <input type="text" name="endp" placeholder="Ending point" id="email"  class="form-control"/>
                   
                    </div>
                    <div class="form-group">
                            <input type="text" name="cost" placeholder="Route cost" id="cost"  class="form-control"/>
                   
                    </div>
                   
                    <div class="form-group">

                            <input type="text" name="starttime" placeholder="Route start time" id="starttime"  class="form-control"/>
                      
                    </div>
                    <div class="form-group">

                            <input type="text" name="endtime" placeholder="Route end time" id="endtime"  class="form-control"/>
                     
                    </div>
                    <div class="form-group">
                       
                            <input type="text" name="distance" placeholder="Distance" id="propertyname"  class="form-control"/>
                       
                    </div>


                    <div class="form-group">
                        
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                                <button class="btn btn-default pull-right" type="submit">SUBMIT</button>
                           
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<!-- sidebar chats -->


<!-- /sidebar chats -->  
<?php require_once(APPPATH . 'views/inner-js.php'); ?>
<script>
    $(document).ready(function () {
        $("#status").hide();
        $(function () {
            //acknowledgement message
            var message_status = $("#status");
            $("td[contenteditable=true]").blur(function () {
                var field_id = $(this).attr("id");
                var value = $(this).text();
                $.post('<?php echo base_url() . "index.php/route/update/"; ?>', field_id + "=" + value, function (data) {
                    if (data != '')
                    {
                        message_status.show();
                        message_status.text(data);
                        //hide the message
                        setTimeout(function () {
                            message_status.hide()
                        }, 4000);
                    }
                });
            });

        });
    });

</script>
