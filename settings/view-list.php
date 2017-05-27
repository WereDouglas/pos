<?php
// Set default timezone
ob_start();
?>
<link href="../css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/animate.css" rel="stylesheet" type="text/css" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<link href="../plugins/data-tables/DT_bootstrap.css" rel="stylesheet">
<link href="../plugins/advanced-datatable/css/demo_table.css" rel="stylesheet">
<link href="../plugins/advanced-datatable/css/demo_page.css" rel="stylesheet">
<link href="../css/mine.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/easyui.css?date=<?php echo date('Y-m-d') ?>">
<link rel="stylesheet" type="text/css" href="../css/icon.css?date=<?php echo date('Y-m-d') ?>">
<link href="../css/mine.css" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 13px;
        background-color:#FFFFFF;
    }   

</style>
<div class="registration">

    <a class="" href="index.php">
        Back
    </a>
    <div class="alert alert-info" id="status"></div>
    <table  class="display table table-bordered table-striped" id="dynamic-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>IP</th> 
                <th>ACTION</th>   
            </tr>
        </thead>
        <tbody>


            <?php
            // Create (connect to) SQLite database in file
            $file_db = new PDO('sqlite:db.sqlite3');
            // Set errormode to exceptions
            $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create new database in memory
            $memory_db = new PDO('sqlite::memory:');
            // Set errormode to exceptions
            $memory_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Select all data from file db messages table 
            $result = $file_db->query('SELECT * FROM settings');

            // Select all data from memory db messages table 
            // $result = $memory_db->query('SELECT * FROM settings');
            foreach ($result as $row) {
                ?>  
                <tr class="odd">
                    <td ><?php echo $row['id']; ?></td>
                    <td ><?php echo $row['name']; ?></td>
                    <td id="ip:<?php echo $row['id']; ?>" contenteditable="true">
                        <?php echo $row['ip']; ?>

                    </td>
                    <td >   <a class="btn btn-primary btn-xs" href=" <?php echo 'delete.php?id='.$row['id']; ?>"><li class="fa fa-folder">delete</li></a></td>
                </tr>
                <?php
            }
            ?>

        </tbody>

    </table>
</div>
<script src="../js/jquery.js"></script>
<script>
    $(document).ready(function () {
        $("#status").hide();
        $(function () {
            //acknowledgement message
            var message_status = $("#status");
            $("td[contenteditable=true]").blur(function () {
                var field_id = $(this).attr("id");
                var value = $(this).text();
                $.post('<?php echo "update.php"; ?>', field_id + "=" + value, function (data) {
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