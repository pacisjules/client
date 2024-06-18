<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company = $_GET['company'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT * FROM users WHERE users.company_ID=$company and salepoint_id=$spt";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num+=1;


    $value .= '

        <tr>
        <td>'.$num.'</td>
        <td>'.$row['username'].'</td>
        <td>'.$row['userType'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-primary" type="button" style="margin-left: 20px;" onclick="viewusersalesreportyest(`'.$myid.'`)"> view</button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
