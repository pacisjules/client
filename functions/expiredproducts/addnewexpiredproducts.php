<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id = $_POST['product_id'];
  $expiry_date = $_POST['expiry_date'];
  $expired_quantity = $_POST['expired_quantity'];
  $warning_hours = $_POST['warning_hours'];
  $disposal_method = $_POST['disposal_method'];
  $sales_point_id = $_POST['sales_point_id'];



   //Get current quantity

   $sqlcurrent = "SELECT * FROM inventory WHERE product_id=$product_id";
   $result = $conn->query($sqlcurrent);

   $rowInfos = $result->fetch_assoc();
   $currentQuantity = $rowInfos['quantity'];

  // Insert the  products
  $sql = "INSERT INTO expiredproducts (product_id, expiry_date,expired_quantity, warning_hours,disposal_method,sales_point_id, current_stock)
  VALUES ('$product_id', '$expiry_date','$expired_quantity','$warning_hours', '$disposal_method', '$sales_point_id','$currentQuantity')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Expiry saved successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
