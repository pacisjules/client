<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expenseId = $_POST['id'];

    // Delete the expense record from the database
    $sql = "DELETE FROM shop_expenses WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expenseId); // "i" for integer
    if ($stmt->execute()) {
        // Return a success message
        http_response_code(200); // OK status code
        echo json_encode(array("status" => "success", "message" => "Expense record deleted successfully."));
    } else {
        // Return an error message if the delete failed
        http_response_code(500); // Internal Server Error
        echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
    }

    $stmt->close();
}
?>
