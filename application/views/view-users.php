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
                    <h3 class="content-header">Manage users</h3>
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
                                    <th>Role/Designation</th>
                                    <th>Store</th>
                                    <th>email</th>
                                    <th>Contact</th>
                                    <th class="hidden-phone">Active</th>
                                    <th class="hidden-phone">Created</th>
                                    <th class="hidden-phone">Action</th>
                                    <th class="hidden-phone">Reset password</th>
                                    <th class="hidden-phone">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($users) && count($users)) {
                                    foreach ($users as $loop) {
                                        $id = $loop->id;
                                        $role = $loop->roles;
                                        ?>  
                                        <tr class="odd edit_tr" id="<?php echo $id; ?>">
                                           
                                           <td> 
                                                <?php
                                                if ($loop->image != "") {

                                                      echo '<img height="50px" width="50px" src="data:image/jpeg;base64,' . $loop->image . '" />';
                                                } else {
                                                    ?>
                                                    <img  height="50px" width="50px"  src="<?= base_url(); ?>images/user_place.png"  />
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td id="surname:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->surname; ?>
                                            </td>

                                            <td class="edit_td">
                                                <span id="role_<?php echo $id; ?>" class="text"><?php echo $role; ?></span>                                      
                                                <select  name="type" class="editbox" id="role_input_<?php echo $id; ?>" >
                                                    <option value="<?php echo $role; ?>" title="<?php echo $role; ?>"><?php echo $role; ?></option>

                                                    <?php
                                                    if (is_array($roles) && count($roles)) {
                                                        foreach ($roles as $loops) {
                                                            ?>                        
                                                            <option value="<?= $loops->id ?>" /><?= $loops->title ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>  
                                            <td ><?php echo $loop->store; ?></td>

                                            <td id="email:<?php echo $loop->id; ?>" contenteditable="true">
                                                <?php echo $loop->email; ?>
                                            </td>
                                            <td id="contact:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->contact; ?></td>
                                            <td id="active:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->active; ?></td>
                                            <td id="created:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->created; ?></td>
                                            <td >
                                                <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "index.php/user/profile/" . $loop->id; ?>"><li class="fa fa-folder">View</li></a>

                                            </td> 
                                            <td>
                                                <a href="#"  value="<?php echo $loop->id; ?>"  id="myLink" onclick="NavigateToSite(this)" class="tooltip-error text-danger" data-rel="tooltip" title="reset">
                                                    <span class="red">
                                                        <i class="icon-lock bigger-120 text-danger"></i>
                                                        Reset
                                                    </span>
                                                </a>
                                            </td>
                                            <td >
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/user/delete/" . $loop->id; ?>"><li class="fa fa-trash-o">Delete</li></a>

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
                <h4 class="modal-title" id="myModalLabel">ADD USER</h4>
            </div>

            <div class="modal-body">             
                <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/user/create'  method="post">
                    <div class="form-group">                    
                        <label >Profile picture</label>                        
                        <input type="file" name="userfile" id="userfile" class="btn-default btn-small form-control"/>
                        <div id="imagePreview" ></div>                      
                    </div>
                    <?php if ($this->session->userdata('role') == 'Administrator') { ?>
                        <div class="form-group">
                            <label>Select company</label>


                            <input class="easyui-combobox form-control" name="companyID" id="companyID" style="width:100%;height:26px" data-options="
                                   url:'<?php echo base_url() ?>index.php/company/lists',
                                   method:'get',
                                   valueField:'id',
                                   textField:'name',
                                   multiple:false,
                                   panelHeight:'auto'
                                   "   >

                        </div>
                    <?php } ?>
                    <div class="form-group">                     

                        <label>Select role</label>

                        <input class="easyui-combobox form-control" name="role" id="role" style="width:100%;height:26px" data-options="
                               url:'<?php echo base_url() ?>index.php/role/lists',
                               method:'get',
                               valueField:'id',
                               textField:'name',
                               multiple:false,
                               panelHeight:'auto',
                               onChange: function(rec){
                               SelectedRole('info');
                               }
                               ">
                        <span id="loading_card" name ="loading_card"><img src="<?= base_url(); ?>images/loading.gif" alt="loading............" /></span>
                    </div>
                    <div class="form-group">
                        <label>Select bus</label>
                        <input class="easyui-combobox form-control" name="bus" id="bus" style="width:100%;height:26px" data-options="
                               url:'<?php echo base_url() ?>index.php/bus/lists',
                               method:'get',
                               valueField:'regNo',
                               textField:'regNo',
                               multiple:false,
                               panelHeight:'auto'                               
                               ">
                    </div>
                        <div class="form-group">
                        <label>Select route</label>
                        <input class="easyui-combobox form-control" name="route" id="route" style="width:100%;height:26px" data-options="
                               url:'<?php echo base_url() ?>index.php/route/lists',
                               method:'get',
                               valueField:'id',
                               textField:'name',
                               multiple:false,
                               panelHeight:'auto'                               
                               ">
                    </div>
                    <div class="form-group">                       
                        <label >Active</label>
                        <select class="form-control" id="active" name="active"> 

                            <option value="true">true</option> 
                            <option value="false">false</option>                                  
                        </select>                       
                    </div><!--/form-group-->
                    <div class="form-group">                        
                        <input type="text" name="name" placeholder="Full Name" id="name" required class="form-control"/>

                    </div>
                    <div>
                        <div class="form-group">

                            <input type="text" name="contact" placeholder="Contact No."  class="form-control"/>

                        </div>

                        <div class="form-group">


                            <input type="text" name="email" placeholder="Email" id="email"  class="form-control"/>

                        </div>
                        <div class="form-group">
                            <label for="email">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" />                                                   

                        </div>
                        <div class="form-group">
                            <label for="pwd">Confirm password:</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" value="" />

                        </div>  



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>  <button class="btn btn-success pull-right" type="submit">SUBMIT</button> 

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- sidebar chats -->


<!-- /sidebar chats -->  
<?php require_once(APPPATH . 'views/inner-js.php'); ?>
<script src="<?= base_url(); ?>js/validator.js"></script>
<script>
                                            $(document).ready(function () {
                                                $('#loading_card').hide();
                                                $("#status").hide();
                                                $(function () {
                                                    //acknowledgement message
                                                    var message_status = $("#status");
                                                    $("td[contenteditable=true]").blur(function () {
                                                        var field_id = $(this).attr("id");
                                                        var value = $(this).text();
                                                        $.post('<?php echo base_url() . "index.php/user/update/"; ?>', field_id + "=" + value, function (data) {
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

    function NavigateToSite(ele) {
        var selectedVal = $(ele).attr("value");
        //var selectedVal = document.getElementById("myLink").getAttribute('value');
        //href= "index.php/patient/add_user/'
        $.post("<?php echo base_url() ?>index.php/user/reset", {
            userID: selectedVal
        }, function (response) {
            alert(response);
        });

    }
    function SelectedRole(ele) {


        $('#loading_card').show();


        var role = $("input[name=role]").val();

        if (role.length > 0) {

            $.post("<?php echo base_url() ?>index.php/role/details", {role: role}
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
    }


</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $(".editbox").hide();

        $(".edit_tr").click(function ()
        {
            var ID = $(this).attr('id');

            $("#role" + ID).hide();
            $("#role_input_" + ID).show();


        }).change(function ()
        {
            var ID = $(this).attr('id');
            var role = $("#role_input_" + ID).val();


            var dataString = 'id=' + ID + '&role=' + role;

            $("#role_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif" />'); // Loading image

            if (role.length > 0)
            {

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "index.php/user/updating/"; ?>",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {

                        $("#role_" + ID).html(role);


                    }
                });
            } else
            {
                alert('Enter something.');
            }
            location.reload();
        });

        // Edit input box click action
        $(".editbox").mouseup(function ()
        {
            return false
        });

        // Outside click action
        $(document).mouseup(function ()
        {
            $(".editbox").hide();
            $(".text").show();
        });

    });
</script>
