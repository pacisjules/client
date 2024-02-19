<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $supplier_id = $_POST["supplier_id"];
    $company_ID = $_POST["company"];

    // Get the form data
    $names = $_POST['names'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the employee data into the database
    $sql = "UPDATE supplier SET names='$names', phone='$phone', address='$address'  
    WHERE supplier_id=$supplier_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Supplier Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
