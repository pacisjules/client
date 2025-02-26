<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $pay_id = $_POST['pay_id'];
    $method = $_POST['method'];
    $amount = $_POST['amount'];

    // Prepare the SQL statement to avoid SQL injection
    $sqlQty = "UPDATE payments SET PaymentMethod = ?, Amount = ? WHERE PaymentID = ?";
    $stmt = $conn->prepare($sqlQty);

    // Check if the prepared statement was successful
    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("sdi", $method, $amount, $pay_id); // "sdi" -> string, double, integer
        // Execute the statement
        if ($stmt->execute()) {
            // Success
            $response = ['message' => 'Payment updated successfully'];
        } else {
            // Error during execution
            $response = ['message' => 'Error updating payment', 'error' => $stmt->error];
        }
        $stmt->close();
    } else {
        // Error preparing the statement
        $response = ['message' => 'Error preparing statement', 'error' => $conn->error];
    }

    // Close the database connection
    $conn->close();

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
