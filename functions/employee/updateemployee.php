<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $UserID = $_POST["user_id"];
    $Emp_Id = $_POST["emp_id"];
    $SalesID = $_POST["salesP_id"];

    // Retrieve the POST data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $phone = $_POST['phone'];
    $sales_point_id = $_POST['sales_point_id'];


    // Update the employee data into the database
    $sql = "UPDATE employee SET first_name='$first_name', last_name='$last_name', email='$email', hire_date='$hire_date', salary='$salary', phone='$phone', sales_point_id='$sales_point_id'
    WHERE employee_id='$Emp_Id' AND user_id='$UserID' AND sales_point_id='$SalesID'";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Employee Updated successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
