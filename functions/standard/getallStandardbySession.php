<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$session_id = $_GET['session_id'];
$product_id = $_GET['product_id'];
$company_id = $_GET['company_id'];





$sql = "
SELECT DISTINCT
    PR.stand_id ,
    RW.raw_material_name,
    PR.quantity,
    PR.unit_id,
    PR.created_at
FROM
standardrowmaterial PR
JOIN rawmaterials RW ON
    PR.raw_material_id = RW.raw_material_id
WHERE PR.standard_code='$session_id' AND PR.company_id=$company_id
";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {


     $item = array(
        'id'=> $row['stand_id'],
        'raw_material_name' => $row['raw_material_name'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit_id'],
        'created_at' => $row['created_at'],
    );

    $data[] = $item;
}

$sqltot = "SELECT name FROM products  WHERE id=$product_id";
        
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

