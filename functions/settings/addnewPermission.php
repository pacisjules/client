<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $name  = $_POST['name'];
  $page_id  = $_POST['page_id'];
  $cat_id  = $_POST['cat_id'];
  $co_id = $_POST['company_id'];

  // Insert the  products
  $sql = "INSERT INTO `permissions` (`name`,`cat_id`,`page_id`, `company_id`)
  VALUES ('$name','$cat_id','$page_id', '$co_id')";

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
