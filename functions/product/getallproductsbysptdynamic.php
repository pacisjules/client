<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "SELECT  ROW_NUMBER() OVER (ORDER BY PD.id) as num,
       PD.name, PD.price, PD.benefit, PD.status, PD.description,PD.created_at ,IFNULL(INV.quantity, 0) AS invquantity
        FROM products PD
        LEFT JOIN inventory INV ON PD.id = INV.product_id
        WHERE PD.company_ID = $comID
        AND PD.sales_point_id = $spt 
       ORDER BY PD.created_at DESC
       
        ";


$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


$response = array(
    "data" => $data
);

echo json_encode($response);

$conn->close();

?>