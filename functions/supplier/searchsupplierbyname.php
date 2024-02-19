<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$company_ID= $_GET['company'];
$name = $_GET['name'];

// Validate and sanitize user input
$comID = intval($comID); // Ensure it's an integer
$spt = intval($spt); // Ensure it's an integer
$name = mysqli_real_escape_string($conn, $name); // Sanitize input

$sql = "SELECT 
        CUST.supplier_id , 
        CUST.names,
        CUST.phone, 
        CUST.address,
        CUST.created_at
        FROM supplier CUST 
        WHERE CUST.company_ID = $company_ID
        AND CUST.names LIKE '%$name%'
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Handle database query error here
    die('Database query error: ' . mysqli_error($conn));
}

$data = array();

while ($row = $result->fetch_assoc()) {
    // Perform necessary HTML escaping for output
    $row['names'] = htmlspecialchars($row['names']);
    $row['address'] = htmlspecialchars($row['address']);
    
    $data[] = $row;
}

// Send the data as JSON response
echo json_encode($data);
