<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amountpaid = $_POST['amountpaid'];
    
    // Query the database to find the customer ID based on the provided amountpaid
    $sql_query = "SELECT customer_id FROM debts WHERE amount >= $amountpaid";
    $result = $conn->query($sql_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customerId = $row['customer_id'];

        // Return the customerId in JSON format
        echo json_encode(['customerId' => $customerId]);
    } else {
        // No customer found for the provided amount
        echo json_encode(['error' => 'No matching customer found']);
    }
}
?>
