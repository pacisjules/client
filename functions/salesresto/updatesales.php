<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $s_id = $_POST['s_id'];
    $sess_id = $_POST['sess_id'];
    
    
    
     $sqlcurrent = "
  SELECT
    PD.id,
    INVE.quantity,
    INVE.alert_quantity
    FROM
    products PD,
    inventory INVE
    WHERE
    PD.id=INVE.product_id AND
    PD.id=$product_id
  ";
  $result = $conn->query($sqlcurrent);
  

  $rowInfos = $result->fetch_assoc();
  $current_inventory_quantity = $rowInfos['quantity'];
  $AlertQuantity = $rowInfos['alert_quantity'];
    
    // Get Product price and Current inventory quantity
    $sqlsales = "SELECT
    SL.sales_id,
    SL.total_amount,
    SL.total_benefit,
    SL.quantity AS salesqty,
    SL.paid_status,
    DT.sess_id,
    DT.amount AS det_amount,
    DT.qty,
    DT.id
FROM
    sales SL
LEFT JOIN
    debts DT ON SL.product_id = DT.product_id AND DT.sess_id = '$sess_id' 
WHERE
    SL.product_id = $product_id AND SL.sess_id='$sess_id'
";
    $resultsale = $conn->query($sqlsales);

    if ($resultsale === false) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Error getting sales information'));
        exit;
    }

    $rowSale = $resultsale->fetch_assoc();

    $sale_current_quantity = $rowSale['salesqty'];
    $current_Amount = $rowSale['total_amount'];
    $current_benefit = $rowSale['total_benefit'];
    $sale_paid_status = $rowSale['paid_status'];
    $sale_sess_id = $rowSale['sess_id'];
    $debtamount = $rowSale['det_amount'];
    $debtqty_id = $rowSale['qty'];
    $debt_id = $rowSale['id'];

    // Debugging: Add messages to check if these blocks are executed
    $messages = array();

    // Calculate
    if ($quantity < $sale_current_quantity) {
        
        
        $remainQty = $sale_current_quantity - $quantity;
        $tprice = $current_Amount/$sale_current_quantity;
        $tbene = $current_benefit/$sale_current_quantity;
        
        $updateSlAmount = $quantity * $tprice;
        $updateSlBenefit = $quantity * $tbene;
        $INVqty = $current_inventory_quantity + $remainQty;

        // Start a transaction
        $conn->begin_transaction();

        $error = false;

        // Update the inventory
        $sqlQty = "UPDATE inventory SET quantity = $INVqty WHERE product_id = $product_id";
        if (!$conn->query($sqlQty)) {
            $error = true;
        }

        // Update the sales
        $sqlSales = "UPDATE sales SET quantity = $quantity, total_amount = $updateSlAmount, total_benefit = $updateSlBenefit WHERE sales_id = $s_id";
        if (!$conn->query($sqlSales)) {
            $error = true;
        }

        if ($error) {
            $conn->rollback();
            header('HTTP/1.1 500 Internal Server Error');
            $messages[] = 'Error updating tables';
        } else {
            $conn->commit();

            // Update debt amount
            if ($sale_paid_status === "Not Paid") {
                // Check if a debt record exists for the session and product
                $sqlDebt = "SELECT * FROM debts WHERE id = $debt_id";
                $resultDebt = $conn->query($sqlDebt);

                if ($resultDebt->num_rows == 0) {
                    // Debugging: Add a message to check if this block is executed
                    $messages[] = 'Debt record doesn\'t exist.';
                } else {
                    // Debt record exists, update it
                    $sqlUpdateDebt = "UPDATE debts SET amount = $updateSlAmount, qty = $quantity WHERE id = $debt_id";
                    if ($conn->query($sqlUpdateDebt)) {
                        $messages[] = 'Debt record updated.';
                    } else {
                        $messages[] = 'Error updating the debt record.';
                    }
                }
            } else {
                // Paid status is not "Not Paid"
                $messages[] = 'Paid Status is not Not Paid.';
            }
        }
    } elseif ($quantity > $sale_current_quantity) {
        $remainQty = $quantity - $sale_current_quantity;
        
        $tprice = $current_Amount/$sale_current_quantity;
        $tbene = $current_benefit/$sale_current_quantity;
        
        $updateSlAmount = $quantity * $tprice;
        $updateSlBenefit = $quantity * $tbene;
        $INVqty = $current_inventory_quantity - $remainQty;

        // Start a transaction
        $conn->begin_transaction();

        $error = false;

        // Update the inventory
        $sqlQty = "UPDATE inventory SET quantity = $INVqty WHERE product_id = $product_id";
        if (!$conn->query($sqlQty)) {
            $error = true;
        }

        // Update the sales
        $sqlSales = "UPDATE sales SET quantity = $quantity, total_amount = $updateSlAmount, total_benefit = $updateSlBenefit WHERE sales_id = $s_id";
        if (!$conn->query($sqlSales)) {
            $error = true;
        }

        if ($error) {
            $conn->rollback();
            header('HTTP/1.1 500 Internal Server Error');
            $messages[] = 'Error updating tables';
        } else {
            $conn->commit();

            // Update debt amount
            if ($sale_paid_status === "Not Paid") {
                // Check if a debt record exists for the session and product
                $sqlDebt = "SELECT * FROM debts WHERE id = $debt_id";
                $resultDebt = $conn->query($sqlDebt);

                if ($resultDebt->num_rows == 0) {
                    // Debugging: Add a message to check if this block is executed
                    $messages[] = 'Debt record doesn\'t exist.';
                } else {
                    // Debt record exists, update it
                    $sqlUpdateDebt = "UPDATE debts SET amount = $updateSlAmount, qty = $quantity WHERE id = $debt_id";
                    if ($conn->query($sqlUpdateDebt)) {
                        $messages[] = 'Debt record updated.';
                    } else {
                        $messages[] = 'Error updating the debt record.';
                    }
                }
            } else {
                // Paid status is not "Not Paid"
                $messages[] = 'Paid Status is not Not Paid.';
            }
        }
    }

    // Return the debugging messages
    header('Content-Type: application/json');
    echo json_encode(array('messages' => $messages));
}
?>
