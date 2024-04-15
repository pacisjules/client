<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $production_id= $_POST["production_id"];
    $approvedby = $_POST['approvedby'];


    // Update the employee data into the database
    $sql = "UPDATE finishedproduct SET approved_by = '$approvedby',status=3 WHERE id=$production_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "production  rejected successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
