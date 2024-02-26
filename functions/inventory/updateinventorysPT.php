<?php
// Include the database connection file
require_once '../connection.php';

// Define the company ID and sales point ID
$company_ID = $_POST['company'];;
$sales_point_id = $_POST['spt'];;

// Retrieve product IDs from the products table based on company_ID and sales_point_id
$sql = "SELECT id FROM products WHERE sales_point_id = $sales_point_id";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
        // Update company_ID and spt_id in the inventory table for the current product_id
        $update_sql = "UPDATE inventory SET company_ID = $company_ID, spt_id = $sales_point_id WHERE product_id = $product_id";
        if ($conn->query($update_sql) === TRUE) {
            echo "Inventory updated successfully for product ID: $product_id <br>";
        } else {
            echo "Error updating inventory for product ID: $product_id - " . $conn->error . "<br>";
        }
    }
} else {
    echo "No products found for company ID: $company_ID and sales point ID: $sales_point_id";
}

// Close the database connection
$conn->close();
?>
