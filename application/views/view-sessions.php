<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>css/mine.css" />
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 8px;
        background-color:#FFFFFF;
    }   

</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="btn btn-grey col-md-1" id="excel" >Export</a></div>
                    <h3 class="content-header">Sessions</h3>
                </div>
                <div class="alert alert-info" id="status"></div>
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="porlets-content">


                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th>ID</th>
                                    <th>ROUTE</th>
                                    <th>COMPANY</th>                                    
                                    <th class="hidden-phone">SEATS</th>
                                    <th>STATUS</th>
                                    <th class="hidden-phone">COST</th>                                   
                                    <th class="hidden-phone">USER</th>                                    
                                    <th class="hidden-phone">Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($clients) && count($clients)) {
                                    foreach ($clients as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td>
                                                <?php echo $loop->id; ?>
                                            </td>
                                            <td>
                                                <?php echo $loop->created; ?>
                                            </td>
                                            <td id="sessionID:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->sessionID; ?>
                                            </td>
                                            <td id="route:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->route; ?>
                                            </td>
                                            
                                            <td>
                                                <?php echo $loop->company; ?>
                                            </td>
                                            <td id="max:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->max; ?>
                                            </td>
                                            <td id="status:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->status; ?>
                                            </td>
                                            <td ><?php echo number_format($loop->cost); ?></td>
                                            <td ><?php echo $loop->user; ?></td> 
                                         
                                            <td class="edit_td">
                                                 <a class="btn btn-success btn-xs" href="<?php echo base_url() . "index.php/sessions/payments/" . $loop->sessionID; ?>"><li class="fa fa-desktop-o">View</li></a>

                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/sessions/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

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

<!-- /sidebar chats -->  
<?php require_once(APPPATH . 'views/inner-js.php'); ?>
<script src="<?= base_url(); ?>js/table2excel.js"></script>
<script>
    $(document).ready(function () {
        $("#status").hide();
        $(function () {
            //acknowledgement message
            var message_status = $("#status");
            $("td[contenteditable=true]").blur(function () {
                var field_id = $(this).attr("id");
                var value = $(this).text();
                $.post('<?php echo base_url() . "index.php/payment/update/"; ?>', field_id + "=" + value, function (data) {
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
          var table = $('#dynamic-table').DataTable();
  
        $('#excel').on('click', function () {
            $('<table>').append(table.$('tr').clone()).table2excel({
                exclude: ".excludeThisClass",
                name: "Worksheet Name",
                filename: "SomeFile" //do not include extension
            });
        });
    });


</script>

