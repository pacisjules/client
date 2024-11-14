<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $storename = $_POST['storename'];
  $storekeeper = $_POST['storekeeper'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $company_ID = $_POST['company_ID'];



  // Insert the  products
  $sql = "INSERT INTO `store` (`storename`, `storekeeper`, `phone`, `address`,`company_ID`)
  VALUES ('$storename', '$storekeeper','$phone', '$address','$company_ID')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Store created successfully.";
     
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
