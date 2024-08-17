<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the date, company ID, and sales point ID from the query parameters
$startdate = $_GET['startdate'];
$enddate = $_GET['enddate'];
$spt = $_GET['spt'];

// SQL query to fetch daily sales records
$sql = "  
 SELECT 
ROW_NUMBER() OVER (ORDER BY id) as num,
`product_id`, `product_name`, `open`, `entry`, `total`, `sold`, `unit_price`, `total_amount`, `closing`, `spt`, `startshift`, `endshift`, `shiftsession`, `created_at`
  FROM `shiftreport` WHERE spt=$spt 
 and startshift='$startdate%' and endshift ='$enddate%'
";

$result = $conn->query($sql);

// Calculate sumtotal and sumbenefit
$sumTotalQuery = "SELECT SUM(total_amount) AS sumtotal FROM sales 
                 WHERE created_time >=  '$startdate%' AND created_time <= '$enddate%' AND sales_point_id =$spt";
$sumResult = $conn->query($sumTotalQuery);
$sumRow = $sumResult->fetch_assoc();
$sumtotal = $sumRow['sumtotal'];

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = array(
    "data" => $data,
    "total" => $sumtotal
);

echo json_encode($response);

$conn->close();

// $result = $conn->query($sql);

// // Initialize an array to store the data
// $data = array();



// while ($row = $result->fetch_assoc()) {
//     $openingStock = 0;
//     $totalStock = 0;
//     $soldStock = $row['sold_stock'];
//     $unit_price = $row['unit_price'];
//     $totalprice = $unit_price * $soldStock;
//     $closing_stock = $row['closing_stock'];
//     $entry_stock = $row['entry_stock'];
    
    
    
//     if($row['entry_stock']===0){
//       $openingStock = $soldStock + $closing_stock;  
//       $totalStock = $soldStock + $closing_stock;
//     }else{
//        $openingStock = ($soldStock + $closing_stock) - $entry_stock; 
//        $totalStock = $openingStock + $entry_stock;
//     }
    
//     $item = array(
//         'product_id' => $row['product_id'],
//         'product_name' => $row['product_name'],
//         'opening_stock' => $openingStock,
//         'entry_stock' => $row['entry_stock'],
//         'totalstock' =>  $totalStock,
//         'sold_stock' => $row['sold_stock'],
//         'unit_price' => $row['unit_price'],
//         'totalprice' => $totalprice,
//         'closing_stock' => $row['closing_stock'],
//         'created_time' => $row['created_time'],
//     );

//     $data[] = $item;
// }





// // Create an array to hold the response data
// $responseData = array(
//     'data' => $data,
//     'sumtotal' => $sumtotal,
    
// );

// // Convert data to JSON
// $jsonData = json_encode($responseData);

// // Set the response header to indicate JSON content
// header('Content-Type: application/json');

// // Send the JSON response
// echo $jsonData;
?>

