<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company = $_GET['company_id'];
$spt = $_GET['spt'];

// Retrieve all customer for debt
$sql = "SELECT 
        CUST.id , 
        CUST.name
        FROM products CUST 
        WHERE CUST.company_ID = $company
        AND CUST.sales_point_id = $spt 
        GROUP BY CUST.id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num+=1;


    $value .= '

        <option value = '.$row['id'].'>'.$row['name'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
