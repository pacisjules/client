<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.category_id  , 
        CUST.categoryName,
        CUST.managedBy, 
        (SELECT CONCAT(first_name,' ',last_name) AS manager_name FROM employee WHERE employee_id = CUST.managedBy) as Category_manager,
        CUST.created_at
        FROM assetCategory CUST 
        WHERE CUST.spt = $spt 
        GROUP BY CUST.category_id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['category_id'];
    $num+=1;

 $value .= '

        <option value = '.$row['category_id'].'>'.$num.'. '.$row['categoryName'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
