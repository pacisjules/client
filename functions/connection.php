<?php

//Server Connection
//$servername = "86.38.202.52";


// $servername = "localhost";
// $username = "u774778522_sell_user_db";
// $password = "Ishimuko@123";
// $dbname = "u774778522_selleasep_db";


//localhost Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>