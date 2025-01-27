<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "
SELECT  ROW_NUMBER() OVER (ORDER BY PRO.id) as num,
INVE.id,
INVE.quantity,
INVE.alert_quantity,
INVE.last_updated,
PRO.status,
PRO.sales_point_id,
PRO.name,
PRO.price,
PRO.description,
PRO.id AS product_id
FROM
inventory INVE INNER JOIN products PRO ON INVE.product_id = PRO.id 
WHERE PRO.company_ID = $comID AND 
PRO.sales_point_id = $spt
GROUP BY PRO.id ORDER BY INVE.last_updated DESC
";


$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sumTotalQuery = "SELECT  SUM(PRO.price * INVE.quantity) AS sumtotal
FROM
inventory INVE INNER JOIN products PRO ON INVE.product_id = PRO.id 
WHERE PRO.company_ID = $comID AND 
PRO.sales_point_id = $spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];


$response = array(
    "data" => $data,
    'sumtotal' => $sumtotal,
);

echo json_encode($response);

$conn->close();

?>