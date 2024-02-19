<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT DISTINCT
        *
    FROM
        debtscustomer
    WHERE
        spt_id=$spt AND paid_status =1";

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
        'total_amount' => $row['total_amount'],
        'due_date' => $row['due_date'],
    );

    $data[] = $item;
 
}

$sqltot = "SELECT DISTINCT
        SUM(total_amount) as total_debt
    FROM
        debtscustomer
    WHERE
        spt_id=$spt AND paid_status = 1";
        
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
