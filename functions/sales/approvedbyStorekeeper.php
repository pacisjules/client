<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $s_id = $_POST['s_id'];
    $storeapproval = $_POST['storeapproval'];


    // Update the employee data into the database
    $sql = "UPDATE sales SET 
    storekeeperaproval=1 
    
    WHERE sales_id =$s_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Store keeper appreoved successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
