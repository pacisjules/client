<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "product/getstandardsdetails.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point


$comID = $_GET['company'];
$code = $_GET['code'];


// Retrieve all users from the database
$sql = "
SELECT
    SD.stand_id,
    RM.raw_material_id,
    RM.raw_material_name,
    RM.unit_of_measure,
    SD.quantity,
    (select quantity_in_stock from rawstock WHERE raw_material_id=SD.raw_material_id) AS Current_stock
FROM
    standardrowmaterial SD,
    rawmaterials RM
WHERE
    SD.raw_material_id = RM.raw_material_id
AND
    SD.standard_code = '$code' AND SD.company_id = $comID

";

$value = "";
$result = mysqli_query($conn, $sql);
$num = 0;
$data=[];

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}   

// Convert data to JSON
$jsonData = json_encode($data);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
