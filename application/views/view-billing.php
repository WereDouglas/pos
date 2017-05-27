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
                       <h3 class="content-header">Stock</h3>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <div class="alert alert-info" id="status"></div>
                <div class="porlets-content">
                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>                                   
                                    <th>Quantity</th>                                  
                                    <th>Batch. No</th>
                                    <th>Purchase price</th>
                                    <th>Sale price</th>
                                    <th>Previous price</th>
                                    <th>Total Value</th>
                                    <th>Date of expiry</th>
                                    <th>Category</th>
                                    <th>Barcode</th>
                                    <th class="hidden-phone">Created</th>
                                    <th class="hidden-phone">Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($items) && count($items)) {
                                    foreach ($items as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td id="id:<?php echo $loop->id; ?>" contenteditable="false">
                                                <?php echo $loop->id; ?>
                                            </td>
                                            <td> 
                                                <?php
                                                if ($loop->image != "") {
                                                    ?>
                                                    <img  height="50px" width="50px"  src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>"  />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img  height="50px" width="50px"  src="<?= base_url(); ?>images/user_place.png"  />
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td id="name:<?php echo $loop->id; ?>" contenteditable="false">
                                                <?php echo $loop->name; ?>
                                            </td>

                                            <td id="code:<?php echo $loop->id; ?>" contenteditable="false"><?php echo $loop->code; ?></td>

                                            <td id="qty:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->qty; ?></td>
                                              <td id="batch:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->batch; ?></td>
                                            <td id="purchase_price:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->purchase_price; ?></td>
                                            <td id="sale_price:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->sale_price; ?></td>
                                            <td id="previous_price:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->previous_price; ?></td>
                                            <td id="total_value:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->total_value; ?></td>

                                            <td id="expires<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->expires; ?></td>
                                            <td id="category:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->category; ?></td>
                                            <td id="barcode:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->barcode; ?></td>
                                            <td id="created:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->created; ?></td>

                                            <td class="edit_td">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/stock/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

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
                $.post('<?php echo base_url() . "index.php/stock/update/"; ?>', field_id + "=" + value, function (data) {
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
<script>
    $(document).ready(function () {
        $('#loading').hide();

        var payment = 0;

//        $('#contact').blur(function () {
//
//            //$("#tenantname").val($("input[name=tenant]").val());
//            // $("#dater").val($("input[name=date]").val());
//            payment = parseInt($("#sum").val());
//            $("#words").val(toWords(payment));
//            var routeID = $("input[name=routeID]").val();
//            var date = $("input[name=date]").val();
//            if (routeID !== null) {           // show loader 
//                $('#loading').show();
//                $.post("<?php echo base_url() ?>index.php/payment/details", {
//                    routeID: routeID, date: date
//                }, function (response) {
//                    //#emailInfo is a span which will show you message
//                    $('#loading').hide();
//                    setTimeout(finishAjax('loading', escape(response)), 400);
//                });
//            }
//
//            function finishAjax(id, response) {
//                $('#' + id).html(unescape(response));
//                $('#' + id).fadeIn();
//            }
//        });


    });

    $(document).on('click', '.printdiv-btn', function (e) {
        e.preventDefault();

        var $this = $(this);
        //  var originalContent = $('body').html();
        var printArea = $this.parents('.printableArea').html();

        $('body').html(printArea);
        window.print();
        $('body').html(printArea);
    });

    function SelectedRole(ele) {
        var payment = 0;

        payment = parseInt($("#sum").val());
        $("#words").val(toWords(payment));
        var categoryID = $("input[name=categoryID]").val();
        var date = $("input[name=date]").val();
        if (categoryID !== null) {           // show loader 
            $('#loading').show();
            $.post("<?php echo base_url() ?>index.php/category/details", {
                categoryID: categoryID, date: date
            }, function (response) {
                //#emailInfo is a span which will show you message
                $('#loading').hide();
                setTimeout(finishAjax('loading', escape(response)), 400);
            });
        }

        function finishAjax(id, response) {
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
        }
    }


</script>
<script>
    var th = ['', 'thousand', 'million', 'billion', 'trillion'];
    var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function toWords(s) {
        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s))
            return 'not a number';
        var x = s.indexOf('.');
        if (x == -1)
            x = s.length;
        if (x > 15)
            return 'too big';
        var n = s.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) { // 0235
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0)
                    str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk)
                    str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }

        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++)
                str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }
</script>

