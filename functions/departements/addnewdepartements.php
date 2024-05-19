<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $department_name = $_POST['department_name'];
  $chefDepartment = $_POST['chefDepartment'];
  $cheftel = $_POST['cheftel'];
  $company_ID = $_POST['company_ID'];
  $spt_id = $_POST['spt_id'];
  $user_id = $_POST['user_id'];



  // Insert the  products
  $sql = "INSERT INTO `departements` (`departement_name`, `chef_dept`, `chef_tel`,`company_id`, `spt_id`,`user_id`)
  VALUES ('$department_name', '$chefDepartment','$cheftel','$company_ID', '$spt_id','$user_id')";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "departement created successfully.";
     
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
