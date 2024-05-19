<?php
// Include the database connection file
require_once '../connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $detail_id = $_POST["detail_id"];
    $product_id = $_POST["product_id"];
    $UserID = $_POST["user_id"];

    // Retrieve the POST data
    $quantity_per_box = $_POST['quantity_per_box'];
    $box_or_carton = $_POST['box_or_carton'];
    $company_ID = $_POST['company_ID'];
    $store_id = $_POST['store_id'];

   

    // Update the employee data into the database
    $sql = "UPDATE storedetails SET 
    box_or_carton='$box_or_carton', 
    quantity_per_box='$quantity_per_box' 
    
    WHERE detail_id=$detail_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "bIG sTOCK Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
