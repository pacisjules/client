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
SL.price_per_unity,
SL.total_price,
SL.product_id,
SL.spt_id, 
SP.location,
SL.purchase_date,
SL.paid_status,
SU.names,
SU.phone
FROM
purchase SL
JOIN supplier SU ON
SL.supplier_id = SU.supplier_id    
LEFT JOIN products RW ON
SL.product_id = RW.id
LEFT JOIN salespoint SP ON
SL.spt_id = SP.sales_point_id
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
        'price_item' => $row['price_per_unity'],
        'total_price' => $row['total_price'],
        'location' => $row['location'],
        'purchase_date' => $row['purchase_date'],
        'paid_status' => $row['paid_status'],
        'cust_name' => $row['names'],
        'phone' => $row['phone'],
    );

    $data[] = $item;
}

// Calculate sumtotal for 'Paid' and 'Not Paid' sales
$sumTotalQueryPaid = "SELECT SUM(total_price) AS sumtotal_paid FROM purchase WHERE  sess_id = '$sess_id'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal_paid'];

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
