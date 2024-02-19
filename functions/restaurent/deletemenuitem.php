<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $ItemID = $_POST['ItemID'];

  // Delete the  product
  $sql = "DELETE FROM menu_items WHERE ItemID=$ItemID";

  if ($conn->query($sql) === TRUE) {

    // Return a success message
    header('HTTP/1.1 201 Created');
    echo "Menu Item deleted successfully.";
  } else {

    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
