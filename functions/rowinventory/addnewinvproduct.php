<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id  = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $alert_quantity = $_POST['alert_quantity'];

  // Insert the  products
  $sql = "INSERT INTO inventory (product_id, quantity, alert_quantity)
  VALUES ('$product_id', '$quantity','$alert_quantity')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
