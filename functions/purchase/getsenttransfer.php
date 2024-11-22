<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$supervisor = $_GET['supervisor'];



// Retrieve all users from the database
$sql = "SELECT 
    ROW_NUMBER() OVER (ORDER BY PD.id) as num,
    PD.id as pid,
    P.id as product_id,
    P.name as product_name,
    PD.quantity,
    CONCAT(E.first_name, ' ', E.last_name) as requested_name,
    S.location as from_location,
    PD.created_at,
    PD.request_status,
    PD.sales_point_id
FROM 
    requestransfer PD
LEFT JOIN 
    products P ON P.id = PD.product_id
LEFT JOIN 
    employee E ON E.user_id = PD.user_id
LEFT JOIN 
    salespoint S ON S.sales_point_id = PD.sales_point_id
WHERE 
    PD.supervisor_id = $supervisor


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