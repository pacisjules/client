<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $dep_id = $_POST['dep_id'];
  $programtype = $_POST['programtype'];
  $programduration = $_POST['programduration'];
  $from = $_POST['from'];
  $to = $_POST['to'];
  $user_id = $_POST['user_id'];



  // Insert the  products
  $sql = "INSERT INTO `programs` (`dept_id`, `programtype`, `program_duration`,`from_time`, `to_time`,`user_id`)
  VALUES ('$dep_id', '$programtype','$programduration','$from', '$to','$user_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "programs created successfully.";
     
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
