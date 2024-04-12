<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the form data
    $product_id  = $_POST['product_id'];
    $spt_id  = $_POST['spt_id'];
    $company = $_POST['company'];
    $quantity = $_POST['quantity'];
    $priceper_unity = $_POST['price_per_unity'];
    $supplier_id = $_POST['supplier_id'];
    $user_id = $_POST['user_id'];
    $alertqty = 5;

    // Check if raw_material_id exists in rawstock
    $checkExistingQuery = "SELECT * FROM inventory WHERE product_id = '$product_id'";
    $checkExistingResult = $conn->query($checkExistingQuery);
    
    if ($checkExistingResult->num_rows > 0) {
        // Update quantity_in_stock if the raw_material_id exists
        
       
        
        
        $updateQuery = "UPDATE inventory 
        SET 
            quantity = quantity + '$quantity',
            company_ID='$company',
            spt_id='$spt_id'
        
        WHERE product_id = '$product_id'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Quantity updated in Invetory Sales point successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error updating quantity in rawstock: " . $conn->error;
        }
    } else {
        // Insert a new row in rawstock if raw_material_id doesn't exist
        $insertQuery = "INSERT INTO `inventory` (`product_id`, `quantity`,`alert_quantity`, `company_ID`,`spt_id`)
                        VALUES ('$product_id','$quantity','$alertqty','$company','$spt_id')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "New row added to inventory successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error adding new row to inventory: " . $conn->error;
        }
    }
    
    $total_price= $priceper_unity * $quantity;

    // Insert the purchase record
    $purchaseQuery = "INSERT INTO `purchase` (`product_id`, `unit_id`, `container`,`quantity`, `price_per_unity`,`total_price`, `supplier_id`, `company_ID`, `spt_id`,`user_id`)
                        VALUES ('$product_id', 0,0,'$quantity', '$priceper_unity','$total_price', '$supplier_id', '$company','$spt_id' ,'$user_id')";

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
