<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$company = $_GET['company'];
$spt = $_GET['spt'];
$product_id = $_GET['product_id'];


// Retrieve all users from the database
$sql = "SELECT PU.id,
               PU.supplier_id, SU.names,SU.phone,
               PU.product_id,PD.name,
               (SELECT unitname FROM unittype WHERE unit_id =PU.unit_id) AS unit,
               PU.container,
               PU.quantity,PU.price_per_unity,PU.total_price, 
               PU.purchase_date, 
               PU.user_id,
               (SELECT SUM(total_price) AS total FROM purchase WHERE company_ID = $company AND spt_id=$spt AND product_id=$product_id ) AS totalpurchase
       FROM purchase PU,
            supplier SU,
            products PD
       WHERE PU.company_ID = $company AND PU.spt_id =$spt
       AND PU.product_id=$product_id AND SU.supplier_id=PU.supplier_id AND PD.id=PU.product_id
        ORDER BY `purchase_date` DESC
        ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {

     $item = array(
        'id'=> $row['id'],
        'supplier_id' => $row['supplier_id'],
        'names' => $row['names'],
        'phone' => $row['phone'],
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'unit' => $row['unit'],
        'container' => $row['container'],
        'quantity' => $row['quantity'],
        'price_per_unity' => $row['price_per_unity'],
        'total_price' => $row['total_price'],
        'totalpurchase' => $row['totalpurchase'],
        'purchase_date' => $row['purchase_date'],
        'user_id' => $row['user_id'],
       
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
