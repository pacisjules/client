<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];
$startdate =$_GET['startdate'];
$enddate =$_GET['enddate'];

// Retrieve all products and inventory for the given company and sales point
$sql = "
SELECT 
products.name,
debts.amount,
debts.qty,
debts.created_date,
debts.sales_point_id,
customer.names,
customer.phone
FROM
debts
JOIN products ON debts.product_id=products.id
JOIN customer ON debts.customer_id=customer.customer_id
WHERE debts.sales_point_id=$spt
AND debts.created_date >= '$startdate 00:00:00'
AND debts.created_date <= '$enddate 23:59:59'
ORDER BY debts.created_date DESC

";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {


     $item = array(
        'names'=> $row['names'],
        'phone' => $row['phone'],
        'name' => $row['name'],
        'amount' => $row['amount'],
        'qty' => $row['qty'],
        'created_date' => $row['created_date'],
        'sales_point_id' => $row['sales_point_id'],
    );

    $data[] = $item;
}

$sqltot = "SELECT
                  SUM(amount) as total_debtcust                 
FROM debts
     WHERE 

     sales_point_id=$spt 
     AND created_date >= '$startdate 00:00:00'
AND created_date <= '$enddate 23:59:59'
     ";
        
$sumResult = $conn->query($sqltot);
$sumRow = $sumResult->fetch_assoc();

$total_debtcust = $sumRow['total_debtcust'];


$responseData = array(
    'data' => $data,
    'total_debtcust'=> $total_debtcust,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');
// Send the JSON response
echo $jsonData;

