<?php
require_once '../connection.php';

$spt = $_GET['spt'];

$sql = "
SELECT DISTINCT
ROW_NUMBER() OVER (ORDER BY DE.customer_id) as num,
CU.names,
CU.phone,
CU.address,
DE.due_date,
DE.status,
DE.customer_id,
(SELECT SUM(amount - amount_paid) FROM debts WHERE customer_id = DE.customer_id AND sales_point_id= $spt GROUP BY DE.customer_id ) AS Amount
FROM
debts DE
JOIN
customer CU ON DE.customer_id = CU.customer_id
WHERE
DE.sales_point_id = $spt
GROUP BY DE.customer_id

";
$result = $conn->query($sql);
$total_sum=0;
while ($row = $result->fetch_assoc()) {
    $total_sum += $row['Amount'];
}



$response =$total_sum;

echo $response;

$conn->close();
?>