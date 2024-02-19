<?php
// Include the database connection file
require_once '../connection.php';

// Get sales point ID and date from query string
$sales_point_id = $_GET['sales_point_id'];
$date = $_GET['date'];

// Convert the date to MySQL date format (assuming date is in "Y-m-d" format)
$dateFormatted = date("Y-m-d", strtotime($date));

// SQL query to fetch expenses data
$sql = "
    SELECT
        SE.id,
        SE.name,
        SE.description,
        SE.amount,
        (SELECT name FROM expenses_type WHERE id = SE.exp_type) AS expense_name,
        SE.created_date,
        SE.sales_point_id
    FROM
        shop_expenses SE
    WHERE 
        SE.sales_point_id = ? AND DATE(SE.created_date) = ?
    ORDER BY
        SE.id DESC    
";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $sales_point_id, $dateFormatted); // "i" for integer and "s" for string

// Execute the query
if ($stmt->execute()) {
    // Get the result
    $result = $stmt->get_result();

    // Fetch and format expenses as an array
    $expenses = array();
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    // Set the response header to indicate JSON content
    header('Content-Type: application/json');

    // Convert data to JSON
    $jsonData = json_encode($expenses);

    // Send the JSON response
    echo $jsonData;
} else {
    // If query execution fails
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Database query error."));
}

// Close the statement
$stmt->close();
?>
