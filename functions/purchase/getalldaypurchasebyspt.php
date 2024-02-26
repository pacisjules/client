<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date = $_GET['date'];
$company_ID = $_GET['company'];

// SQL query to fetch daily sales records
$sql = "
    SELECT DISTINCT
    SL.id,
    (SELECT unitname FROM unittype WHERE unit_id =SL.unit_id) AS unit,
    SL.container,
    SL.quantity,
    SL.price_per_unity,
    SL.total_price,
    SL.product_id,
    SL.store_id,
    SL.spt_id,
    IF(SL.store_id = 0, SP.location, ST.storename) AS stores_name,
    RW.name,
    SL.purchase_date,
    SU.names,
    SU.phone
FROM
    purchase SL
JOIN products RW ON
    SL.product_id = RW.id
JOIN supplier SU ON
    SL.supplier_id = SU.supplier_id
LEFT JOIN store ST ON
    SL.store_id = ST.store_id
LEFT JOIN salespoint SP ON
    SL.spt_id = SP.sales_point_id
WHERE
    SL.purchase_date LIKE '$date%'
    AND SL.company_ID = $company_ID
GROUP BY
    SL.id
ORDER BY
    SL.purchase_date DESC
";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();



while ($row = $result->fetch_assoc()) {
    
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

    $data[] = $item;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT SUM(total_price) AS sumtotal FROM purchase 
                 WHERE purchase_date LIKE '$date%' AND company_ID =$company_ID";
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
