<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$dep_id = $_GET['dep_id'];


// Retrieve all users from the database
$sql = "SELECT `trainer_id`, `full_name`, `phone`, `address`, `qualification`, `dep_id`, `created_at`, `user_id`  FROM `trainers` WHERE `dep_id` = $dep_id
        ORDER BY `created_at` ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
   
   
    $num+=1;

     $value .= '

        <option value = '.$row['trainer_id'].'>'.$num.'. '.$row['full_name'].' With '.$row['qualification'].'</option>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
