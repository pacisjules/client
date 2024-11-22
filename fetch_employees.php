<?php
// Start the session and include the database connection
session_start();
include('functions/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the sales_point_id from POST data
    $sales_point_id = $_POST['sales_point_id'];

    // Prepare the query to fetch employees
    $query = "SELECT * FROM `employee` WHERE `sales_point_id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $sales_point_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate dropdown options
    if ($result->num_rows > 0) {
        echo '<option value="">Select a Supervisor</option>';
        while ($row = $result->fetch_assoc()) {
            $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
            echo '<option value="' . htmlspecialchars($row['user_id']) . '">' . $full_name . '</option>';
        }
    } else {
        echo '<option value="">No Supervisor Available</option>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
