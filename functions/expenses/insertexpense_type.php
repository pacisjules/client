<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $sales_point_id = intval($_POST['salepoint_id']); // Ensure it's an integer

    // Prepare and execute the query using a prepared statement
    $stmt = $conn->prepare("INSERT INTO expenses_type (name, description, salepoint_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $sales_point_id);

    if ($stmt->execute()) {
        // Return a success message
        http_response_code(201); // Created status code
        echo "Expense type created successfully.";
    } else {
        // Return an error message if the insert failed
        http_response_code(500); // Internal Server Error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
