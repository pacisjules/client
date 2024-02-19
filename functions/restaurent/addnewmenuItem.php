<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $Name = $_POST['Name'];
  $Description = $_POST['Description'];
  $Price = $_POST['Price'];

  $CategoryID	 = $_POST['CategoryID'];
  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];
  $status = $_POST['status'];

  // Insert the  products
  $sql = "INSERT INTO menu_items (Name, Description, Price, CategoryID, company_ID, sales_point_id, status)
  VALUES ('$Name', '$Description', '$Price', '$CategoryID', '$company_ID', '$sales_id', '$status')";

  if ($conn->query($sql) === TRUE) {
      
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Menu Item created successfully.";
  } else {

      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
