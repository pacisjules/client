<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$date = $_GET['date'];     
$spt = $_GET['spt'];





$sql = "
SELECT DISTINCT
    FI.id,
    PD.name AS Product_Name,
    FI.quantity,
    FI.created_at,
    FI.user_id,
    FI.session_id,
    FI.product_id,
    FI.status,
    (SELECT CONCAT(first_name, ' ', last_name) AS names FROM employee WHERE user_id = FI.user_id) AS usernames
FROM
    FinishedProduct FI
JOIN products PD ON
    FI.product_id = PD.id
WHERE
    FI.created_at LIKE '$date %' AND 
    FI.spt = $spt AND FI.status=2
ORDER BY
    FI.created_at DESC
";



$result = $conn->query($sql);


$data = array();


$num = 0;
while ($row = $result->fetch_assoc()) {
    
      $sts="";
    $style="";
    

    if($row['status']==1){
        $sts="Pending";
        
    }else{
        $sts="Stocked";
    }
    
    $item = array(
        'id' => $row['id'],
        'session_id' => $row['session_id'],
        'product_id' => $row['product_id'],
        'Product_Name' => $row['Product_Name'],
        'quantity' => $row['quantity'],
        'usernames' => $row['usernames'],
        'created_at' => $row['created_at'],
        'statuss' => $sts,
    );

    $data[] = $item;
   
}



$responseData = array(
    'data' => $data,

    
);

$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>