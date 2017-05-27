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
                    <h3 class="content-header">Payments</h3>
                </div>
                <div class="alert alert-info" id="status"></div>
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="porlets-content">
                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th>Contact</th>
                                    <th>Name</th>                                   
                                    <th class="hidden-phone">Bus</th>
                                    <th class="hidden-phone">Seat</th>
                                    <th>Date/Time of travel</th>
                                    <th class="hidden-phone">Cost</th> 
                                    <th class="hidden-phone">Luggage Cost</th> 
                                    <th class="hidden-phone">Route</th>
                                    <th class="hidden-phone">Bar code</th> 
                                    <th class="hidden-phone">user</th> 
                                    <th class="hidden-phone">Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sum = "0";
                                $lug = "0";
                                $count = 1;
                                if (is_array($clients) && count($clients)) {
                                    foreach ($clients as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td>
                                                <?php echo $count++; ?>
                                            </td>
                                            <td>
                                                <?php echo $loop->id; ?>
                                            </td>
                                            <td>
                                                <?php echo $loop->date; ?>
                                            </td>
                                            <td id="contact:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->contact; ?>
                                            </td>
                                            <td id="name:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->name; ?>
                                            </td>
                                            <td>
                                                <?php echo $loop->bus; ?>
                                            </td>
                                            <td id="seat:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->seat; ?>
                                            </td>
                                            <td id="date:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->date . ' ' . $loop->start; ?>
                                            </td>
                                            <td ><?php echo number_format($loop->cost); ?></td>
                                            <td ><?php echo number_format($loop->luggage); ?></td>
                                            <td ><?php echo $loop->route; ?></td> 
                                            <td ><?php echo $loop->barcode; ?></td> 
                                            <td ><?php echo $loop->user; ?></td> 
                                            <td class="edit_td">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/payment/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

                                            </td> 

                                        </tr>
                                        <?php
                                        $sum = $sum + $loop->cost;
                                        $lug = $lug + $loop->luggage;
                                       
                                    }
                                }
                                ?>
                                <tr class="even">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>TOTAL</td>
                                    <td ><?php echo number_format($sum); ?></td>
                                    <td ><?php echo number_format($lug); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table> 
                         <h3 class="content-header">Expenses</h3>
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                   
                                    <th>#</th>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th>PARTICULARS</th>
                                    <th>QUANTITY</th>                                   
                                    <th class="hidden-phone">UNIT COST</th>
                                   
                                    <th class="hidden-phone">COST</th> 
                                   
                                    <th class="hidden-phone">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                              
                              
                                <?php
                                $exps = "0";
                                $count = 1;
                               // var_dump($exp);
                                if (is_array($exp) && count($exp)) {
                                    foreach ($exp as $loops) {
                                        ?>  
                                        <tr class="odd">
                                            <td>
                                                <?php echo $count++; ?>
                                            </td>
                                            <td>
                                                <?php echo $loops->id; ?>
                                            </td>
                                            <td>
                                                <?php echo $loops->created; ?>
                                            </td>
                                            <td id="particular:<?php echo $loops->id; ?>" contenteditable="true">
                                                <?php echo $loops->particular; ?>
                                            </td>
                                            <td id="qty:<?php echo $loops->id; ?>" contenteditable="true">
                                                <?php echo $loops->qty; ?>
                                            </td>
                                            <td>
                                                <?php echo $loops->unit; ?>
                                            </td>
                                          
                                            <td ><?php echo number_format($loops->total); ?></td>
                                            
                                            <td class="edit_td">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/expense/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

                                            </td> 

                                        </tr>
                                        <?php
                                        $exps = $exps + $loops->total;
                                    }
                                }
                                ?>
                                <tr class="even">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  
                                    <td>TOTAL</td>
                                    <td ><?php echo number_format($exps); ?></td>
                                    <td ></td>
                                    
                                   
                                </tr>

                            </tbody>

                        </table>
                            <h5 class="content-header">PROFIT DECLARATION: <?php echo number_format(($sum + $lug) - $exp) ;?></h5>
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

