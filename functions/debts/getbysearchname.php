<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];
$names = $_GET['names'];

// Validate and sanitize user input
$spt = intval($spt); // Ensure it's an integer
$names = mysqli_real_escape_string($conn, $names); // Sanitize input

$sql = "SELECT DISTINCT
            CU.names,
            CU.phone,
            CU.address,
            DE.due_date,
            DE.status,
            DE.customer_id,
            (SELECT SUM(amount - amount_paid) FROM debts WHERE customer_id = DE.customer_id AND sales_point_id = $spt) AS Amount
        FROM
            debts DE
        JOIN
            customer CU ON DE.customer_id = CU.customer_id 
        WHERE 
            DE.sales_point_id = $spt AND CU.names LIKE '%$names%'";

$result = mysqli_query($conn, $sql);

$value = "";
$num = 0;

while ($row = $result->fetch_assoc()) {
    // Process your rows here
}

$response = array(
    'debts' => $value
);

// Convert data to JSON
$jsonData = json_encode($response);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>