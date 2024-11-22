<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');


//Get all sales by date

$comID = $_GET['company'];
$spt = $_GET['spt'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Last day of the current month

$sql = "
    SELECT 
        RT.id AS request_id,
        RT.sess_id,
        RT.user_id,
        RT.product_id,
        RT.sales_point_id,
        RT.company,
        RT.quantity,
        RT.received_qty,
        (select CONCAT(first_name, ' ', last_name) as name from employee where user_id = RT.supervisor_id) AS request_to,
        RT.request_by_name,
        RT.request_store,
        RT.supervisor_id,
        RT.request_status,
        RT.created_at AS request_created_time,
        PD.name AS product_name
    FROM 
        requestransfer RT
    JOIN 
        products PD 
    ON 
        RT.product_id = PD.id
    WHERE 
        RT.created_at >= '$startDate 00:00:00' 
        AND RT.created_at <= '$endDate 23:59:59' 
        AND RT.company = $comID 
        AND RT.sales_point_id = $spt
    ORDER BY 
        RT.created_at DESC";

$result = $conn->query($sql);

// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {

    // Create an object to represent each row of data
    $item = array(
        'request_id' => $row['request_id'],
        'sess_id' => $row['sess_id'],
        'user_id' => $row['user_id'],
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'received_qty' => $row['received_qty'],
        'request_by_name' => $row['request_by_name'],
        'request_store' => $row['request_store'],
        'supervisor_id' => $row['supervisor_id'],
        'request_status' => $row['request_status'],
        'created_time' => $row['request_created_time'],
        'request_to' => $row['request_to'],
        // Add other fields as needed
    );

    // Add the item to the data array
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
