<?php
ob_start();
// Create (connect to) SQLite database in file
$file_db = new PDO('sqlite:db.sqlite3');
// Set errormode to exceptions
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create new database in memory
$memory_db = new PDO('sqlite::memory:');
// Set errormode to exceptions
$memory_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Select all data from file db messages table 
//$result = $file_db->query('SELECT * FROM settings');

if (!empty($_POST)) {

    foreach ($_POST as $field_name => $val) {
        //clean post values
        $field_id = strip_tags(trim($field_name));
        $val = strip_tags(trim($val));
        //from the fieldname:user_id we need to get user_id
        $split_data = explode(':', $field_id);
        $user_id = $split_data[1];
        $field_name = $split_data[0];

        if (!empty($user_id) && !empty($field_name) && !empty($val)) {
            //update the values
            // $task = array($field_name => $val);
            $new_title = $file_db->quote($val);
            $update = "UPDATE settings SET ip =  {$new_title} WHERE id =  $user_id ";
            // Execute update
            $file_db->exec($update);
            echo "Updated";
        } else {
            echo "Invalid Requests";
        }
    }
} else {
    echo "Invalid Requests";
}
?>