<?php
require_once '../connection.php';

//Get all sales by date
$date = $_GET['date'];
$spt = $_GET['spt'];


$sql = 
"
    SELECT
    product_id,
    ROW_NUMBER() OVER (ORDER BY SUM(total_benefit) DESC) AS num,
    (select name from products WHERE id=SL.product_id) AS Product_name,
    SUM(quantity) AS total_sold,
    SUM(total_amount) AS Amount,
    SUM(total_benefit) AS Benefit,
    SUM(SL.quantity) AS Quantity
    
    FROM
        sales SL
    WHERE 
    sales_point_id=$spt AND created_time LIKE '$date %'

    GROUP BY product_id
    ORDER BY Benefit DESC
    LIMIT 30;
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