<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $service_id = $_POST['service_id'];
  $state = $_POST['state'];


  // Insert the  products
  $sql = "UPDATE services SET status='$state' WHERE id=$service_id";

  if ($conn->query($sql) === TRUE) {
    // Return a success message
    header('HTTP/1.1 201 Created');
    echo "Service status changed successfully.";
  } else {
    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
