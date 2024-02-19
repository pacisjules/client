<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];
$names = $_GET['names'];

// Validate and sanitize user input
$comID = intval($comID); // Ensure it's an integer
$spt = intval($spt); // Ensure it's an integer
$names = mysqli_real_escape_string($conn, $names); // Sanitize input

$sql = "SELECT DISTINCT * FROM debtscustomer WHERE spt_id=$spt AND names LIKE '%$names%'";


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
