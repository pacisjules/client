<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $cat_id = $_POST["cat_id"];
    $category_name = $_POST["category_name"];
    $status = $_POST['status'];


    // Update the employee data into the database
    $sql = "UPDATE users_category SET category_name='$category_name',status='$status'
    WHERE cat_id =$cat_id";


 

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "USER CATEGORY Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
