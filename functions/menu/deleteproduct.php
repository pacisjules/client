<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $product_id = $_POST['product_id'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];

    // Get product details
    $sqlqty = "SELECT INV.quantity, PD.name 
              FROM products PD
              JOIN inventory INV ON PD.id = INV.product_id 
              WHERE product_id=?";
    $stmt = $conn->prepare($sqlqty);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $resultqty = $stmt->get_result();

    // Check if there are rows in the result
    if ($resultqty->num_rows > 0) {
        $rowqty = $resultqty->fetch_assoc();
        $getqty = $rowqty['quantity'];
        $getpro_name = $rowqty['name'];

        // Delete the Inventory
        $sqlInve = "UPDATE inventory SET status=0 WHERE product_id=?";
        $stmtInve = $conn->prepare($sqlInve);
        $stmtInve->bind_param("i", $product_id);

        if ($stmtInve->execute() ) {
            // Delete the product
            $sql = "UPDATE products set status=0 WHERE id=?";
            $stmtProduct = $conn->prepare($sql);
            $stmtProduct->bind_param("i", $product_id);

            if ($stmtProduct->execute()) {
                // Return a success message
                http_response_code(201); // Created
                echo "Product deleted successfully.";
                AddHistory($user_id, "Removed all stock: " . $getqty . " of " . $getpro_name, $spt, "inventoryRemoved");
                AddHistory($user_id, "Removed Product: " . $getpro_name, $spt, "ProductRemoved");
            } else {
                // Return an error message if the insert failed
                http_response_code(500); // Internal Server Error
                echo "Error deleting product: " . $stmtProduct->error;
            }

            $stmtProduct->close();
        } else {
            // Return an error message if the insert failed
            http_response_code(500); // Internal Server Error
            echo "Error deleting from inventory: " . $stmtInve->error;
        }

        $stmtInve->close();
    } else {
        // Handle the case where product details are not found
        http_response_code(404); // Not Found
        echo "Product details not found.";
    }

    $stmt->close();
}

?>
