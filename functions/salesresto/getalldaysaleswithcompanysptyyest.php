<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date = $_GET['date'];
$comID = $_GET['company'];
$spt = $_GET['spt'];



// SQL query to fetch daily sales records
$sql = "
    SELECT DISTINCT
        SL.sales_id,
        SL.sess_id,
        PD.name AS Product_Name,
        SP.manager_name,
        SP.phone_number,
        SP.location,
        SL.product_id,
        SL.quantity,
        SL.sales_price,
        SL.total_amount,
        SL.paid_status,
        SL.created_time,
        SL.sales_type
    FROM
        sales SL
    JOIN products PD ON
        SL.product_id = PD.id
    JOIN salespoint SP ON
        SL.sales_point_id = SP.sales_point_id
    WHERE
        SL.created_time LIKE '$date%'
        AND SP.company_ID = $comID
        AND SL.sales_point_id = $spt
    GROUP BY
        SL.sales_id
   ";

$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();



while ($row = $result->fetch_assoc()) {
    
    $tprice = $row['total_amount'];
    $qty = $row['quantity'];
    $pic = $tprice/$qty;

 
    
    
    $item = array(
       'sale_id' => $row['sales_id'],
        'sess_id' => $row['sess_id'],
        'product_id' => $row['product_id'],
        'Product_Name' => $row['Product_Name'],
        'sales_price' => $pic,
        'quantity' => $row['quantity'],
        'total_amount' => $row['total_amount'],
        'paid_status' => $row['paid_status'],
        'created_time' => $row['created_time'],
    );

    $data[] = $item;
}

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT SUM(total_amount) AS sumtotal, SUM(total_benefit) AS sumbenefit FROM sales 
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

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>