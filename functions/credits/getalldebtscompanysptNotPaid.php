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
DE.due_date,
DE.status,
DE.supplier_id,
(SELECT SUM(amount - amount_paid) FROM credits WHERE supplier_id = DE.supplier_id AND sales_point_id= $spt GROUP BY DE.supplier_id ) AS Amount


FROM
credits DE
JOIN
supplier CU ON DE.supplier_id = CU.supplier_id
WHERE
DE.sales_point_id = $spt
GROUP BY DE.supplier_id";

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
        'due_date' => $row['due_date'],
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
