<?php
// Include the database connection file
require_once '../connection.php';
require_once '../debtssystemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sess_id = $_POST["sess_id"];

    // Retrieve the POST data
    $status = $_POST['status'];
    $descriptions = $_POST['descriptions'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];

    // Use prepared statements to prevent SQL injection
    $sql_query = "SELECT id, amount, amount_paid FROM debts WHERE customer_id = ? AND status = 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("s", $sess_id);
    $stmt->execute();
    $sql_result = $stmt->get_result();

    // Check if there are any results
    if ($sql_result->num_rows > 0) {
        while ($amount_row = $sql_result->fetch_assoc()) {
            $current_id = $amount_row['id'];
            $current_amount = $amount_row['amount'];
            $current_amount_paid = $amount_row['amount_paid'];

            $balance = $current_amount - $current_amount_paid;
            $dt_paid = $current_amount_paid + $balance;

            // Update the debt data into the database
            $update_sql = "UPDATE debts SET descriptions=?, status=?, amount_paid=? WHERE id=?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssdi", $descriptions, $status, $dt_paid, $current_id);

            if ($update_stmt->execute()) {
                // Return a success message
                header('HTTP/1.1 201 Created');
                echo "Debt with ID $current_id paid successfully.";
                debtHistory($user_id, $sess_id,"Pay in full", $current_amount,0.00, $spt);
            } else {
                // Return an error message if the update failed
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . $update_sql . "<br>" . $conn->error;
            }
        }
    } else {
        header('HTTP/1.1 404 Not Found');
        echo "No debts found for the specified customer and status.";
    }

    // Close the statement
    $stmt->close();
    $update_stmt->close();
}
?>
