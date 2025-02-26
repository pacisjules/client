<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$righttime=date('Y-m-d', time());
$spt = $_GET['spt'];

// Escape variables to prevent SQL injection vulnerabilities
$righttime = $conn->real_escape_string($righttime);
$spt = intval($spt);

// SQL query to fetch daily sales records
$sql = "
    SELECT
        ROW_NUMBER() OVER (ORDER BY s.sess_id) AS num,
        s.sess_id,
        c.names AS customer_name,
        c.phone AS customer_phone,
        SUM(s.total_amount) AS total_amount,
        SUM(s.total_benefit) AS total_benefit,
        SUM(s.paid) AS totpaid,
        s.created_time AS created_time,
    (SELECT CONCAT(employee.first_name,' ', employee.last_name) AS NAME from employee where employee.user_id=s.user_id) AS doneby
    FROM 
        sales s
    JOIN 
        customer c ON s.customer_id = c.customer_id
    WHERE 
        s.sales_point_id = $spt AND
        s.created_time LIKE '$righttime%'
    GROUP BY 
        s.sess_id
    ORDER BY 
        s.created_time DESC
";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "
    SELECT IFNULL(SUM(total_amount), 0) AS sumtotal,IFNULL(SUM(paid), 0) AS sumpaid, IFNULL(SUM(total_amount-paid), 0) AS sumbalance
    FROM sales
    WHERE created_time LIKE '$righttime%' AND sales_point_id = $spt
";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];
$sumpaid = $sumRow['sumpaid'];
$sumbalance = $sumRow['sumbalance'];

// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,
    'sumpaid' => $sumpaid,
    'sumbalance' => $sumbalance,
);

echo json_encode($responseData);

// Close the database connection
$conn->close();
?>
