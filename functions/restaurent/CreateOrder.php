<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $place_name = $_POST['place_name'];
  $status = $_POST['status'];

  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];
  
  // Insert the  products
  $sql = "INSERT INTO orders (place_name,company_ID,sales_point_id,status)
  VALUES ('$place_name', '$company_ID', '$sales_id', '$status')";

  if ($conn->query($sql) === TRUE) {
      
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Order created successfully.";
  } else {

      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
