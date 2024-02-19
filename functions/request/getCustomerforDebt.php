<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all customer for debt
$sql = "SELECT 
        CUST.customer_id , 
        CUST.names,
        CUST.phone, 
        CUST.address,
        CUST.created_at
        FROM customer CUST 
        WHERE CUST.spt = $spt 
        GROUP BY CUST.customer_id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['customer_id'];
    $num+=1;


    $value .= '

        <option value = '.$row['customer_id'].'>'.$row['names'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
