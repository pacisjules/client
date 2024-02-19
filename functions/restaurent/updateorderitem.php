<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $OrderItemID = $_POST["OrderItemID"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Get the form data
    $ItemName = $_POST['ItemName'];
    $menuItem = $_POST['menuItem'];
    $Quantity = $_POST['Quantity'];
    $status = $_POST['status'];
  
    $company_ID = $_POST['company_ID'];

    //Update the employee data into the database
    $sql = "UPDATE order_items SET ItemName='$ItemName', menuItem='$menuItem', Quantity='$Quantity',  status='$status'  
    WHERE OrderItemID =$OrderItemID";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Order item Updated successfully.";

        //Set History
        AddHistory($UserID,"Service Updated ".$ItemName,$salespt_id);

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
