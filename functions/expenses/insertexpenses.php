<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $exp_type = $_POST['exp_type'];
    $sales_point_id = $_POST['sales_point_id']; // Ensure it's an integer

    // Prepare and execute the query using a prepared statement
    $stmt = $conn->prepare("INSERT INTO shop_expenses (`name`, `description`, `amount`, `sales_point_id`, `exp_type`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $name, $description, $amount, $sales_point_id, $exp_type); // Use "ssiii" based on your column types

    if ($stmt->execute()) {
      // Return a success message
      http_response_code(201); // Created status code
      echo json_encode(array("status" => "success", "message" => "Expense added successfully."));
  } else {
      // Return an error message if the insert failed
      http_response_code(500); // Internal Server Error
      echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
  }

    $stmt->close();
}
?>
