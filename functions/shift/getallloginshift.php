<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        LO.id,
        LO.user_id,
        LO.login_time,
        LO.logout_time,
        US.username

        FROM loginfo LO,
        users US
        WHERE LO.user_id=US.id AND LO.sales_point_id = $spt 
        ORDER BY LO.created_at DESC";

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
        <td>'.$num.'. '.$row['username'].'</td>
        <td>'.$row['login_time'].'</td>
        <td>'.$row['logout_time'].'</td> 
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
