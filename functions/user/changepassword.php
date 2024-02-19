<?php
// Include the database connection file
require_once '../connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Retrieve the POST data
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
  
    // Insert the user data into the database
    $sql = "UPDATE users SET password='$password' WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "User password recovered successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
