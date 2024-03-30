<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];
$name = $_GET['name'];

// Validate and sanitize user input
$comID = intval($comID); // Ensure it's an integer
$spt = intval($spt); // Ensure it's an integer
$name = mysqli_real_escape_string($conn, $name); // Sanitize input

$sql = "SELECT INVE.id,(SELECT `abbreviation` FROM `unittype` WHERE unit_id=INVE.unit_id) AS unit,INVE.container,INVE.item_per_container,INVE.quantity, INVE.alert_quantity, INVE.last_updated, PRO.status, PRO.sales_point_id, PRO.name, PRO.description, PRO.id AS product_id FROM inventory INVE INNER JOIN products PRO ON INVE.product_id = PRO.id
        WHERE PRO.company_ID = $comID AND PRO.sales_point_id = $spt
        AND PRO.name LIKE '%$name%'
        
        GROUP BY PRO.id ";

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Handle database query error here
    die('Database query error: ' . mysqli_error($conn));
}

$data = array();

while ($row = $result->fetch_assoc()) {
    // Perform necessary HTML escaping for output
    $row['name'] = htmlspecialchars($row['name']);
    $row['description'] = htmlspecialchars($row['description']);
    
    $data[] = $row;
}

// Send the data as JSON response
echo json_encode($data);
