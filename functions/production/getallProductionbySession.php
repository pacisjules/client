<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$session_id = $_GET['session_id'];
$company_id = $_GET['company_id'];





$sql = "
SELECT DISTINCT
    PR.id,
    RW.raw_material_name,
    PR.quantity,
    PR.unit,
    PR.created_at,
    PR.standard_code,
    (select product_name from product_standard as name where standard_code=PR.standard_code COLLATE utf8mb4_unicode_ci) AS product_name
FROM
    production PR
JOIN rawmaterials RW ON
    PR.raw_material_id = RW.raw_material_id
WHERE PR.session_id='$session_id' AND PR.company_id=$company_id
";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {


     $item = array(
        'id'=> $row['id'],
        'raw_material_name' => $row['raw_material_name'],
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
}

$responseData = array(
    'data' => $data,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');
// Send the JSON response
echo $jsonData;

