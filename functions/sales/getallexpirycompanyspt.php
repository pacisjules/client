<?php
require_once '../connection.php';

$spt = $_GET['spt'];

$sql = "
SELECT
    ROW_NUMBER() OVER (ORDER BY exp.exp_id) as num,
    pd.name,
    exp.quantity,
    exp.created_at,
    exp.due_date
FROM
    expiration_table as exp,
    products AS pd
WHERE
    exp.product_id = pd.id AND sales_point = $spt AND
exp.STATUS
    = 1 AND PD.allow_exp = 1


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