<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];
$name = $_GET['names'];

// Validate and sanitize user input
// Ensure it's an integer
$spt = intval($spt); // Ensure it's an integer
$name = mysqli_real_escape_string($conn, $name); // Sanitize input

$sql = "SELECT 
        CUST.supplier_id , 
        CUST.names,
        CUST.phone, 
        CUST.address,
        CUST.created_at
        FROM supplier CUST 
        WHERE CUST.spt = $spt
        AND CUST.names LIKE '%$name%'
";

$result = mysqli_query($conn, $sql);
$value = "";
$num = 0;

while ($row = $result->fetch_assoc()) {
     $num+=1;
    $value .= '
            <p style="margin-bottom: 0px; cursor:pointer;" class="hover-effect" onclick="getSelectedSupplier(`' . $row['supplier_id'] . '`,`' . $row['names'] . '`,`' . $row['phone'] . '`,`' . $row['address'] . '`)">   ' . $num . '.  ' . $row['names'] . '</p>
            ';
    
    
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
