<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $customer_id = $_POST["customer_id"];
    $spt = $_POST["spt"];

    // Get the form data
    $names = $_POST['names'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the employee data into the database
    $sql = "UPDATE customer SET names='$names', phone='$phone', address='$address'  
    WHERE customer_id=$customer_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Customer Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
