<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];
$startdate = $_GET['startdate'];
$enddate = $_GET['enddate'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT DISTINCT
*
FROM
debts_history
JOIN customer ON debts_history.customer_id=customer.customer_id
WHERE
debts_history.spt=$spt 
AND debts_history.created_at >= '$startdate 00:00:00'
AND debts_history.created_at  <= '$enddate 23:59:59'";

$value = "";
$result = mysqli_query($conn, $sql);

$num = 0;

// Convert the results to an array of objects
$data = array();
while ($row = $result->fetch_assoc()) {

    
   $item = array(
        'names' => $row['names'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'amount_paid' => $row['amount_paid'],
        'action' => $row['action'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
 
}

$sqltot = "SELECT 
        SUM(amount_paid) as total_debt
    FROM
    debts_history
    WHERE
        spt=$spt AND created_at >= '$startdate 00:00:00'
AND created_at  <= '$enddate 23:59:59'";
        
$sumResult = $conn->query($sqltot);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['total_debt'];


$response = array(
    'debts' => $data,
    'total_debt' => $sumtotal,
);

// Convert data to JSON
$jsonData = json_encode($response);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

?>
