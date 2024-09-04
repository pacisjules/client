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
    $user_id = $_POST['user_id'];
    $dependon = $_POST['dependon'];

    $sql = "INSERT INTO shop_expenses (`name`, `description`, `amount`, `sales_point_id`, `exp_type`, `dependon`, `user_id`)
  VALUES ('$name', '$description','$amount','$sales_point_id', '$exp_type', '$dependon', '$user_id')";

if ($conn->query($sql) === TRUE) {
    // Return a success message
    header('HTTP/1.1 201 Created');
    echo "Product Inventory successfully.";
} else {
    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>
