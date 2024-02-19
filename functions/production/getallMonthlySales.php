<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');


//Get all sales by date

$comID = $_GET['company'];
$spt = $_GET['spt'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Last day of the current month

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
    SL.created_time >= '$startDate 00:00:00'
    AND SL.created_time <= '$endDate 23:59:59'
    AND SP.company_ID = $comID
    AND SL.sales_point_id = $spt
GROUP BY
    SL.sales_id
ORDER BY
    SL.created_time DESC";

$result = $conn->query($sql);

// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {
    // ... Your existing code to process each row ...

    // Create an object to represent each row of data
    $item = array(
        'Product_Name' => $row['Product_Name'],
        'sales_price' => $row['sales_price'],
        'quantity' => $row['quantity'],
        'total_amount' => $row['total_amount'],
        'total_benefit' => $row['total_benefit'],
        'created_time' => $row['created_time'],
        'paid_status' => $row['paid_status'],
        // Add other fields as needed
    );

    // Add the item to the data array
    $data[] = $item;
}


$sumTotalQuery = "SELECT SUM(total_amount) AS sumtotal, SUM(total_benefit) AS sumbenefit FROM sales 
                 WHERE created_time >= '$startDate 00:00:00' AND created_time <= '$endDate 23:59:59'
                 AND sales_point_id = $spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];
$sumbenefit = $sumRow['sumbenefit'];


// Calculate sumtotal and sumbenefit for 'Paid' and 'Not Paid'
$sumTotalQueryPaid = "SELECT SUM(total_amount) AS sumtotal_paid, SUM(total_benefit) AS sumbenefit_paid FROM sales 
                     WHERE 
                     created_time >= '$startDate 00:00:00' 
                    AND created_time <= '$endDate 23:59:59' 
                    AND sales_point_id = $spt 
                     AND paid_status = 'Paid'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal_paid'];
$sumbenefitPaid = $sumRowPaid['sumbenefit_paid'];

$sumTotalQueryNotPaid = "SELECT IFNULL(SUM(total_amount),0.00) AS sumtotal_not_paid, SUM(total_benefit) AS sumbenefit_not_paid FROM sales 
                        WHERE 
                        created_time >= '$startDate 00:00:00' 
                        AND created_time <= '$endDate 23:59:59' 
                        AND sales_point_id = $spt
                        AND paid_status = 'Not Paid'";
$sumResultNotPaid = $conn->query($sumTotalQueryNotPaid);
$sumRowNotPaid = $sumResultNotPaid->fetch_assoc();
$sumtotalNotPaid = $sumRowNotPaid['sumtotal_not_paid'];
$sumbenefitNotPaid = $sumRowNotPaid['sumbenefit_not_paid'];


$sumTotalexpenses = "SELECT IFNULL(SUM(amount), 0.00) AS sumtotalexpenses FROM shop_expenses 
                        WHERE 
                        created_date >= '$startDate 00:00:00' 
                        AND created_date <= '$endDate 23:59:59' 
                        AND sales_point_id = $spt
                       ";
$sumResultexpenses = $conn->query($sumTotalexpenses);
$sumRowexpenses = $sumResultexpenses->fetch_assoc();
$sumtotalexpenses = $sumRowexpenses['sumtotalexpenses'];

// Create an array to hold the response data
$responseData = array(
    'data' => $data, // Your existing data
    'sumtotal' => $sumtotal,
    'sumbenefit' => $sumbenefit,
    'sumtotalPaid' => $sumtotalPaid,
    'sumbenefitPaid' => $sumbenefitPaid,
    'sumtotalNotPaid' => $sumtotalNotPaid,
    'sumbenefitNotPaid' => $sumbenefitNotPaid,
    'sumtotalexpenses' => $sumtotalexpenses,
);

// Convert data to JSON
$jsonData = json_encode($responseData);


// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
