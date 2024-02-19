<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $order_id = $_POST['order_id'];
  $state = $_POST['state'];

  // Disable or Enable Order
  $sql = "UPDATE orders SET status='$state' WHERE Orderid=$order_id";

  if ($conn->query($sql) === TRUE) {

    // Return a success message
    header('HTTP/1.1 201 Created');
    echo "Order status changed successfully.";
  } else {

    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
