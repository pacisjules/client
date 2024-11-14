<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "SELECT  ROW_NUMBER() OVER (ORDER BY PD.id) as num,PD.id as pid,
       PD.name, PD.price,  PD.status, PD.description,PD.created_time 
        FROM menu_items PD
        WHERE PD.company_ID = $comID
        AND PD.sales_point_id = $spt AND PD.status = 1
        ORDER BY PD.created_time DESC
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