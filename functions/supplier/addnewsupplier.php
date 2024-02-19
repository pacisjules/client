<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $names  = $_POST['names'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $company_ID = $_POST['company'];

  // Insert the  products
  $sql = "INSERT INTO supplier (names, phone, address,company_ID)
  VALUES ('$names', '$phone','$address','$company_ID')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Supplier Inventory successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
