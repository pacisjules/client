<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$store_id = $_GET['store_id'];
$date = $_GET['date'];
$name=$_GET['name'];

// Retrieve all users from the database
$sql = "
SELECT DISTINCT
products.id AS product_id,
products.name AS product_name,
(SELECT COALESCE(SUM(purchase.container), 0) AS entry FROM purchase WHERE purchase.purchase_date LIKE '$date%' AND purchase.store_id =$store_id AND purchase.product_id=products.id) AS entry_stock,
(SELECT COALESCE(SUM(transferhistory.box_or_carton), 0) AS sold FROM transferhistory WHERE transferhistory.created_at LIKE '$date%' AND transferhistory.store_id =$store_id AND transferhistory.product_id= products.id) AS sold_stock,
storedetails.box_or_carton AS closing_stock
FROM

storedetails
JOIN products ON storedetails.product_id= products.id
LEFT JOIN transferhistory ON transferhistory.store_id=storedetails.store_id
LEFT JOIN purchase ON storedetails.store_id=purchase.store_id
WHERE storedetails.store_id=$store_id AND products.name LIKE '%$name%'
          
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $openingStock = 0;
    $totalStock = 0;
    $soldStock = $row['sold_stock'];
    $closing_stock = $row['closing_stock'];
    $entry_stock = $row['entry_stock'];
    
    
    
    if($row['entry_stock']===0){
      $openingStock = $soldStock + $closing_stock;  
      $totalStock = $soldStock + $closing_stock;
    }else{
       $openingStock = ($soldStock + $closing_stock) - $entry_stock; 
       $totalStock = $openingStock + $entry_stock;
    }
    




    $num+=1;

    $value .= '
    <tr>
    <td>'.$num.'. ' . $row['product_name'] . '</td>
    <td>' . $openingStock . '</td>
    <td>' . $row['entry_stock'] . '</td>
    <td>' . $totalStock . '</td>
    <td>' . $row['sold_stock'] . '</td>
    <td>' . $row['closing_stock'] . '</td>
    
</tr>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
