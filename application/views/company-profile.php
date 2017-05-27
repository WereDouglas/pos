
<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/easyui.css?date=<?php echo date('Y-m-d') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/icon.css?date=<?php echo date('Y-m-d') ?>">
<link rel="stylesheet" href="<?= base_url(); ?>css/mine.css" />
<style type="text/css" media="screen">

    table{
        border-collapse:collapse;
        border:0px solid #FF0000;
        background-color: #FFF;
    }

    table td{
        border:0px solid #FF0000;
    }

    table tr{
        border:0px solid #FF0000;
    }
    td {
        border-top: 0px;
    }

</style>

<div class="porlets-content padding-10">
    <div class="row container">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="col-md-12 col-sm-12 col-xs-12"> <span class="info-box status col-md-12 col-sm-12 col-xs-12" id="status"></span></div>

            </div>
            <div  class="col-md-12" >


                <?php
                if (is_array($users) && count($users)) {
                    foreach ($users as $loop) {
                        ?>

                        <table class="table zebra-style ">

                            <tbody>
                                <tr>

                                    <td>
                                        <div class="profile_img">
                                            <?php
                                            if ($loop->image != "") {
                                                ?>
                                                <img height="20px" width="50px" class="img-responsive avatar-view" src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>" alt="Avatar" title="Change the avatar">

                                                <?php
                                            } else {
                                                ?>

                                                <img height="20px" width="50px" class="img-responsive avatar-view" src="<?= base_url(); ?>images/temp.png" alt="image" title="Change the avatar">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td></td>


                                </tr>
                                <tr>
                                    <td></td>
                                    <td><font class="red">(Editable)</font></td>

                                </tr>
                                <tr>
                                    <td>NAME:</td>
                                    <td id="name:<?php echo $loop->id; ?>" contenteditable="true" class="editable">
                                        <?php echo $loop->name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>LOCATION:</td>
                                    <td id="location:<?php echo $loop->id; ?>" class="editable" contenteditable="true"><?php echo $loop->location; ?></td>
                                </tr>

                          
                                <tr>
                                    <td>Change profile picture</td>
                                    <td>
                                        <form  enctype="multipart/form-data" class="form-horizontal form-label-left"  action='<?= base_url(); ?>index.php/company/update_image'  method="post">                                       
                                            <div class="form-group">
                                                <input type="file" class="form-control" name="userfile" id="userfile" />
                                            </div>
                                            <div class="form-group">

                                                <div id="imagePreview"class=" img-rounded" ></div>
                                            </div> 
                                            <div class="form-group"></div>

                                            <input type="hidden" name="userID" id="userID" value="<?php echo $loop->id; ?>" />                                                   
                                            <input type="hidden" name="namer" id="namer" value="<?php echo $loop->name; ?>" />
                                            <div class="form-group">
                                                <button id="send" class="btn btn-success" type="submit" >Update picture</button>
                                            </div>
                                        </form>

                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <?php
                    }
                }
                ?>

            </div> 
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?= base_url(); ?>js/validator.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.easyui.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#userfile").on("change", function ()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support
            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    $("#imagePreview").css("background-image", "url(" + this.result + ")");
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(function () {
            //acknowledgement message
            var message_status = $("#status");
            $("td[contenteditable=true]").blur(function () {
                var field_id = $(this).attr("id");
                var value = $(this).text();
                $.post('<?php echo base_url() . "index.php/company/update_profile/"; ?>', field_id + "=" + value, function (data) {
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
<script type="text/javascript">


    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
    }
    function myparser(s) {
        if (!s)
            return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }

</script>

<script>
    $(document).ready(function () {
        $('#identicalForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                confirmPassword: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });
    });
</script>








