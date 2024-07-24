<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $shiftid  = $_POST['shift_id'];

  //
  $sql = "UPDATE shift_records SET end='0000-00-00 00:00:00', shift_status=1 WHERE record_id=$shiftid";
  $sqlclose = "DELETE FROM close_checkout  WHERE shiftrecord_id=$shiftid";

  if ($conn->query($sql) === TRUE && $conn->query($sqlclose) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "SHIFT expanded successfully. $shiftid";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
