<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

// Check if the connection is successful
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo "Database Connection Error: " . $conn->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $raw_material_id = $_POST['raw_material_id'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];

    // Get product details
    $sqlqty = "SELECT INV.quantity_in_stock, PD.raw_material_name 
              FROM rawmaterials PD
              JOIN rawstock INV ON PD.raw_material_id = INV.raw_material_id 
              WHERE PD.raw_material_id=?";

    // After preparing the statement, check for errors
    $stmt = $conn->prepare($sqlqty);
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo "SQL Prepare Error: " . $conn->error;
        exit();
    }

    $stmt->bind_param("i", $raw_material_id);

    // After executing the statement, check for errors
    if (!$stmt->execute()) {
        http_response_code(500); // Internal Server Error
        echo "SQL Execute Error: " . $stmt->error;
        exit();
    }

    $resultqty = $stmt->get_result();

    // Check if there are rows in the result
    if ($resultqty->num_rows > 0) {
        $rowqty = $resultqty->fetch_assoc();
        $getqty = $rowqty['quantity_in_stock'];
        $getpro_name = $rowqty['raw_material_name'];

        // Delete the Inventory
        $sqlInve = "DELETE FROM rawstock WHERE raw_material_id=?";

        // After preparing the statement, check for errors
        $stmtInve = $conn->prepare($sqlInve);
        if (!$stmtInve) {
            http_response_code(500); // Internal Server Error
            echo "SQL Prepare Error: " . $conn->error;
            exit();
        }

        $stmtInve->bind_param("i", $raw_material_id);

        // After executing the statement, check for errors
        if (!$stmtInve->execute()) {
            http_response_code(500); // Internal Server Error
            echo "SQL Execute Error: " . $stmtInve->error;
            exit();
        }

        $stmtInve->close(); // Close the statement after execution

        // Delete the product
        $sql = "DELETE FROM rawmaterials WHERE raw_material_id=?";

        // After preparing the statement, check for errors
        $stmtProduct = $conn->prepare($sql);
        if (!$stmtProduct) {
            http_response_code(500); // Internal Server Error
            echo "SQL Prepare Error: " . $conn->error;
            exit();
        }

        $stmtProduct->bind_param("i", $raw_material_id);

        // After executing the statement, check for errors
        if ($stmtProduct->execute()) {
            $stmtProduct->close(); // Close the statement after execution

            // Return a success message
            http_response_code(201); // Created
            echo "Product deleted successfully.";
            AddHistory($user_id, "Removed all stock: " . $getqty . " of " . $getpro_name, $spt, "RowStockRemoved");
            AddHistory($user_id, "Removed Product: " . $getpro_name, $spt, "RowMaterialRemoved");
        } else {
            // Return an error message if the insert failed
            http_response_code(500); // Internal Server Error
            echo "Error deleting product: " . $stmtProduct->error;
        }
    } else {
        // Handle the case where product details are not found
        http_response_code(404); // Not Found
        echo "Product details not found.";
    }

    $stmt->close();
}

?>
