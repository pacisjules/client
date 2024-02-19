<?php
// Include the database connection file
require_once '../connection.php';

// Set master path
$masterHome = "/functions/inventory/getproductsandinventoryspt.php";
header('Content-Type: application/json');


$comID = $_GET['company'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT INVE.id, INVE.quantity, INVE.alert_quantity, INVE.last_updated, PRO.status, PRO.sales_point_id, PRO.name, PRO.price, PRO.benefit,PRO.description, PRO.id AS product_id FROM inventory INVE INNER JOIN products PRO ON INVE.product_id = PRO.id WHERE PRO.company_ID = $comID AND PRO.sales_point_id = $spt GROUP BY PRO.id ORDER BY INVE.last_updated DESC;";


$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$data = array();
while ($row = $result->fetch_assoc()) {
    $item = array(
        'name' => $row['name'],
        'quantity' => $row['quantity'],
        'alert_quantity' => $row['alert_quantity'],
        'last_updated' => $row['last_updated'],
        'description' => $row['description'],
        'price' => $row['price'],
        'benefit' => $row['benefit'],
    );

    $data[] = $item;
}

// Convert data to JSON
$jsonData = json_encode($data);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
