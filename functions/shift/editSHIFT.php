<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $shiftid  = $_POST['shift_id'];
  $names  = $_POST['names'];
  $starttime= $_POST['starttime'];
  $endtime = $_POST['endtime'];


  // Insert the  products
  $sql = "UPDATE shift SET names='$names', shiftstart='$starttime', shiftend='$endtime' WHERE id=$shiftid";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "SHIFT updated successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
