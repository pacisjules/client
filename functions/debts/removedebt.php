<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];

    // Retrieve the debt data by id before deleting
    $debtQuery = "SELECT * FROM debts WHERE id='$id'";
    $debtResult = $conn->query($debtQuery);

    if ($debtResult->num_rows > 0) {
        $debtRow = $debtResult->fetch_assoc();
        $sess_id = $debtRow['sess_id'];
        $product_id = $debtRow['product_id'];

        // Check if sess_id is not null to delete the corresponding sales data
        if (!is_null($sess_id)) {
            // Retrieve the corresponding sales data using sess_id and product_id
            $salesQuery = "SELECT sales_id FROM sales WHERE sess_id='$sess_id' AND product_id='$product_id'";
            $salesResult = $conn->query($salesQuery);

            if ($salesResult->num_rows > 0) {
                $salesRow = $salesResult->fetch_assoc();
                $sales_id = $salesRow['sales_id'];

                // Delete the sales data using the unique sales_id
                $deleteSalesSql = "DELETE FROM sales WHERE sales_id='$sales_id'";

                if ($conn->query($deleteSalesSql) === TRUE) {
                    echo "Sales data deleted successfully.";
                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    echo "Error deleting sales data: " . $conn->error;
                }
            } else {
                echo "No matching sales data found for deletion.";
            }
        }

        // After checking and deleting the sales data, delete the debt record
        $deleteDebtSql = "DELETE FROM debts WHERE id='$id'";

        if ($conn->query($deleteDebtSql) === TRUE) {
            echo "Debt deleted successfully.";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error deleting debt: " . $conn->error;
        }
    } else {
        echo "Debt record not found.";
    }
}
?>
