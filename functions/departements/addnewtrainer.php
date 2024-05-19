<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $dep_id = $_POST['dep_id'];
  $fullname = $_POST['fullname'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $qualification = $_POST['qualification'];
  $user_id = $_POST['user_id'];



  // Insert the  products
  $sql = "INSERT INTO `trainers` (`dep_id`, `full_name`, `phone`,`address`, `qualification`,`user_id`)
  VALUES ('$dep_id', '$fullname','$phone','$address', '$qualification','$user_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "trainers created successfully.";
     
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
