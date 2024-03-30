<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters

$store_id = $_GET['store_id'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// SQL query to fetch daily sales records
$sql = "
SELECT DISTINCT
products.id AS product_id,
products.name AS product_name,
(SELECT COALESCE(SUM( purchase.container), 0) AS entry FROM purchase WHERE purchase.product_id=products.id AND purchase.purchase_date >= '$startDate%' AND purchase.purchase_date <='$endDate%'AND purchase.store_id=$store_id) AS entry_stock,
(SELECT COALESCE(SUM(transferHistory.box_or_carton), 0) AS sold FROM transferHistory WHERE transferHistory.product_id=products.id AND transferHistory.created_at >= '$startDate%' AND transferHistory.created_at <='$endDate%' AND transferHistory.store_id=$store_id ) AS sold_stock,
storedetails.box_or_carton AS closing_stock

FROM
storedetails
JOIN products ON storedetails.product_id= products.id
LEFT JOIN transferHistory ON transferHistory.store_id=storedetails.store_id
LEFT JOIN purchase ON storedetails.store_id=purchase.store_id
WHERE storedetails.store_id=$store_id;

";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();



while ($row = $result->fetch_assoc()) {
    $openingStock = 0;
    $totalStock = 0;
    $soldStock = $row['sold_stock'];
    $closing_stock = $row['closing_stock'];
    $entry_stock = $row['entry_stock'];
    
    
    
    if($row['entry_stock']===0){
      $openingStock = $soldStock + $closing_stock;  
      $totalStock = $soldStock + $closing_stock;
    }else{
       $openingStock = ($soldStock + $closing_stock) - $entry_stock; 
       $totalStock = $openingStock + $entry_stock;
    }
    
    $item = array(
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'opening_stock' => $openingStock,
        'entry_stock' => $row['entry_stock'],
        'totalstock' =>  $totalStock,
        'sold_stock' => $row['sold_stock'],
        'closing_stock' => $row['closing_stock'],
    );

    $data[] = $item;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT COUNT(*) AS sumtotal FROM storedetails
WHERE store_id=$store_id ";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];




// Create an array to hold the response data
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
?>

