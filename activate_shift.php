<?php
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $start = date('Y-m-d H:i:s');
        $servername = "86.38.202.52";
        // $servername = "localhost";
        $username = "u774778522_sell_user_db";
        $password = "Ishimuko@123";
        $dbname = "u774778522_selleasep_db";


        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "u774778522_selleasep_db";

        // Insert the shift record into the database
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "INSERT INTO shift_records(user_id,start,shift_status) VALUES ( '$user_id','$start',1)";
        if ($conn->query($sql) === TRUE) {
            echo 1;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
   
} else {
    echo 'Invalid request method.';
}
?>

