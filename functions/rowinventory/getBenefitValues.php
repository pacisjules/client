<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');


    $comID = $_GET['company'];
    $spt = $_GET['spt'];

        // Retrieve all users from the database
        $sql = "SELECT
    SUM(PD.benefit * INVE.quantity) as Total_Benefit_Stock
FROM
    products PD,
    inventory INVE
WHERE
    PD.id=INVE.product_id AND
    PD.company_ID = $comID AND PD.sales_point_id = $spt AND
    PD.status=1";

$result = $conn->query($sql);

// Fetch the total selling stock value
$row = $result->fetch_assoc();
$totalSellingStock ='RWF '. number_format($row['Total_Benefit_Stock']);

// Set the response header to indicate plain text
header('Content-Type: text/plain');

// Send the total selling stock value as plain text response
echo $totalSellingStock;
?>
