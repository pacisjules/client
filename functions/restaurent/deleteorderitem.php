<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $item_id = $_POST['item_id'];

  // Delete the  product
  $sql = "DELETE FROM order_items WHERE OrderItemID =$item_id";

  if ($conn->query($sql) === TRUE) {

      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Order Item deleted successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
