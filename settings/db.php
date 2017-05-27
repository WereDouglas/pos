<?php
ob_start();
// Set default timezone
date_default_timezone_set('UTC');
// error_reporting(E_PARSE);

try {
    /*     * ************************************
     * Create databases and                *
     * open connections                    *
     * ************************************ */
    if ($_POST["name"] || $_POST["ip"]) {

        // echo "Server name:" . $_POST['name'] . "<br />";
        //echo "Server ip:" . $_POST['ip'] . "";
        $name = $_POST['name'];
        $ip = $_POST['ip'];


        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:db.sqlite3');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create new database in memory
        $memory_db = new PDO('sqlite::memory:');
        // Set errormode to exceptions
        $memory_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        /*         * ************************************
         * Create tables                       *
         * ************************************ */

        // Create table messages
        $file_db->exec("CREATE TABLE IF NOT EXISTS settings (
                    id INTEGER PRIMARY KEY, 
                    name TEXT, 
                    ip TEXT)");

        // Create table messages with different time format
        $memory_db->exec("CREATE TABLE settings (
                      id INTEGER PRIMARY KEY, 
                      name TEXT, 
                      ip TEXT)");


        /*         * ************************************
         * Set initial data                    *
         * ************************************ */


        /*         * ************************************
         * Play with databases and tables      *
         * ************************************ */

        // Prepare INSERT statement to SQLite3 file db
        $insert = "INSERT INTO settings (name, ip) 
                VALUES (:name, :ip)";
        $stmt = $file_db->prepare($insert);

        // Bind parameters to statement variables
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ip', $ip);
        // $stmt->bindParam(':time', $time);
        // Loop thru all messages and execute prepared insert statement

        $name = $name;
        $ip = $ip;
        // $time = $m['time'];
        // Execute statement
        $stmt->execute();


        // Prepare INSERT statement to SQLite3 memory db
        $insert = "INSERT INTO settings (id, name, ip) 
                VALUES (:id, :name, :ip)";
        $stmt = $memory_db->prepare($insert);
    }else{
         header("Location: index.php");
    }
    

    // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM settings');

    // Loop thru all data from messages table 
    // and insert it to file db
    foreach ($result as $m) {
        // Bind values directly to statement variables
        $stmt->bindValue(':id', $m['id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $m['name'], PDO::PARAM_STR);
        $stmt->bindValue(':ip', $m['ip'], PDO::PARAM_STR);

        // Execute statement
        $stmt->execute();
    }

    // Quote new title
    $new_title = $memory_db->quote("Hi''\'''\\\"\"!'\"");
    // Update old title to new title
    /** $update = "UPDATE messages SET title = {$new_title} 
      WHERE datetime(time) >
      datetime('2012-06-01 15:48:07')";
      // Execute update
      $memory_db->exec($update);* */
    // Select all data from memory db messages table 
    $result = $memory_db->query('SELECT * FROM settings');

    foreach ($result as $row) {
        echo "Id: " . $row['id'] . "\n";
        echo "name: " . $row['name'] . "\n";
        echo "ip: " . $row['ip'] . "\n";

        echo "\n";
    }


    /*     * ************************************
     * Drop tables                         *
     * ************************************ */

    // Drop table messages from file db
    // $file_db->exec("DROP TABLE messages");
    // Drop table messages from memory db
    // $memory_db->exec("DROP TABLE messages");


    /*     * ************************************
     * Close db connections                *
     * ************************************ */

    // Close file db connection
    $file_db = null;
    // Close memory db connection
    $memory_db = null;
    header("Location: index.php");
    die();
} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}
?>