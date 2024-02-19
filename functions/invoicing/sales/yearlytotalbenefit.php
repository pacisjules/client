<?php
// Include the database connection file
require_once '../connection.php';

// Set master path
header('Content-Type: application/json');

// Get the year and sales point from the query parameters
$year = $_GET['year'];
$spt = $_GET['spt'];

// Calculate the start and end dates of the year
$start_date = date('Y-m-d', strtotime("$year-01-01"));
$end_date = date('Y-m-d', strtotime("$year-12-31"));

// Prepare the SQL query
$sql = "
    SELECT
        SUM(total_amount) AS Total_sales_Amount,
        SUM(total_benefit) AS Total_sales_Benefits,
        COUNT(*) AS Sales_Count
    FROM
        sales SL
    WHERE 
        SL.sales_point_id = $spt
        AND SL.created_time >= '$start_date 00:00:00'
        AND SL.created_time <= '$end_date 23:59:59'
";

$result = $conn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data['Total_sales_Amount'] = $row['Total_sales_Amount'];
    $data['Total_sales_Benefits'] = $row['Total_sales_Benefits'];
}

// Send the data as JSON response
echo json_encode($data);
?>
