<?php
require_once '../connection.php';


$spt = $_GET['spt'];


$sql = 
" 
  SELECT
  ROW_NUMBER() OVER (ORDER BY INV.quantity * 100 / INV.alert_quantity ASC) AS num,
  INV.id,
  INV.product_id,
  PD.name,
  INV.quantity,
  INV.alert_quantity,
  INV.last_updated,
  INV.quantity*100/INV.alert_quantity as perc,
  CASE
    WHEN (INV.quantity) = 0 THEN 'Danger-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=10 THEN 'Danger-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=25 THEN 'High-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=50 THEN 'Medium-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=75 THEN 'Low-Risk'
    ELSE 'Normal'
  END AS STATUS,
  PD.sales_point_id
FROM
  inventory INV
JOIN
  products PD ON INV.product_id = PD.id
WHERE
  INV.quantity <= INV.alert_quantity AND PD.sales_point_id=$spt 
  
  ORDER BY INV.quantity*100/INV.alert_quantity ASC 
  ;

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