<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $product_id  = $_POST['product_id'];
    $store_id  = $_POST['store_id'];
    $company = $_POST['company'];
    $unit_id = $_POST['unit_id'];
    $container = $_POST['container'];
    $quantity = $_POST['quantity'];
    $priceper_unity = $_POST['price_per_unity'];
    $supplier_id = $_POST['supplier_id'];
    $user_id = $_POST['user_id'];

    // Check if raw_material_id exists in rawstock
    $checkExistingQuery = "SELECT * FROM storedetails WHERE product_id = '$product_id' AND store_id='$store_id'";
    $checkExistingResult = $conn->query($checkExistingQuery);

    if ($checkExistingResult->num_rows > 0) {
        // Update quantity_in_stock if the raw_material_id exists
        $updateQuery = "UPDATE storedetails SET box_or_carton = box_or_carton + '$container' WHERE product_id = '$product_id' AND store_id='$store_id'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Quantity updated in rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error updating quantity in rawstock: " . $conn->error;
        }
    } else {
        // Insert a new row in rawstock if raw_material_id doesn't exist
        $insertQuery = "INSERT INTO `storedetails` (`store_id`,`product_id`,`unit_id`, `box_or_carton`, `quantity_per_box`, `company_ID`, `user_id`)
                        VALUES ('$store_id','$product_id','$unit_id','$container','$quantity', '$company', '$user_id')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "New row added to rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error adding new row to storedetails: " . $conn->error;
        }
    }
    
    $total_price= $priceper_unity * $container;

    // Insert the purchase record
    $purchaseQuery = "INSERT INTO `purchase` ( `store_id`, `product_id`, `unit_id`, `container`, `quantity`, `price_per_unity`, `total_price`, `supplier_id`, `company_ID`,`user_id`)
                        VALUES ('$store_id','$product_id', '$unit_id','$container','$quantity', '$priceper_unity','$total_price', '$supplier_id', '$company', '$user_id')";

    if ($conn->query($purchaseQuery) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "New purchase done successfully.";
        
        // Retrieve product name
        $getProductNameQuery = "SELECT name FROM products WHERE id = $product_id";
        $resultProductName = $conn->query($getProductNameQuery);

        if ($resultProductName->num_rows > 0) {
            $rowName = $resultProductName->fetch_assoc();
            $getpro_name = $rowName['name'];

            // Add history
            AddHistory($user_id, "Added Quantity: $quantity of $getpro_name", $spt, "RowStockIn");
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
