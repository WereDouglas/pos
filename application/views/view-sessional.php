<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>css/mine.css" />
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 12px;
        background-color:#FFFFFF;
    }   

</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">          
            <section>
                <div class="row">
                    <?php if (strpos($this->session->userdata('permission'), 'admin') == true) { ?>
                        <div class="col-md-3" style="margin-top:3px;">
                            <label>Company</label>
                            <div class=" form-group">
                                <input class="easyui-combobox form-control" name="companyID" id="companyID"  data-options="
                                       url:'<?php echo base_url() ?>index.php/company/lists',
                                       method:'get',
                                       valueField:'id',
                                       textField:'name',
                                       multiple:false,
                                       panelHeight:'auto'
                                       ">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-2" style="margin-top:3px;">
                        
                         <div class=" form-group">
                            <label >From:</label> 
                            <input class="easyui-datebox form-control" name="from" id="from" value="<?php echo date('d-m-Y'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top:3px;"><div class=" form-group">
                            <label >To:</label> 
                            <input class="easyui-datebox form-control" name="to" id="to" value="<?php echo date('d-m-Y'); ?>"/>
                        </div></div>
                    <div class="col-md-5" style="margin-top:30px;">                     
                        
                        <button type="button" class="btn btn-info btn-small" id="generate" >generate</button>
                        <input type="button" name="exportExcel" id="exportExcel" onclick="ExportToExcel('dynamic-table')" value="Export to Excel">
                        <input type="button" class="btn btn-default  printdiv-btn btn-primary icon-ok" value="print" />

                    </div>
                </div>


            </section>

            <h3 class="content-header"><font class="blue">Sessions reports</font></h3>
            <div class="table-responsive scroll">
                <span id="loading_card" name ="loading_card"><img src="<?= base_url(); ?>images/loading.gif" alt="loading............" /></span>


            </div><!--/table-responsive-->
        </div><!--/block-web--> 
    </div><!--/col-md-12--> 
</div><!--/row-->           
</div><!--/page-content end--> 

<!-- /sidebar chats -->  
<?php require_once(APPPATH . 'views/inner-js.php'); ?>
<script src="<?= base_url(); ?>js/table2excel.js"></script>

<script type="text/javascript">
                            function ExportToExcel(datatable) {
                                var month = $("#month").val();
                                var year = $("#year").val();
                                var date = $("#date").val();
                                var companyID = $("input[name=companyID]").val();

                                var htmltable = document.getElementById('dynamic-table');
                                var html = htmltable.outerHTML;
                                window.open('data:application/vnd.ms-excel,' + ';filename=' + month + ' ' + year + '.xlsx;' + encodeURIComponent(html));
                                var result = "data:application/vnd.ms-excel,";
                                this.href = result;
                                this.download = month + ".xls";
                                return true;
                            }


</script>


<script type="text/javascript">
    $(document).ready(function ()
    {


        $('#loading_card').hide();
        $("#generate").on("click", function (e) {

            $('#loading_card').show();
           
            var companyID = $("input[name=companyID]").val();
            var from = $("input[name=from]").val();
            var to = $("input[name=to]").val();

            if (from.length > 0) {

                $.post("<?php echo base_url() ?>index.php/sessions/periodic_report", {from: from, to: to, companyID: companyID}
                , function (response) {
                    //#emailInfo is a span which will show you message

                    $('#loading_card').hide();
                    setTimeout(finishAjax('loading_card', escape(response)), 200);

                }).fail(function (e) {
                    console.log(e);
                }); //end change
            } else {
                alert("Please insert missing information");

                $('#loading_card').hide();
            }

            function finishAjax(id, response) {
                $('#' + id).html(unescape(response));
                $('#' + id).fadeIn();
            }
        })




    });
    $(document).on('click', '.printdiv-btn', function (e) {
        e.preventDefault();

        printData();
    });
    function printData()
    {
        var divToPrint = document.getElementById("dynamic-table");
        newWin = window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }


</script>

