<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $set_id= $_POST["set_id"];
    $set_qty = $_POST['set_qty'];
    $set_name = $_POST['set_name'];

    // Update the employee data into the database
    $sql = "UPDATE product_standard SET product_name = '$set_name',quantity = '$set_qty' WHERE id=$set_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "standard Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
