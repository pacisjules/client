<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
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

   
    
    // Insert the user data into the database
    $sql = "INSERT INTO companies (name, address, city, state, zip_code, country, phone,email,website)
    VALUES ('$name', '$address', '$city','$state','$zip_code','$country','$phone', '$email','$website')";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Company created successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}