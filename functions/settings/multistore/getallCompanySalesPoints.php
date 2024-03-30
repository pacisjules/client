<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT `sales_point_id`, `location`, `manager_name`, `phone_number`, `email`, `company_ID`, `created_at` FROM `salespoint` WHERE `company_ID` = $comID
        ORDER BY `created_at` ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['sales_point_id'];
   
    $num+=1;

     $value .= '

        <option value = '.$row['sales_point_id'].'>'.$num.'. '.$row['location'].' By '.$row['manager_name'].'</option>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
