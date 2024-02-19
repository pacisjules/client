<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $category_name  = $_POST['category_name'];
  $co_id = $_POST['company_id'];

  // Insert the  products
  $sql = "INSERT INTO users_category (category_name, company_id, status)
  VALUES ('$category_name', '$co_id',1)";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "User category Inventory successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
