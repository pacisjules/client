<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date

$comID = $_GET['company'];
$week = $_GET['week'];


// Get the start and end dates of the week
$year = date('Y');
$start_date = date('Y-m-d', strtotime($year . 'W' . $week));
$end_date = date('Y-m-d', strtotime($year . 'W' . $week . '7'));// Get the current date

$sql = "
SELECT DISTINCT
        SL.id ,
        SL.quantity,
        SL.price_per_unity,
        SL.total_price,
        SL.product_id,
        SL.store_id,
        ST.storename,
        RW.name ,
        SL.purchase_date,
        SU.names,
        SU.phone
    FROM
        purchase SL
    JOIN products RW ON
        SL.product_id = RW.id
    JOIN supplier SU ON
        SL.supplier_id = SU.supplier_id
    JOIN store ST ON
        SL.store_id = ST.store_id
WHERE
    SL.purchase_date >= '$start_date 00:00:00' 
    AND SL.purchase_date <= '$end_date 23:59:59' 
    AND SL.company_ID = $comID
GROUP BY
    SL.id
ORDER BY
    SL.purchase_date DESC";


   


$result = $conn->query($sql);


// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'product_id' => $row['product_id'],
        'quantity' => $row['quantity'],
        'price_per_unity' => $row['price_per_unity'],
        'total_price' => $row['total_price'],
        'supplierNames' => $row['names'],
        'supplierPhone' => $row['phone'],
        'purchase_date' => $row['purchase_date'],
        'store_id' => $row['store_id'],
        'storename' => $row['storename'],
    );

    $data[] = $item;
}

$sumQuery = "
SELECT SUM(total_price) AS sumtotal FROM purchase 
WHERE
    purchase_date >= '$start_date 00:00:00' 
    AND purchase_date <= '$end_date 23:59:59' 
    AND company_ID = $comID";

$results = $conn->query($sumQuery);

// Fetch the sumtotal and sumbenefit values
$sumData = $results->fetch_assoc();
$sumtotal = $sumData['sumtotal'];


// Create an array to hold the response data including sums
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,

);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
