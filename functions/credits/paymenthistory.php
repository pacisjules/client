<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');


$supplier_id = $_GET['supplier_id'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT
        dh.id,
        dh.user_id,
        dh.customer_id,
        dh.action,
        dh.amount_paid,
        dh.current_balance,
        dh.created_at,
        (SELECT CONCAT(first_name,' ',last_name)FROM employee WHERE user_id=dh.user_id )AS user_name,
        (SELECT names FROM customer WHERE customer_id=dh.customer_id )AS customer_name

        FROM debts_history dh WHERE customer_id=$customer_id and spt=$spt";


$result = mysqli_query($conn, $sql);



// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {

    
    
    $item = array(
        'user_name' => $row['user_name'],
        'customer_name' => $row['customer_name'],
        'action' => $row['action'],
        'amount_paid' => $row['amount_paid'],
        'current_balance' => $row['current_balance'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
}



$sqltot = "SELECT CST.names as cust_name , CST.phone as cust_phone, CST.address as cust_address,
                  SUM(DB.amount) as total_debtcust,
                  SUM(DB.amount_paid) as total_paidcust
FROM debts DB, 
     customer CST 
     WHERE 
      DB.customer_id='$customer_id' 
     AND DB.sales_point_id=$spt 
     AND CST.customer_id='$customer_id' 
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

?>
