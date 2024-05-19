<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $dep_id = $_POST['dep_id'];
  $coursename = $_POST['coursename'];
  $coursecode = $_POST['coursecode'];
  $courseduration = $_POST['courseduration'];

  $user_id = $_POST['user_id'];



  // Insert the  products
  $sql = "INSERT INTO `courses` (`course_name`, `course_code`,`duration`,`dep_id`,`user_id`)
  VALUES ('$coursename','$coursecode','$courseduration','$dep_id','$user_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "course recorded successfully.";
     
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
