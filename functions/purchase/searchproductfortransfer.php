<?php 

require_once '../connection.php';

$key = $_POST['key'];
$spt = $_POST['spt'];

// Updated SQL query to join `products` and `inventory` tables
$sql = "
    SELECT 
        products.id, 
        products.name, 
        inventory.quantity 
    FROM 
        products 
    LEFT JOIN 
        inventory 
    ON 
        products.id = inventory.product_id 
    WHERE 
        products.name LIKE '%{$key}%' 
        AND products.sales_point_id = {$spt}
        AND inventory.quantity > 0
    ORDER BY 
        products.name DESC 
    LIMIT 5";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowNumber = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<a class="getter" href="javascript:void(0)" onclick="setProduct(' . $row['id'] . ', \'' . $row['name'] . '\', ' . $row['quantity'] . ')"  data-id="' . $row['id'] . '">'
             . $rowNumber . '. ' 
             . $row['name'] 
             . ' (Quantity: ' . $row['quantity'] . ')'
             . "</a><br><br>";
        $rowNumber++;
    }
} else {
    echo "0 results";
}

?>
