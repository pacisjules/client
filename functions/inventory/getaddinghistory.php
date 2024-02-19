<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');


$date = $_GET['date'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
hi.action,
hi.user_id,
hi.timestamp,
(SELECT CONCAT(first_name,' ',last_name)FROM employee WHERE user_id=hi.user_id )AS full_name
FROM history hi WHERE timestamp LIKE '$date%' AND section='inventoryIn' AND sales_point_id = $spt";


$result = mysqli_query($conn, $sql);



// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {

    
    
    $item = array(
        'full_name' => $row['full_name'],
        'action' => $row['action'],
        'timestamp' => $row['timestamp'],
    );

    $data[] = $item;
}


$responseData = array(
    'data' => $data,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

?>
