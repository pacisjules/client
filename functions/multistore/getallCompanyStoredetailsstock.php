<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$store_id = $_GET['store_id'];


// Retrieve all users from the database
$sql = "SELECT SD.detail_id,
               ST.store_id, ST.storename,ST.phone,ST.address,ST.storekeeper,
               SD.product_id,PD.name,
               SD.unit_id,
               (SELECT abbreviation FROM unittype WHERE unit_id =SD.unit_id) AS unit,
               SD.box_or_carton,
               SD.quantity_per_box, 
               SD.created_at, 
               SD.user_id
       FROM storedetails SD,
            store ST,
            products PD
       WHERE SD.company_ID = $comID
       AND SD.store_id= $store_id AND ST.store_id=SD.store_id AND PD.id=SD.product_id
        ORDER BY `created_at` DESC
        ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {
    
    $box = $row['box_or_carton'];
    $qtyper = $row['quantity_per_box'];
    
    $totalitem = $box * $qtyper;  

     $item = array(
        'detail_id'=> $row['detail_id'],
        'store_id' => $row['store_id'],
        'storename' => $row['storename'],
        'storekeeper' => $row['storekeeper'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'name' => $row['name'],
        'product_id' => $row['product_id'],
        'unit' => $row['unit'],
        'box_or_carton' => $row['box_or_carton'],
        'quantity' => $row['quantity_per_box'],
        'totalitem' => $totalitem,
        'created_at' => $row['created_at'],
        'user_id' => $row['user_id'],
        'unit_id' => $row['unit_id'],
       
    );

    $data[] = $item;
}


$responseData = array(
    'data' => $data,
);
// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
