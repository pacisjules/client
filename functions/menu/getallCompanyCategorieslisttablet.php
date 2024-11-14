<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT * FROM product_category WHERE `company_id` = $comID
        ORDER BY `created_at` DESC LIMIT 5
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();

$value .= '<li onclick="View_ProductsRecord()">ALL</li>';
while ($row = $result->fetch_assoc()) {
    $myid = $row['category_id'];
    $date = new DateTime($row['created_at']);
    $formattedDate = $date->format('l, F j, Y');
   
    $num+=1;

     $value .= '
        <li onclick="setSelect(`'.$row['category_id'].'`)">'.$row['name'].'</li>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
