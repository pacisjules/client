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
        SL.created_time LIKE '$date%'
        AND SP.company_ID = $comID
        AND SL.sales_point_id = $spt
        AND SL.paid_status = 'Not Paid'
    GROUP BY
        SL.sales_id
    ORDER BY
        SL.created_time DESC";

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
        'total_benefit' => $row['total_benefit'],
        'created_time' => $row['created_time'],
        'paid_status' => $row['paid_status'],
    );

    $data[] = $item;
}

// Calculate sumtotal and sumbenefit


$sumTotalQueryNotPaid = "SELECT IFNULL(SUM(total_amount), 0.00) AS sumtotal_not_paid, SUM(total_benefit) AS sumbenefit_not_paid
                            FROM sales
                            WHERE created_time LIKE '$date%' AND sales_point_id = $spt AND paid_status = 'Not Paid'";
$sumResultNotPaid = $conn->query($sumTotalQueryNotPaid);
$sumRowNotPaid = $sumResultNotPaid->fetch_assoc();
$sumtotalNotPaid = $sumRowNotPaid['sumtotal_not_paid'];
$sumbenefitNotPaid = $sumRowNotPaid['sumbenefit_not_paid'];


// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotalNotPaid' => $sumtotalNotPaid,
    'sumbenefitNotPaid' => $sumbenefitNotPaid,
    
);

// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>
