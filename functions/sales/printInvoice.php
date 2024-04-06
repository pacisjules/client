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
        SL.sales_id,
        SL.sess_id,
        PD.name AS Product_Name,
        SP.manager_name,
        SP.phone_number,
        SP.location,
        PD.benefit,
        SL.product_id,
        SL.quantity,
        SL.sales_price,
        SL.total_amount,
        SL.total_benefit,
        SL.paid_status,
        SL.created_time,
        SL.sales_type,
        INV.alert_quantity,
        INV.quantity AS remain_stock,
        CU.names
    FROM
        sales SL
    JOIN products PD ON
        SL.product_id = PD.id
    JOIN salespoint SP ON
        SL.sales_point_id = SP.sales_point_id
    JOIN inventory INV ON
        SL.product_id = INV.product_id
    LEFT JOIN customer CU ON
        SL.customer_id = CU.customer_id

    WHERE
        SL.sess_id = '$sess_id'
    GROUP BY
        SL.sales_id
    ORDER BY
        SL.created_time DESC";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();

// Fetch data from the result set
while ($row = $result->fetch_assoc()) {
    $tprice = $row['total_amount'];
    $qty = $row['quantity'];
    $pic = $tprice / $qty;

    $item = array(
        'sale_id' => $row['sales_id'],
        'sess_id' => $row['sess_id'],
        'product_id' => $row['product_id'],
        'Product_Name' => $row['Product_Name'],
        'sales_price' => $pic,
        'quantity' => $row['quantity'],
        'total_amount' => $row['total_amount'],
        'total_benefit' => $row['total_benefit'],
        'created_time' => $row['created_time'],
        'paid_status' => $row['paid_status'],
    );

    $data[] = $item;
}

// Calculate sumtotal for 'Paid' and 'Not Paid' sales
$sumTotalQueryPaid = "SELECT SUM(total_amount) AS sumtotal_paid FROM sales WHERE  sess_id = '$sess_id'";
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
