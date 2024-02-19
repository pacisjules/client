<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $ItemName = $_POST['ItemName'];
  $menuItem=$_POST['menuItem'];
  $Quantity = $_POST['Quantity'];
  $status = $_POST['status'];

  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];
  $OrderID = $_POST['OrderID'];
  
  // Insert the  products
  $sql = "INSERT INTO order_items (ItemName, Quantity,company_ID,sales_point_id,status,OrderID, menuItem)
  VALUES ('$ItemName', '$Quantity', '$company_ID', '$sales_id', '$status','$OrderID','$menuItem')";

  if ($conn->query($sql) === TRUE) {
      
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Order item created successfully.";
  } else {

      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}