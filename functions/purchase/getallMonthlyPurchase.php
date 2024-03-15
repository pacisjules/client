<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');


//Get all sales by date

$comID = $_GET['company'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Last day of the current month

$sql = "
SELECT DISTINCT
SL.id,
(SELECT unitname FROM unittype WHERE unit_id = SL.unit_id) AS unit,
SL.container,
SL.quantity,
SL.price_per_unity,
SL.total_price,
SL.product_id,
SL.raw_material_id,
SL.store_id,
SL.spt_id,
IF(SL.store_id = 0, SP.location, ST.storename) AS stores_name,
IF(SL.product_id = 0, IG.raw_material_name, RW.name) AS name, 
SL.purchase_date,
SU.names,
SU.phone
FROM
purchase SL
JOIN supplier SU ON
SL.supplier_id = SU.supplier_id    
LEFT JOIN products RW ON
SL.product_id = RW.id
LEFT JOIN rawmaterials IG ON
SL.raw_material_id = IG.raw_material_id 
LEFT JOIN store ST ON
SL.store_id = ST.store_id
LEFT JOIN salespoint SP ON
SL.spt_id = SP.sales_point_id
WHERE
    SL.purchase_date >= '$startDate 00:00:00' 
    AND SL.purchase_date <= '$endDate 23:59:59' 
    AND SL.company_ID = $comID
GROUP BY
    SL.id
ORDER BY
    SL.purchase_date DESC";

$result = $conn->query($sql);

// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {
    // ... Your existing code to process each row ...

    // Create an object to represent each row of data
    $item = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'product_id' => $row['product_id'],
        'unit' => $row['unit'],
        'container' => $row['container'],
        'quantity' => $row['quantity'],
        'price_per_unity' => $row['price_per_unity'],
        'total_price' => $row['total_price'],
        'supplierNames' => $row['names'],
        'supplierPhone' => $row['phone'],
        'purchase_date' => $row['purchase_date'],
        'store_id' => $row['store_id'],
        'storename' => $row['stores_name'],
    );

    // Add the item to the data array
    $data[] = $item;
}


$sumTotalQuery = "SELECT SUM(total_price) AS sumtotal FROM purchase 
WHERE
    purchase_date >= '$startDate 00:00:00' 
    AND purchase_date <= '$endDate 23:59:59' 
    AND  company_ID = $comID";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];


// Create an array to hold the response data
$responseData = array(
    'data' => $data, // Your existing data
    'sumtotal' => $sumtotal,

);

// Convert data to JSON
$jsonData = json_encode($responseData);


// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
