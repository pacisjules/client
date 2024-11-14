<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id = $_POST['product_id'];
  $packgenumber = $_POST['packgenumber'];
  $company_id = $_POST['company_id'];

  // Insert the  product_category
  $sql = "INSERT INTO packages (product_id,packgenumber, company_id)
  VALUES ('$product_id','$packgenumber','$company_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product package created successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
