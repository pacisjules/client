<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$session_id = $_GET['session_id'];
$company_id = $_GET['company_id'];





$sql = "
SELECT DISTINCT
    PR.stand_id ,
    PS.product_name,
    RW.raw_material_name,
    RW.unit_of_measure,
    PR.quantity,
    PR.unit_id,
    PR.created_at
FROM
standardrowmaterial PR
JOIN rawmaterials RW ON
    PR.raw_material_id = RW.raw_material_id
JOIN product_standard PS ON
    PR.standard_code = PS.standard_code COLLATE utf8mb4_unicode_ci   
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
        'name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit_of_measure'],
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

