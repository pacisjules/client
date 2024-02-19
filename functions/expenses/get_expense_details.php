<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get the expense ID from the query parameters
    $expenseId = $_GET['id'];

    // SQL query to fetch expense details by ID
    $sql = "
        SELECT
            id,
            name,
            description,
            amount,
            exp_type
        FROM
            shop_expenses
        WHERE 
            id = ?
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expenseId); // "i" for integer

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Fetch the expense details
        $expenseDetails = $result->fetch_assoc();

        // Set the response header to indicate JSON content
        header('Content-Type: application/json');

        // Convert data to JSON
        echo json_encode($expenseDetails);
    } else {
        // If query execution fails
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Database query error."));
    }

    // Close the statement
    $stmt->close();
}
?>
