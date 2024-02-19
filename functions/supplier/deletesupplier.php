<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $supplier_id = $_POST["supplier_id"];
    
    //Get if is in Inventory

    $sql = "DELETE FROM supplier WHERE supplier_id=$supplier_id";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "supplier Inventory successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
    

}
