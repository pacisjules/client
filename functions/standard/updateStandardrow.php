<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $stand_id= $_POST["stand_id"];
    $quantity = $_POST['quantity'];

    // Update the employee data into the database
    $sql = "UPDATE standardrowmaterial SET quantity = '$quantity' WHERE stand_id=$stand_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "standard row Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
