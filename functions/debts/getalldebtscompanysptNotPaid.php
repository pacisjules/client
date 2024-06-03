<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT DISTINCT
CU.names,
CU.phone,
CU.address,
DE.created_date,
DE.status,
DE.customer_id,
(SELECT SUM(amount - amount_paid) FROM debts WHERE customer_id = DE.customer_id AND sales_point_id= $spt GROUP BY DE.customer_id ) AS Amount


FROM
debts DE
JOIN
customer CU ON DE.customer_id = CU.customer_id
WHERE
DE.sales_point_id = $spt
GROUP BY DE.customer_id 
ORDER BY DE.created_date DESC ";

$value = "";
$result = mysqli_query($conn, $sql);

$num = 0;
$tot = 0;
// Convert the results to an array of objects
$data = array();
while ($row = $result->fetch_assoc()) {

    if($row['Amount']>0){
        $new = $row['Amount'];
        $tot += $new;
      }



    
   $item = array(
        'names' => $row['names'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'total_amount' => $row['Amount'],
        'created_date' => $row['created_date'],
    );

    $data[] = $item;
 
}


$response = array(
    'debts' => $data,
    'total_debt' => $tot,
);

// Convert data to JSON
$jsonData = json_encode($response);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;

?>
