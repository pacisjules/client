<?php
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $start = date('Y-m-d H:i:s');
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "u774778522_selleasep_db";

        // Insert the shift record into the database
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "INSERT INTO shift_records(user_id,start) VALUES ( '$user_id','$start')";
        if ($conn->query($sql) === TRUE) {
            echo 1;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
   
} else {
    echo 'Invalid request method.';
}
?>

