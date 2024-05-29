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
PR.id,
PR.sess_id,
PR.dedicated_to,
PR.user_id,
CONCAT(EP.first_name,' ',EP.last_name) AS full_name,
EP.phone,
SP.location,
PR.product_name,
PR.quantity,
PR.price,
PR.total,
PR.created_at


FROM
requisition PR

JOIN salespoint SP ON
PR.spt_id = SP.sales_point_id

JOIN employee EP ON
PR.user_id = EP.user_id

WHERE
PR.sess_id = '$sess_id'
ORDER BY
PR.created_at DESC";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();

// Fetch data from the result set
while ($row = $result->fetch_assoc()) {


    $item = array(
        'id' => $row['id'],
        'sess_id' => $row['sess_id'],
        'Product_Name' => $row['product_name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'total_amount' => $row['total'],
        'created_at' => $row['created_at'],
        'customer_name' => $row['dedicated_to'],
        'phone' => $row['phone'],
        'full_name' => $row['full_name'],
    );

    $data[] = $item;
}

// Calculate sumtotal for 'Paid' and 'Not Paid' sales
$sumTotalQueryPaid = "SELECT SUM(total) AS sumtotal FROM requisition WHERE  sess_id = '$sess_id'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal'];

// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotalPaid,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Send the JSON response
echo $jsonData;

// Close the database connection
$conn->close();
?>
