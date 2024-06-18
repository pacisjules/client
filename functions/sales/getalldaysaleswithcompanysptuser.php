<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$date = $_GET['date'];
$spt = $_GET['spt'];
$user_id = $_GET['user_id'];




$sql = "
SELECT 
  COALESCE(SUM(SL.total_amount),0) AS TOTAL
FROM
    sales SL
WHERE
    SL.created_time LIKE '$date %'  AND SL.sales_point_id = $spt AND SL.user_id=$user_id

    ";


$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
   

    $value .= '

        <tr>

        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 18px;color:green;">TOTAL SALES OF THIS USER</td>
        <td style="font-size: 18px;color:red; font-weight:bold;"> FRW '.number_format($row['TOTAL']).'</td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>

    
        </tr>

        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
