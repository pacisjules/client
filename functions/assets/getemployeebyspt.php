<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.employee_id, 
        CONCAT(CUST.first_name,' ',CUST.last_name) AS manager_name
        FROM employee CUST 
        WHERE CUST.sales_point_id = $spt 
        GROUP BY CUST.employee_id
        ORDER BY CUST.hire_date DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['employee_id'];
    $num+=1;

 $value .= '

        <option value = '.$row['employee_id'].'>'.$num.'. '.$row['manager_name'].'</option>
 
        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
