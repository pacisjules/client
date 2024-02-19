<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];

    // Retrieve the POST data
    $qty = $POST['qty'];
    $amount = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $sales_point_id = $_POST['sales_point_id'];


    // Update the debt data into the database
    $sql = "UPDATE debts SET 

    amount='$amount', 
    amount_paid='$amount_paid', 
    sales_point_id='$sales_point_id'

    WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Debt Updated successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
