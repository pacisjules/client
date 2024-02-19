<?php
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $sales_id = $_POST['sales_id'];
  $product_id = $_POST['product_id'];
  $sess_id = $_POST['sess_id'];
  $spt= $_POST['spt'];
  
  
    $sqlcurrent = "
  SELECT
    PD.id,
    PD.price,
    PD.benefit,
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
  
  
  
  $sqlsales = "SELECT
    SL.sales_id,
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
    $sale_paid_status = $rowSale['paid_status'];
    $debt_id = $rowSale['id'];


  $INVqty = $current_inventory_quantity + $sale_current_quantity;

  // Start a transaction
  $conn->begin_transaction();
   $error = false;

 $sqlQty = "UPDATE inventory SET quantity=$INVqty WHERE product_id=$product_id ";
 
 if (!$conn->query($sqlQty)) {
            $error = true;
  }

  // Insert the products
  $sql = "DELETE FROM sales WHERE sales_id=$sales_id";
  
  if (!$conn->query($sql)) {
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
                    $sqlUpdateDebt = "DELETE FROM debts  WHERE id = $debt_id";
                    if ($conn->query($sqlUpdateDebt)) {
                        $messages[] = 'Debt record deleted.';
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
?>
