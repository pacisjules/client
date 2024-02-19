<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Retrieve the POST data
    $customer_id = $_POST['customer_id'];
    $carName = $_POST['carName'];
    $plateName = $_POST['plateName'];
    $cartype = $_POST['cartype'];
    $serviceSelect = $_POST['serviceSelect'];
    $spt = $_POST['spt'];

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO serviceRequest (customer_id, carName, platename, carType, servicesNeeded, spt, status) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";

    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssssss", $customer_id, $carName, $plateName, $cartype, $serviceSelect, $spt);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Request created successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
