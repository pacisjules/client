<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $Name = $_POST['Name'];
  $Description = $_POST['Description'];

  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];

  // Insert the  products
  $sql = "INSERT INTO menu_categories (Name, Description,sales_point_id, company_ID)
  VALUES ('$Name', '$Description', '$sales_id', '$company_ID')";

  if ($conn->query($sql) === TRUE) {
      
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Menu Category created successfully.";
  } else {

      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
