<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$session_id = $_GET['session_id'];
$product_id = $_GET['product_id'];
$spt = $_GET['spt'];





$sql = "
SELECT DISTINCT
    PR.id,
    RW.raw_material_name,
    PR.quantity,
    PR.unit,
    PR.created_at
FROM
    production PR
JOIN rawmaterials RW ON
    PR.raw_material_id = RW.raw_material_id
WHERE PR.session_id='$session_id' AND PR.sales_point_id =$spt
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
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
}

$sqltot = "SELECT name FROM products  WHERE id=$product_id  AND sales_point_id=$spt ";
        
$sumResult = $conn->query($sqltot);
$sumRow = $sumResult->fetch_assoc();
$names = $sumRow['name'];


$responseData = array(
    'data' => $data,
    'name'=> $names,
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');
// Send the JSON response
echo $jsonData;

