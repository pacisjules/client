<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date= $_GET['date'];
$comID = $_GET['company'];
$spt = $_GET['spt'];



// SQL query to fetch daily sales records
$sql = "
  
SELECT DISTINCT
        ROW_NUMBER() OVER (ORDER BY SL.product_id) as num,
        PD.name AS Product_Name,
        SL.product_id,
        (SELECT sum(quantity) 
         FROM sales 
         WHERE created_time LIKE '$date%' 
           AND product_id = SL.product_id 
           AND sales_point_id = $spt) AS QTYsale,
        (SELECT sum(total_amount) 
         FROM sales 
         WHERE created_time LIKE '$date%' 
           AND product_id = SL.product_id 
           AND sales_point_id = $spt) AS productsale,
        (SELECT sum(total_benefit) 
         FROM sales 
         WHERE created_time LIKE '$date%' 
           AND product_id = SL.product_id 
           AND sales_point_id = $spt) AS productPROFIT,
        SL.created_time
FROM
        sales SL
JOIN products PD ON
        SL.product_id = PD.id
    WHERE
        SL.created_time LIKE '$date%'
        AND SL.sales_point_id = $spt
    GROUP BY
        SL.product_id
   ";

   $result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT IFNULL(SUM(total_amount),0) AS sumtotal, IFNULL(SUM(total_benefit),0) AS sumbenefit FROM sales 
                 WHERE created_time LIKE '$date%' AND sales_point_id = $spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];
$sumbenefit = $sumRow['sumbenefit'];


// Calculate sumtotal and sumbenefit for 'Paid' and 'Not Paid'
$sumTotalQueryPaid = "SELECT SUM(total_amount) AS sumtotal_paid, SUM(total_benefit) AS sumbenefit_paid FROM sales 
                     WHERE created_time LIKE '$date%' AND sales_point_id = $spt AND paid_status = 'Paid'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal_paid'];
$sumbenefitPaid = $sumRowPaid['sumbenefit_paid'];


$sumTotalQueryNotPaid = "SELECT IFNULL(SUM(total_amount), 0.00) AS sumtotal_not_paid, SUM(total_benefit) AS sumbenefit_not_paid
                            FROM sales
                            WHERE created_time LIKE '$date%' AND sales_point_id = $spt AND paid_status = 'Not Paid'";
$sumResultNotPaid = $conn->query($sumTotalQueryNotPaid);
$sumRowNotPaid = $sumResultNotPaid->fetch_assoc();
$sumtotalNotPaid = $sumRowNotPaid['sumtotal_not_paid'];
$sumbenefitNotPaid = $sumRowNotPaid['sumbenefit_not_paid'];

$sumTotalExpenses = "SELECT IFNULL(SUM(amount), 0.00) AS sumtotalexpenses FROM shop_expenses 
                        WHERE created_date LIKE '$date%' AND sales_point_id = $spt";
$sumResultexpe = $conn->query($sumTotalExpenses);
$sumRowexpe = $sumResultexpe->fetch_assoc();
$sumtotalexpenses = $sumRowexpe['sumtotalexpenses'];




// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,
    'sumbenefit' => $sumbenefit,
    'sumtotalPaid' => $sumtotalPaid,
    'sumbenefitPaid' => $sumbenefitPaid,
    'sumtotalNotPaid' => $sumtotalNotPaid,
    'sumbenefitNotPaid' => $sumbenefitNotPaid,
    'sumtotalexpenses' => $sumtotalexpenses,
    
);

echo json_encode($responseData);

$conn->close();
?>