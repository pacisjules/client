<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date = $_GET['date'];
$comID = $_GET['company'];
$spt = $_GET['spt'];


// SQL query to fetch daily transfer requests
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
        RT.request_by_name,
        (select CONCAT(first_name, ' ', last_name) as name from employee where user_id = RT.supervisor_id) AS request_to,
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
        RT.created_at LIKE '$date%' 
        AND RT.company = $comID 
        AND RT.sales_point_id = $spt
    ORDER BY 
        RT.created_at DESC";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    // Convert time to the company's timezone
 

    // Build the data item
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
    );

    $data[] = $item;
}

// Calculate total quantity requested and received
$sumQuery = "
    SELECT 
        IFNULL(SUM(quantity), 0) AS total_requested, 
        IFNULL(SUM(received_qty), 0) AS total_received 
    FROM 
        requestransfer 
    WHERE 
        created_at LIKE '$date%' 
        AND company = $comID 
        AND sales_point_id = $spt";

$sumResult = $conn->query($sumQuery);
$sumRow = $sumResult->fetch_assoc();
$totalRequested = $sumRow['total_requested'];
$totalReceived = $sumRow['total_received'];

// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'total_requested' => $totalRequested,
    'total_received' => $totalReceived,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

?>
