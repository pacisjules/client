<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];

    // Retrieve the POST data
    $qty = $_POST['qty'];
    $amount = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $sales_point_id = $_POST['sales_point_id'];
    $priceunit = $_POST['priceunit'];

    // Retrieve the debt data by id
    $debtQuery = "SELECT * FROM debts WHERE id='$id'";
    $debtResult = $conn->query($debtQuery);

    if ($debtResult->num_rows > 0) {
        $debtRow = $debtResult->fetch_assoc();
        $sess_id = $debtRow['sess_id'];
        $product_id = $debtRow['product_id'];
        // $currentamount = $debtRow['amount'];
        // $currentqty = $debtRow['qty'];
        // $unitprice = $currentamount/ $currentqty;

        $newtotal = $priceunit * $qty;

        // Update the debt data in the database
        $updateDebtSql = "UPDATE debts SET 
            amount='$newtotal', 
            amount_paid='$amount_paid', 
            sales_point_id='$sales_point_id',
            qty='$qty'
            WHERE id='$id'";

        if ($conn->query($updateDebtSql) === TRUE) {
            // If sess_id is not NULL, update the sales table
            if (!is_null($sess_id)) {
                // Retrieve the corresponding sales data using sess_id and product_id
                $salesQuery = "SELECT sales_id FROM sales WHERE sess_id='$sess_id' AND product_id='$product_id'";
                $salesResult = $conn->query($salesQuery);

                if ($salesResult->num_rows > 0) {
                    $salesRow = $salesResult->fetch_assoc();
                    $sales_id = $salesRow['sales_id'];

                    // Calculate new values for quantity, total_amount, and paid
                    $newQuantity = $qty;
                    $newTotalAmount = $amount;
                    $price = $amount / $qty; // Calculate sales price per unit
                    $newPaid = $amount_paid;

                    // Update the sales data using the unique sales_id
                    $updateSalesSql = "UPDATE sales SET 
                        quantity='$newQuantity', 
                        sales_price='$price',
                        total_amount='$newTotalAmount', 
                        paid='$newPaid' 
                        WHERE sales_id='$sales_id'";

                    if ($conn->query($updateSalesSql) === TRUE) {
                        echo "Debt and Sales Updated successfully.";
                    } else {
                        header('HTTP/1.1 500 Internal Server Error');
                        echo "Error updating sales: " . $conn->error;
                    }
                } else {
                    echo "No matching sales data found.";
                }
            } else {
                echo "Debt Updated successfully. No sess_id, sales not updated.";
            }
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error updating debt: " . $conn->error;
        }
    } else {
        echo "Debt record not found.";
    }
}
?>
