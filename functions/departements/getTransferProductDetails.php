<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$store_id = $_GET['store_id'];
$product_id = $_GET['product_id'];


// Retrieve all users from the database
$sql = "SELECT 
    TR.id,
    TR.unit_id,
    TR.box_or_carton,
    TR.quantity_per_box,
    TR.created_at,
    US.username,
    PD.name,
    TR.product_id
    
FROM transferHistory TR ,users US,products PD WHERE TR.user_id=US.id AND TR.product_id=PD.id AND TR.store_id=$store_id AND TR.product_id=$product_id ORDER BY TR.created_at DESC ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {

     $item = array(
        'id'=> $row['id'],
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'unit_id' => $row['unit_id'],
        'box_or_carton' => $row['box_or_carton'],
        'quantity_per_box' => $row['quantity_per_box'],
        'created_at' => $row['created_at'],
        'username' => $row['username'],
       
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
