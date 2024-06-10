<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sess_id= $_POST["sess_id"];

    // Get the form data
    $status = $_POST['status'];
    // Update the employee data into the database
    $sql = "UPDATE requisition SET status='$status' 
    WHERE sess_id='$sess_id'";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "requisition approved successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
