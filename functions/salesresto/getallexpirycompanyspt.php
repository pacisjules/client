<?php
require_once '../connection.php';

$spt = $_GET['spt'];

$sql = "
SELECT
    ROW_NUMBER() OVER (ORDER BY exp.exp_id) AS num,
    pd.name,
    exp.quantity,
    exp.created_at,
    exp.due_date
FROM
    expiration_table AS exp,
    products AS pd
WHERE
    exp.product_id = pd.id
    AND pd.sales_point_id = $spt
    AND exp.status = 1
    AND pd.allow_exp = 1
    AND exp.due_date > CURRENT_DATE;
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