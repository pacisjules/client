<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the session ID from the query parameters
$sess_id = $_GET['sess_id'];

// Check if the session ID is set
if (!isset($sess_id)) {
    http_response_code(400); // Bad request
    echo json_encode(array("error" => "Session ID is missing"));
    exit();
}

// SQL query to fetch sales records
$sql = "
SELECT DISTINCT
SL.id,
SL.sess_id,
RW.name,
SL.quantity,
SL.product_id,
SP.location,
SL.created_at,
SL.request_status,
SL.request_by_name

FROM
requestransfer SL
   
LEFT JOIN products RW ON
SL.product_id = RW.id
LEFT JOIN salespoint SP ON
SL.sales_point_id = SP.sales_point_id
WHERE
   SL.sess_id='$sess_id' 
GROUP BY
    SL.id";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();

// Fetch data from the result set
while ($row = $result->fetch_assoc()) {
   

    $item = array(
        'id' => $row['id'],
        'sess_id' => $row['sess_id'],
        'product_id' => $row['product_id'],
        'Product_Name' => $row['name'],
        'quantity' => $row['quantity'],
        'request_by_name' => $row['request_by_name'],
        'purchase_date' => $row['created_at'],
        'paid_status' => $row['request_status'],
      
    );

    $data[] = $item;
}



// Create an array to hold the response data
$responseData = array(
    'data' => $data,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Send the JSON response
echo $jsonData;

// Close the database connection
$conn->close();
?>
