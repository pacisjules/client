<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_ID = $_GET['company'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.supplier_id , 
        CUST.names,
        CUST.phone, 
        CUST.address,
        CUST.created_at
        FROM supplier CUST 
        WHERE CUST.company_ID = $company_ID 
        GROUP BY CUST.supplier_id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['supplier_id'];
    $num+=1;

  

    $value .= '

        <option value = '.$row['supplier_id'].'>'.$num.'. '.$row['names'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
