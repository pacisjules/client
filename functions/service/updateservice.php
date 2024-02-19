<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $service_id = $_POST["service_id"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Get the form data
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $service_type = $_POST['service_type'];
    $area_measure= $_POST['area_measure'];

    // Update the employee data into the database
    $sql = "UPDATE services SET service_name='$service_name', price='$price', description='$description', area_measure='$area_measure', service_type='$service_type'  
    WHERE id=$service_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Service Updated successfully.";

        //Set History
        AddHistory($UserID,"Service Updated ".$service_name,$salespt_id);

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
