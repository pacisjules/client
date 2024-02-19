<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $service_type = $_POST['service_type'];
  $area_measure	 = $_POST['area_measure'];

  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];
  $status = $_POST['status'];

  // Insert the  products
  $sql = "INSERT INTO services (service_name, description, price,area_measure,company_ID,sales_point_id,status,service_type)
  VALUES ('$service_name', '$description','$price','$area_measure', '$company_ID', '$sales_id', '$status','$service_type')";

  if ($conn->query($sql) === TRUE) {
      
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Services created successfully.";
  } else {

      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
