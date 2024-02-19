<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');


$date = $_GET['date'];
$company = $_GET['company'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT TH.id, 
       TH.store_id, 
       TH.product_id, 
       TH.quantity, 
       TH.company_ID, 
       TH.spt_id, 
       TH.user_id, 
       TH.created_at, 
       ST.storename, 
       PR.name AS product_name, 
       SP.location AS sales_point_location,
       CONCAT(E.first_name, ' ', E.last_name) AS full_name
FROM transferHistory TH
JOIN store ST ON TH.store_id = ST.store_id
JOIN products PR ON TH.product_id = PR.id
JOIN salespoint SP ON TH.spt_id = SP.sales_point_id
JOIN employee E ON TH.user_id = E.user_id
      WHERE TH.created_at LIKE '$date%' AND 
      TH.company_ID= $company";


$result = mysqli_query($conn, $sql);



// Convert the results to an array of objects
$data = array();


while ($row = $result->fetch_assoc()) {

    
    
    $item = array(
        'product_name' => $row['product_name'],
        'storename' => $row['storename'],
        'sales_point_location' => $row['sales_point_location'],
        'quantity' => $row['quantity'],
        'full_name' => $row['full_name'],
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

?>
