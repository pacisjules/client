<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $set_id = $_POST['set_id'];

    // Insert the  product_category
    $sql = "DELETE FROM product_standard WHERE id = $set_id";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Product Standard deleted successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
