<?php
// Include the database connection file
require_once '../connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
  
    // Retrieve the POST data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $company_name = $_POST['company_name'];
    $company_ID=$_POST['company_ID'];
    $userType=$_POST['userType']; 
    $salepoint_id=$_POST['salepoint_id'];
    
    // Insert the user data into the database
    $sql = "INSERT INTO users (username, email, password, company_name, company_ID, userType, salepoint_id) VALUES ('$username', '$email', '$password','$company_name','$company_ID','$userType','$salepoint_id')";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "User created successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
