<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $names  = $_POST['names'];
  $spt = $_POST['spt'];
  $company = $_POST['company'];
  $starttime= $_POST['starttime'];
  $endtime = $_POST['endtime'];


  // Insert the  products
  $sql = "INSERT INTO shift (names,spt,company, shiftstart, shiftend)
  VALUES ('$names', '$spt','$company', '$starttime', '$endtime')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "SHIFT addded successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
