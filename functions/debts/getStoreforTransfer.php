<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company = $_GET['company_id'];

// Retrieve all customer for debt
$sql = "SELECT 
      `store_id`, `storename`, `storekeeper`, `phone`, `address`, `company_ID`, `created_at` FROM `store` WHERE `company_ID` = $company
ORDER BY `created_at` ASC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['store_id'];
    $num+=1;


    $value .= '

        <option value = '.$row['store_id'].'>'.$row['storename'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
