<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters

$comID = $_GET['company'];
$spt = $_GET['spt'];




$sqlcompany = "SELECT * FROM companies WHERE id=$comID";
$resultCompany = $conn->query($sqlcompany);
$rowCompany = $resultCompany->fetch_assoc();


$newdate=$rowCompany['timezone_name'];
$righttime=date('Y-m-d', time());



// SQL query to fetch daily sales records
$sql = "
  
SELECT DISTINCT
        (ROW_NUMBER() OVER (ORDER BY PD.id)) as num,
        PD.name AS Product_Name,
        PD.id,
        (SELECT IFNULL(SUM(quantity),0.00) AS QTYTT 
         FROM sales 
         WHERE created_time LIKE '$righttime%' 
           AND product_id = PD.id 
           AND sales_point_id = $spt) AS QTYsale,
        (SELECT IFNULL(SUM(total_amount),0.00) AS total
         FROM sales 
         WHERE created_time LIKE '$righttime%' 
           AND product_id = PD.id 
           AND sales_point_id = $spt) AS productsale,
        (SELECT IFNULL(SUM(total_benefit),0.00) AS totalB 
         FROM sales 
         WHERE created_time LIKE '$righttime%' 
           AND product_id = PD.id 
           AND sales_point_id = $spt) AS productPROFIT,
          (SELECT IFNULL(SUM(total_price),0.00) AS totalPU 
         FROM purchase 
         WHERE purchase_date LIKE '$righttime%' 
           AND product_id = PD.id 
           AND spt_id = $spt) AS productPurchase, 
            (SELECT IFNULL(SUM(quantity),0.00) AS tTPUCH 
         FROM purchase 
         WHERE purchase_date LIKE '$righttime%' 
           AND product_id = PD.id 
           AND spt_id = $spt) AS QTYPurchase
       
FROM products PD
    WHERE
        PD.sales_point_id = $spt
    GROUP BY
       PD.id 


   ";

   $result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT IFNULL(SUM(total_amount),0) AS sumtotal, IFNULL(SUM(total_benefit),0) AS sumbenefit FROM sales 
                 WHERE created_time LIKE '$righttime%' AND sales_point_id = $spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];
$sumbenefit = $sumRow['sumbenefit'];


// Calculate sumtotal and sumbenefit for 'Paid' and 'Not Paid'
$sumTotalQueryPaid = "SELECT SUM(total_amount) AS sumtotal_paid, SUM(total_benefit) AS sumbenefit_paid FROM sales 
                     WHERE created_time LIKE '$righttime%' AND sales_point_id = $spt AND paid_status = 'Paid'";
$sumResultPaid = $conn->query($sumTotalQueryPaid);
$sumRowPaid = $sumResultPaid->fetch_assoc();
$sumtotalPaid = $sumRowPaid['sumtotal_paid'];
$sumbenefitPaid = $sumRowPaid['sumbenefit_paid'];


$sumTotalQueryNotPaid = "SELECT IFNULL(SUM(total_price), 0.00) AS sumtotal_purchase
                            FROM purchase
                            WHERE purchase_date LIKE '$righttime%' AND spt_id = $spt ";

$sumResultNotPaid = $conn->query($sumTotalQueryNotPaid);
$sumRowNotPaid = $sumResultNotPaid->fetch_assoc();
$sumtotal_purchase = $sumRowNotPaid['sumtotal_purchase'];







// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,
    'sumbenefit' => $sumbenefit,
    'sumtotal_purchase' => $sumtotal_purchase,
    
);

echo json_encode($responseData);

$conn->close();
?>