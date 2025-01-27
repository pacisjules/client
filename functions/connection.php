<?php

//Server Connection
// $servername = "193.203.166.224";


// $servername = "localhost";
// $username = "u774778522_sell_user_dbs";
// $password = "Ishimuko@123";
// $dbname = "u774778522_selleasep_dbs";


// localhost Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u774778522_selleasep_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>