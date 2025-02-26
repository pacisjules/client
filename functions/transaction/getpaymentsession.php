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
        ROW_NUMBER() OVER (ORDER BY payments.PaymentID) AS num,
        payments.PaymentID,
        payments.sessionId,
        payments.PaymentMethod,
        payments.Amount,
        payments.PaymentDate
       
    FROM 
        payments 

    WHERE 
        payments.spt = $spt AND payments.sessionId='$session_id'
    ORDER BY 
        payments.PaymentDate DESC
";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "
    SELECT IFNULL(SUM(Amount), 0) AS sumtotal
    FROM payments
    WHERE sessionId='$session_id' AND spt = $spt
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
