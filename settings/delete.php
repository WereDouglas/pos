<?php
ob_start();
try {
// Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET['id'] ;
    if (!empty($_GET['id'])) {
        //$delete = 'DELETE FROM settings WHERE id = '.$id;
        // Execute update
       // $file_db->exec($delete);
         $file_db->query('DELETE FROM settings WHERE id = '.$id);
        echo "deleted";
        header("Location: view-list.php");
        die();
    } else {
        echo "Invalid Requests";
    }
} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}
?>