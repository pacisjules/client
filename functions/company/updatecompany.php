<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $company_id = $_POST["company_id"];

    // Retrieve the POST data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $website = $_POST['website'];


    // Update the employee data into the database
    $sql = "UPDATE companies SET

    name ='$name',
    address ='$address',
    city ='$city',
    state ='$state',
    zip_code ='$zip_code',
    country ='$country',
    phone ='$phone',
    email ='$email',
    website ='$website'

    WHERE id='$company_id'";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Company Updated successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
