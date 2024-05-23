<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all customer for debt
$sql = "SELECT 
        supplier_id  , 
        names,
        phone, 
        address,
        created_at
        FROM supplier  
        WHERE spt = $spt 
        GROUP BY supplier_id
        ORDER BY names ASC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['supplier_id'];
    $num+=1;


    $value .= '

        <option value = '.$row['supplier_id'].'>'.$row['names'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
