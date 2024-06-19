<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];
$sess_id=$_GET['sess_id'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT DB.id, CST.names as person_names,CST.phone,CST.address,DB.descriptions,DB.created_date, DB.amount,DB.amount_paid, DB.due_date, DB.sales_point_id, DB.status, PD.name, DB.qty
FROM debts DB, products PD, customer CST WHERE  DB.status=1 AND DB.product_id=PD.id AND DB.customer_id='$sess_id' AND DB.sales_point_id=$spt  AND CST.customer_id='$sess_id'
GROUP BY DB.id
ORDER BY DB.amount DESC";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {

$balance = $row['amount'] - $row['amount_paid'];
     $item = array(
        'id'=> $row['id'],
        'due_date' => $row['due_date'],
        'amount' => $balance,
        'name' => $row['name'],
        'qty' => $row['qty'],
    );

    $data[] = $item;
}

$sqltot = "SELECT CST.names as cust_name , CST.phone as cust_phone, CST.address as cust_address,
                  SUM(DB.amount) as total_debtcust,
                  SUM(DB.amount_paid) as total_paidcust
FROM debts DB, 
     customer CST 
     WHERE 
      DB.customer_id='$sess_id' 
     AND DB.sales_point_id=$spt 
     AND CST.customer_id='$sess_id' 
     ";
        
$sumResult = $conn->query($sqltot);
$sumRow = $sumResult->fetch_assoc();
$names = $sumRow['cust_name'];
$phone = $sumRow['cust_phone'];
$address = $sumRow['cust_address'];
$total_debtcust = $sumRow['total_debtcust'];
$total_paidcust = $sumRow['total_paidcust'];
$total_balance = $total_debtcust - $total_paidcust;

$responseData = array(
    'data' => $data,
    'names'=> $names,
    'phone'=> $phone,
    'address'=> $address,
    'total_debtcust'=> $total_debtcust,
    'total_paidcust'=> $total_paidcust,
    'total_balance'=> $total_balance,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');
// Send the JSON response
echo $jsonData;

