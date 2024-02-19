<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $expiry_id = $_POST['expiry_id'];

    // Retrieve the POST data
    $expiry_date = $_POST['expiry_date'];
    $warning_hours = $_POST['warning_hours'];
    $disposal_method = $_POST['disposal_method'];
    $sales_point_id = $_POST['sales_point_id'];
    $expired_quantity = $_POST['expired_quantity'];

    // Update the employee data into the database
    $sql = "UPDATE expiredproducts SET 
    expiry_date='$expiry_date', 
    warning_hours='$warning_hours', 
    disposal_method='$disposal_method', 
    sales_point_id=$sales_point_id,
    expired_quantity = $expired_quantity

    WHERE expired_id=$expiry_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Expiry Updated successfully.";

        //Set History
        //AddHistory($UserID,"Update Product ".$name,$salespt_id);

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
