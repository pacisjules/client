<?php

// Include the database connection file
require_once '../connection.php';
//header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $name = $_POST['name'];
  $price = $_POST['price'];

  $company_ID = $_POST['company_ID'];
  $sales_id = $_POST['sales_point_id'];

  $status = $_POST['status'];
  $description=$_POST['description'];
 


  $sqlcheck = "SELECT name FROM menu_items WHERE name	='$name' AND company_ID='$company_ID' AND sales_point_id='$sales_id'";
  $resultcheck = $conn->query($sqlcheck);

    if ($resultcheck->num_rows > 0) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "1";
        exit();
    }else{
      
      
      // Insert the  products
      $sql = "INSERT INTO menu_items (name, price, company_ID,sales_point_id,status,description)
      VALUES ('$name', '$price','$company_ID', '$sales_id', '$status','$description')";

      if ($conn->query($sql) === TRUE) {
          // Return a success message
          header('HTTP/1.1 201 Created');
          echo "2";
      } else {
          // Return an error message if the insert failed
          header('HTTP/1.1 500 Internal Server Error');
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
}
