<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $names  = $_POST['names'];
    $qty = $_POST['qty'];
    $categorySelect = $_POST['category_id'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    // Insert the products into the 'asset' table
    $sql = "INSERT INTO asset (asset_name, quantity,category_id,status,spt, user_id)
            VALUES ('$names', $qty, $categorySelect,'$status',$spt, $user_id)";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Asset Inserted successfully.";
        AddHistory($user_id, "Register New Asset: " . $names . " And Quantity: " . $qty, $spt, "AddNewAsset");
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
