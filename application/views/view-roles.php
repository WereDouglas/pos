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
                    <h3 class="content-header">USER ROLES</h3>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <div class="alert alert-info" id="status"></div>
                <div class="porlets-content">


                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                    <th>Views</th>
                                    <th>Tier</th>
                                    <th class="hidden-phone"></th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($roles) && count($roles)) {
                                    $editable = "true";
                                    if ($this->session->userdata('companyID') != "") {
                                        $editable = "false";
                                    }
                                    foreach ($roles as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td >
                                                <?php echo $loop->id; ?>
                                            </td>
                                            <td id="name:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->name; ?>
                                            </td>
                                            <td id="actions:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->actions; ?>
                                            </td>
                                            <td id="views:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->views; ?>
                                            </td>
                                            <td id="tier:<?php echo $loop->id; ?>" contenteditable="<?php echo $editable; ?>">
                                                <?php echo $loop->tier; ?>
                                            </td>
                                            <td class="edit_td">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/role/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

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
                <h4 class="modal-title" id="myModalLabel">Add Role</h4>
            </div>
            <div class="modal-body">             
                <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/role/create'  method="post">

                    <div class="form-group">
                        <label>Permission/role</label>
                        <input type="text" name="name" placeholder="Name" id="name" required class="form-control"/>

                    </div>
                    <div class="form-group">
                        <label>User actions</label>
                        <textarea name="actions"  class="form-control"></textarea>

                    </div>
                    <div class="form-group">
                        <label>User views</label>
                        <textarea name="views"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">

                        <div class="checkbox checkbox_margin">
                            <button class="btn btn-default pull-right" type="submit">SUBMIT</button> <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                        </div>

                    </div>

                </form>

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
                $.post('<?php echo base_url() . "index.php/role/update/"; ?>', field_id + "=" + value, function (data) {
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
