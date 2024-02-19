<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Retrieve the POST data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $phone = $_POST['phone'];
    $sales_point_id = $_POST['sales_point_id'];
    $user_id = $_POST['user_id'];
    
    // Insert the user data into the database
    $sql = "INSERT INTO employee (first_name, last_name, email, hire_date, salary, phone, sales_point_id, user_id) VALUES ('$first_name', '$last_name', '$email','$hire_date','$salary','$phone','$sales_point_id', '$user_id')";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Employee created successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}