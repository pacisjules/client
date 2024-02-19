<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$date = $_GET['date'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT DISTINCT
        RE.id,
        RE.carName,
        RE.platename,
        RE.carType,
        RE.servicesNeeded,
        RE.status,
        CU.names,
        CU.phone,
        RE.created_at
    FROM
        serviceRequest RE,
        customer CU
    WHERE
        RE.created_at LIKE '$date%'
        AND RE.spt=$spt 
        AND CU.customer_id = RE.customer_id ";

$result = $conn->query($sql);

$num = 0;

// Convert the results to an array of objects
$data = array();
while ($row = $result->fetch_assoc()) {
  $item = array(
        'id' => $row['id'],
        'carName' => $row['carName'],
        'platename' => $row['platename'],
        'carType' => $row['carType'],
        'servicesNeeded' => $row['servicesNeeded'],
        'statuss' => $row['status'],
        'names' => $row['names'],
        'phone' => $row['phone'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
}

$sqltot = "SELECT 
        COUNT(*) as totalrequest
    FROM
        serviceRequest 
    WHERE
        created_at LIKE '$date%'
        AND spt=$spt";

$sumResult = $conn->query($sqltot);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['totalrequest']; // Corrected the array key to 'totalrequest'



$response = array(
    'totalrequest' => $sumtotal,
    'requests' => $data,
);

// Convert data to JSON
$jsonData = json_encode($response);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

?>
