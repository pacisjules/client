<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $categoryName  = $_POST['categoryName'];
    $managedBy = $_POST['managedBy'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];

    // Insert the products into the 'asset' table
    $sql = "INSERT INTO assetCategory (categoryName, managedBy, spt, user_id)
            VALUES ('$categoryName', $managedBy, $spt, $user_id)";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Asset Inserted successfully.";
        AddHistory($user_id, "Register New Asset Category: " . $categoryName, $spt, "AddNewAssetCategory");
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
