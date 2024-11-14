<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get all sales by date
$startDate = $_GET['from'];
$endDate = $_GET['to'];
$comID = $_GET['company'];
$spt = $_GET['spt'];

// Prepare the SQL query to fetch sales data
$sql = "
SELECT DISTINCT
    ROW_NUMBER() OVER (ORDER BY SL.sales_id) as num,
    PD.name AS Product_Name,
    SP.manager_name,
    SP.phone_number,
    SP.location,
    PD.benefit,
    SL.product_id,
    SL.quantity,
    SL.sales_price,
    SL.total_amount,
    SL.total_benefit,
    SL.paid_status,
    SL.created_time,
    SL.sales_type,
    SL.storekeeperaproval,
    SL.manageraproval,
    INV.alert_quantity,
    INV.quantity AS remain_stock,
    (SELECT CONCAT(first_name, ' ', last_name) FROM employee WHERE user_id = SL.user_id) AS fullname
FROM
    sales SL
JOIN products PD ON
    SL.product_id = PD.id
JOIN salespoint SP ON
    SL.sales_point_id = SP.sales_point_id
JOIN inventory INV ON
    SL.product_id = INV.product_id
WHERE
    SL.created_time >= ?
    AND SL.created_time <= ?
    AND SP.company_ID = ?
    AND SL.sales_point_id = ?
GROUP BY
    SL.sales_id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $startDate, $endDate, $comID, $spt);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Prepare the SQL query to sum total amounts
$sumTotalQuery = "SELECT SUM(total_amount) AS sumtotal FROM sales 
                 WHERE created_time >= ? AND created_time <= ? AND sales_point_id = ?";
$sumStmt = $conn->prepare($sumTotalQuery);
$sumStmt->bind_param("ssi", $startDate, $endDate, $spt);
$sumStmt->execute();
$sumResult = $sumStmt->get_result();
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];

$response = array(
    "data" => $data,
    "total" => $sumtotal,
);

echo json_encode($response);

$conn->close();
?>
