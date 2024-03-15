<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $raw_material_id  = $_POST['raw_material_id'];
    $company_ID= $_POST['company_ID'];
    $container = $_POST['container'];
    $quantity = $_POST['quantity'];
    $priceper_unity = $_POST['price_per_unity'];
    $supplier_id = $_POST['supplier_id'];
    $user_id = $_POST['user_id'];

    // Check if raw_material_id exists in rawstock
    $checkExistingQuery = "SELECT * FROM rawstock WHERE raw_material_id = '$raw_material_id'";
    $checkExistingResult = $conn->query($checkExistingQuery);
    $row = $checkExistingResult->fetch_assoc();

    $box = $row['box_container'];
    $totqty = $row['quantity_in_stock'];

    if ($checkExistingResult->num_rows > 0) {
        // Update quantity_in_stock if the raw_material_id exists
        $newbox =  $box + $container; 
        $newtot =  $container * $quantity; 

        $updateQuery = "UPDATE rawstock SET
         box_container ='$newbox',
         qty_per_box='$quantity',
         quantity_in_stock = quantity_in_stock + '$newtot' WHERE raw_material_id = '$raw_material_id'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Quantity updated in rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error updating quantity in rawstock: " . $conn->error;
        }
    } else {
        // Insert a new row in rawstock if raw_material_id doesn't exist
        $newtot =  $container * $quantity; 

        $insertQuery = "INSERT INTO `rawstock` (`raw_material_id`,`box_container`,`qty_per_box`, `quantity_in_stock`, `company_ID`, `user_id`)
                        VALUES ('$raw_material_id',$container,'$quantity' ,'$newtot', '$company_ID', '$user_id')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "New row added to rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error adding new row to rawstock: " . $conn->error;
        }
    }

    // Insert the purchase record
    $total = $priceper_unity * $container;
    $purchaseQuery = "INSERT INTO `purchase` (`raw_material_id`, `container`,`quantity`, `price_per_unity`, `total_price`,`supplier_id`, `company_ID`, `user_id`)
                        VALUES ('$raw_material_id', '$container','$quantity', '$priceper_unity', '$total','$supplier_id', '$company_ID', '$user_id')";

    if ($conn->query($purchaseQuery) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "New purchase done successfully.";
        
        // Retrieve product name
        $getProductNameQuery = "SELECT raw_material_name FROM rawmaterials WHERE raw_material_id = $raw_material_id";
        $resultProductName = $conn->query($getProductNameQuery);

        if ($resultProductName->num_rows > 0) {
            $rowName = $resultProductName->fetch_assoc();
            $getpro_name = $rowName['raw_material_name'];

            // Add history
            AddHistory($user_id, "Added box: $container of $getpro_name", $spt, "RowStockIn");
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error retrieving product name: " . $conn->error;
        }
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error adding new purchase: " . $conn->error;
    }
}
?>
