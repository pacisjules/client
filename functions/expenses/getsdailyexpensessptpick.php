<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$date= $_GET['date'];
$spt = $_GET['spt'];



// SQL query to fetch daily sales records
$sql = "
  
  SELECT
    ROW_NUMBER() OVER (ORDER BY SE.id) as num,
        SE.id,
        SE.name,
        SE.description,
        SE.amount,
        SE.payment,
        SE.dependon,
         (SELECT location FROM salespoint WHERE sales_point_id  = SE.sales_point_id) AS salespoint,
        (SELECT name FROM expenses_type WHERE id = SE.exp_type) AS expense_name,
        (SELECT username FROM users WHERE id  = SE.user_id) AS doneby,
        SE.created_date
       
        

        

    FROM
        shop_expenses SE
    WHERE 
        SE.sales_point_id = $spt AND SE.created_date LIKE '$date%'
    ORDER BY
        SE.id DESC 

   ";

   $result = $conn->query($sql);

// Initialize an array to store the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT IFNULL(SUM(amount),0) AS sumtotal FROM shop_expenses 
                 WHERE created_date LIKE '$date%' AND sales_point_id = $spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];







// Create an array to hold the response data
$responseData = array(
    'data' => $data,
    'sumtotal' => $sumtotal,

    
);

echo json_encode($responseData);

$conn->close();
?>