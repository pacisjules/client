<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
     // Get the form data
     $id = $_POST['id'];
     $name = $_POST['name'];
     $description = $_POST['description'];

     // Update the  expenses type
     $sql = "UPDATE expenses_type SET name='$name',description='$description' WHERE id='$id'";

     if ($conn->query($sql) === TRUE) {
         // Return a success message
         header('HTTP/1.1 201 Created');
         echo "Expense type Updated successfully.";
     } else {
         // Return an error message if the insert failed
         header('HTTP/1.1 500 Internal Server Error');
         echo "Error: " . $sql . "<br>" . $conn->error;
     }
}