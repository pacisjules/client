<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $raw_material_id  = $_POST['raw_material_id'];
    $spt = $_POST['spt'];
    $quantity = $_POST['quantity'];
    $priceper_unity = $_POST['price_per_unity'];
    $supplier_id = $_POST['supplier_id'];
    $user_id = $_POST['user_id'];

    // Check if raw_material_id exists in rawstock
    $checkExistingQuery = "SELECT * FROM rawstock WHERE raw_material_id = '$raw_material_id'";
    $checkExistingResult = $conn->query($checkExistingQuery);

    if ($checkExistingResult->num_rows > 0) {
        // Update quantity_in_stock if the raw_material_id exists
        $updateQuery = "UPDATE rawstock SET quantity_in_stock = quantity_in_stock + '$quantity' WHERE raw_material_id = '$raw_material_id'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Quantity updated in rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error updating quantity in rawstock: " . $conn->error;
        }
    } else {
        // Insert a new row in rawstock if raw_material_id doesn't exist
        $insertQuery = "INSERT INTO `rawstock` (`raw_material_id`, `quantity_in_stock`, `sales_point_id`, `user_id`)
                        VALUES ('$raw_material_id', '$quantity', '$spt', '$user_id')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "New row added to rawstock successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error adding new row to rawstock: " . $conn->error;
        }
    }

    // Insert the purchase record
    $purchaseQuery = "INSERT INTO `purchase` (`raw_material_id`, `quantity`, `price_per_unity`, `supplier_id`, `spt`, `user_id`)
                        VALUES ('$raw_material_id', '$quantity', '$priceper_unity', '$supplier_id', '$spt', '$user_id')";

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
