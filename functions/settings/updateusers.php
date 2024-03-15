<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST["user_id"];
    $company_id = $_POST["company_id"];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $user_category = $_POST['user_category'];


    // Update the employee data into the database
    $sql = "UPDATE employee SET first_name='$first_name',last_name='$last_name', phone='$phone', email='$email'
    WHERE user_id=$user_id";


    // Update the employee data into the database
    $sqlUser = "UPDATE users SET username='$username', user_category='$user_category' 
    WHERE id=$user_id";


    if ($conn->query($sql) === TRUE && $conn->query($sqlUser) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "User Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
