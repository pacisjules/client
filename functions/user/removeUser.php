<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST["user_id"];

    // Delete Employee all information
    $sql = "DELETE FROM users WHERE id='$user_id'";
    $sqlemp = "DELETE FROM employee WHERE user_id='$user_id'";

    if ($conn->query($sql) === TRUE && $conn->query($sqlemp) === TRUE ) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "User Deleted successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}