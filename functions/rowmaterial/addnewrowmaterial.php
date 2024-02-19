<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $raw_material_name = $_POST['raw_material_name'];
  $unit_of_measure = $_POST['unit_of_measure'];
  $sales_point_id = $_POST['sales_point_id'];
  $status = $_POST['status'];
  $user_id=$_POST['user_id'];


  // Insert the  products
  $sql = "INSERT INTO rawmaterials (raw_material_name, unit_of_measure,sales_point_id,status, user_id)
  VALUES ('$raw_material_name', '$unit_of_measure', '$sales_point_id','$status','$user_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Rawmaterial created successfully.";
      AddHistory($user_id, "Add New Row Material: ".$raw_material_name."\n Unit type: ".$unit_of_measure, $sales_point_id, "RowMaterial");
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
