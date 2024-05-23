<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Retrieve the POST data
    $supplier_id = $_POST['supplier_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['qty'];
    $amount_due = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $due_date = $_POST['due_date'];
    $sales_point_id = $_POST['sales_point_id'];
    
    // Insert the user data into the database
    $sql = "INSERT INTO credits (supplier_id, product_id, amount, amount_paid, due_date, qty, sales_point_id, status) 
    VALUES 
    ('$supplier_id', '$product_id', '$amount_due','$amount_paid','$due_date','$quantity','$sales_point_id', 1)";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Credit created successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}