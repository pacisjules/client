<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $UserID = $_POST["user_id"];
    $Emp_Id = $_POST["emp_id"];
    $SalesID = $_POST["salesP_id"];


    // Delete Employee all information
    $sql = "DELETE FROM employee WHERE employee_id='$Emp_Id' AND user_id='$UserID' AND sales_point_id='$SalesID'";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Employee Deleted successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}