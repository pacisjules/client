<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$company = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT
    sh.id AS shift_id,
    sh.names AS shift_name,
    sh.spt AS sales_point_id,
    sh.created_at AS shift_created_at,
    sp.location AS sales_point_location,
    sp.manager_name AS sales_point_manager
FROM
    shift sh
JOIN
    salespoint sp ON sh.spt = sp.sales_point_id

WHERE
    sh.company = $company;
";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['shift_id'];
   
    $num+=1;

     $value .= '

        <option value = '.$row['shift_id'].'>'.$num.'. '.$row['shift_name'].' for '.$row['sales_point_location'].'</option>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

