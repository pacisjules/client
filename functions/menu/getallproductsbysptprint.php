<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];

// Retrieve all users from the database
$sql = "SELECT  PD.id, PD.name, PD.price, PD.benefit, PD.status, PD.description,PD.created_at ,IFNULL(INV.quantity, 0) AS invquantity
        FROM products PD
        LEFT JOIN inventory INV ON PD.id = INV.product_id
        WHERE PD.company_ID = $comID
        AND PD.sales_point_id = $spt
        ORDER BY PD.created_at DESC
        ";


$result = mysqli_query($conn, $sql);



// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {

    
    
    $item = array(
        'name' => $row['name'],
        'price' => $row['price'],
        'benefit' => $row['benefit'],
        'invquantity' => $row['invquantity'],
        'status' => $row['price'],
        'created_at' => $row['created_at'],
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
