<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date = $_GET['date'];
$spt = $_GET['spt'];

// SQL query to fetch daily sales records
$sql = "
    SELECT DISTINCT
    products.id AS product_id,
    products.name AS product_name,
    (SELECT COALESCE(SUM(purchase.quantity), 0) AS entry FROM purchase WHERE purchase.product_id=products.id AND purchase.purchase_date LIKE '$date%' AND purchase.spt_id=$spt) AS entry_stock,
    (SELECT COALESCE(SUM(sales.quantity), 0) AS sold FROM sales WHERE sales.product_id=products.id AND sales.created_time LIKE '$date%' AND sales.sales_point_id=$spt) AS sold_stock,
    products.price AS unit_price,
    COALESCE(inventoryhistory.quantity,0)  AS closing_stock,
    sales.created_time
FROM
    products
JOIN
    inventoryhistory ON products.id = inventoryhistory.product_id
JOIN
    sales ON products.id = sales.product_id
LEFT JOIN
    purchase ON products.id = purchase.product_id
WHERE 
     products.sales_point_id=$spt and inventoryhistory.last_updated LIKE '$date%'
       
GROUP BY
    products.id,inventoryhistory.product_id, sales.product_id;

";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();



while ($row = $result->fetch_assoc()) {
    $openingStock = 0;
    $totalStock = 0;
    $soldStock = $row['sold_stock'];
    $unit_price = $row['unit_price'];
    $totalprice = $unit_price * $soldStock;
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
        'unit_price' => $row['unit_price'],
        'totalprice' => $totalprice,
        'closing_stock' => $row['closing_stock'],
        'created_time' => $row['created_time'],
    );

    $data[] = $item;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT SUM(total_amount) AS sumtotal FROM sales 
                 WHERE created_time LIKE '$date%' AND sales_point_id =$spt";
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

