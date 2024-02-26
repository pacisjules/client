<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$date= $_GET['date'];
$spt = $_GET['spt'];
$name=$_GET['name'];

// Retrieve all users from the database
$sql = "
SELECT DISTINCT
    products.id AS product_id,
    products.name AS product_name,
    (SELECT COALESCE(SUM(purchase.quantity * purchase.container), 0) AS entry FROM purchase WHERE purchase.product_id=products.id AND purchase.purchase_date LIKE '$date%' AND purchase.spt_id=$spt) AS entry_stock,
    (SELECT COALESCE(SUM(sales.quantity), 0) AS sold FROM sales WHERE sales.product_id=products.id AND sales.created_time LIKE '$date%' AND sales.sales_point_id=$spt) AS sold_stock,
    sales.sales_price AS unit_price,
    inventory.quantity AS closing_stock,
    sales.created_time
FROM
    products
JOIN
    inventory ON products.id = inventory.product_id
JOIN
    sales ON products.id = sales.product_id
LEFT JOIN
    purchase ON products.id = purchase.product_id
WHERE 
     products.sales_point_id=$spt AND products.name LIKE '%$name%'
       
GROUP BY
    products.id,inventory.product_id, sales.product_id;     
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
    $unit_price = $row['unit_price'];
    $totalprice = $unit_price * $soldStock;
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
    <td>' . $row['unit_price'] . '</td>
    <td>' . $totalprice . '</td>
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
