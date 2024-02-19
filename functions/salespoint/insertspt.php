<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Get the form data
    $manager_name = $_POST['manager_name'];
    $location = $_POST['location'];
    $phone_number = $_POST['phone_number'];
    $company_ID = $_POST['company_ID'];
    $email = $_POST['email'];


    // Insert the  sales point
    $sql = "INSERT INTO salespoint (manager_name, location,phone_number,company_ID, email) VALUES ('$manager_name', '$location', '$phone_number', '$company_ID','$email')";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Sales Point created successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}