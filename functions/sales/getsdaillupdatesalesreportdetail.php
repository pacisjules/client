<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters

$spt = $_GET['spt'];
$session_id = $_GET['session_id'];

// Escape variables to prevent SQL injection vulnerabilities
$spt = intval($spt);

// SQL query to fetch daily sales records
$sql = "
    SELECT
        ROW_NUMBER() OVER (ORDER BY s.sess_id) AS num,
        s.sess_id,
        s.sales_id,
        s.product_id,
        c.name AS product_name,
        s.sales_price,
        s.quantity,
        s.total_amount AS total_amount,
        s.total_benefit AS total_benefit,
        s.paid AS totpaid,
        s.created_time AS created_time,
    (SELECT CONCAT(employee.first_name,' ', employee.last_name) AS NAME from employee where employee.user_id=s.user_id) AS doneby
    FROM 
        sales s
    JOIN 
        products c ON s.product_id = c.id
    WHERE 
        s.sales_point_id = $spt AND s.sess_id='$session_id'
    ORDER BY 
        s.created_time DESC
";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "
    SELECT IFNULL(SUM(total_amount), 0) AS sumtotal
    FROM sales
    WHERE sess_id='$session_id' AND sales_point_id = $spt
";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];

// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,
);

echo json_encode($responseData);

// Close the database connection
$conn->close();
?>
