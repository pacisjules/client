<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sales_point_id = $_POST["sales_point_id"];

    // Retrieve the POST data
    $manager_name = $_POST['manager_name'];
    $location = $_POST['location'];
    $phone_number = $_POST['phone_number'];
    $company_ID = $_POST['company_ID'];
    $email = $_POST['email'];

    // Update the employee data into the database
    $sql = "UPDATE salespoint SET 

    location='$location', 
    manager_name='$manager_name', 
    phone_number='$phone_number', 
    email='$email', 
    company_ID=$company_ID

    WHERE sales_point_id=$sales_point_id";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Sales Point Updated successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
