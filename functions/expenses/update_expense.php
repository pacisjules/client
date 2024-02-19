<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the POST data
    $id = $_POST["id"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $sales_point_id = $_POST['sales_point_id'];
    $exp_type = $_POST['exp_type'];

    // Prepare and execute the query using a prepared statement
    $sql = "UPDATE shop_expenses SET 
        name = ?,
        description = ?,
        amount = ?,
        sales_point_id = ?,
        exp_type = ?
    WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $name, $description, $amount, $sales_point_id, $exp_type, $id);

    if ($stmt->execute()) {
        // Return a success message
        http_response_code(201); // Created status code
        echo "Expense Updated successfully.";
    } else {
        // Return an error message if the update failed
        http_response_code(500); // Internal Server Error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
