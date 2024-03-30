<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $permid = $_POST["permid"];
    $namepermi = $_POST["namepermi"];
    $cat_id = $_POST['cat_id'];
    $page_id = $_POST['page_id'];


    // Update the employee data into the database
    $sql = "UPDATE permissions SET name='$namepermi',cat_id='$cat_id', page_id='$page_id'
    WHERE perm_id =$permid";


 

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Permission Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
