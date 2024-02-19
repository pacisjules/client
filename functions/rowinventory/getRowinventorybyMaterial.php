<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];
$rowid = $_GET['row_id'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT PU.id, RW.raw_material_id,RW.raw_material_name ,RW.unit_of_measure, PU.quantity,PU.price_per_unity,PU.purchase_date,SU.names,SU.phone
FROM rawmaterials RW
JOIN purchase PU ON RW.raw_material_id = PU.raw_material_id 
JOIN supplier SU ON PU.supplier_id=SU.supplier_id
WHERE PU.raw_material_id = $rowid AND RW.sales_point_id= $spt";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {


     $item = array(
         'stock_id' => $row['stock_id'],
         'raw_material_id' => $row['raw_material_id'],
        'raw_material_name' => $row['raw_material_name'],
        'unit_of_measure' => $row['unit_of_measure'],
        'quantity' => $row['quantity'],
        'price_per_unity' => $row['price_per_unity'],
        'names' => $row['names'],
        'phone' => $row['phone'],
        'purchase_date' => $row['purchase_date'],
    );

    $data[] = $item;
}


$sqlnames = "SELECT raw_material_name
FROM rawmaterials 
WHERE raw_material_id = $rowid AND sales_point_id= $spt";

$sumResult = $conn->query($sqlnames);
$sumRow = $sumResult->fetch_assoc();
$raw_material_name = $sumRow['raw_material_name'];


$responseData = array(
    'data' => $data,
    'names' => $raw_material_name,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');
// Send the JSON response
echo $jsonData;

