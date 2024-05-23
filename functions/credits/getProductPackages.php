<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company = $_GET['company_id'];

// Retrieve all customer for debt
$sql = "SELECT 
products.name,
packages.packgenumber,
packages.pack_id,
packages.created_at
       
FROM packages 
JOIN products on packages.product_id = products.id 
WHERE packages.company_id = $company
ORDER BY packages.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
   
    $num+=1;


    $value .= '

        <option value = '.$row['pack_id'].'>'.$row['name'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
