<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date

$comID = $_GET['company'];
$week = $_GET['week'];
$spt = $_GET['spt'];

// Get the start and end dates of the week
$year = date('Y');
$start_date = date('Y-m-d', strtotime($year . 'W' . $week));
$end_date = date('Y-m-d', strtotime($year . 'W' . $week . '7'));// Get the current date

$sql = "
SELECT DISTINCT
    SL.sales_id,
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
    INV.alert_quantity,
    INV.quantity AS remain_stock
FROM
    sales SL
JOIN products PD ON
    SL.product_id = PD.id
JOIN salespoint SP ON
    SL.sales_point_id = SP.sales_point_id
JOIN inventory INV ON
    SL.product_id = INV.product_id
WHERE
    SL.created_time >= '$start_date 00:00:00' 
    AND SL.created_time <= '$end_date 23:59:59' 
    AND SP.company_ID = $comID 
    AND SL.sales_point_id = $spt
    AND SL.paid_status = 'Paid'
GROUP BY
    SL.sales_id
ORDER BY
    SL.created_time DESC";


   


$result = $conn->query($sql);


// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'Product_Name' => $row['Product_Name'],
        'sales_price' => $row['sales_price'],
        'quantity' => $row['quantity'],
        'total_amount' => $row['total_amount'],
        'total_benefit' => $row['total_benefit'],
        'created_time' => $row['created_time'],
        'paid_status' => $row['paid_status'],
    );

    $data[] = $item;
}





// Calculate sumtotal and sumbenefit for 'Paid' and 'Not Paid'
$sumTotalQueryPaid = "SELECT SUM(total_amount) AS sumtotal_paid, SUM(total_benefit) AS sumbenefit_paid FROM sales 
                     WHERE 
                     created_time >= '$start_date 00:00:00' 
                    AND created_time <= '$end_date 23:59:59' 
                    AND sales_point_id = $spt 
                     AND paid_status = 'Paid'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal_paid'];
$sumbenefitPaid = $sumRowPaid['sumbenefit_paid'];



// Create an array to hold the response data including sums
$responseData = array(
    'data' => $data,
    'sumtotalPaid' => $sumtotalPaid,
    'sumbenefitPaid' => $sumbenefitPaid,
    
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
