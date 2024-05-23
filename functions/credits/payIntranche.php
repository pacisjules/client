<?php
require_once '../connection.php';
require_once '../debtssystemhistory.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $amount = $_POST["amount"];
    $status = 1;
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];
    
   
    
    // Retrieve the POST data
    // $qty = $POST['qty'];
    // $amount = $_POST['amount'];
    // $amount_paid = $_POST['amount_paid'];
    // $sales_point_id = $_POST['sales_point_id'];
    
    // Check if the entered amount is greater than the total debt
    $sql_total_debt = "SELECT SUM(amount - amount_paid) as total_debt FROM credits WHERE supplier_id = $id AND status = 1";
    $total_debt_result = $conn->query($sql_total_debt);
    $total_debt_row = $total_debt_result->fetch_assoc();
    $total_debt = $total_debt_row['total_debt'];
    $balance = $total_debt - $amount;
    
    debtHistory($user_id, $id, "Pay in Installment", $amount, $balance, $spt);
    
   
     
    
    
    // Fetch all debts for the customer ordered by lowest remaining amount first
    $sql_query = "SELECT * FROM credits WHERE supplier_id = $id AND status = 1 ORDER BY (amount - amount_paid) ASC";
    $result = $conn->query($sql_query);
    
    // Loop through each debt to determine the amount to be paid for each
    while ($row = $result->fetch_assoc()) {
        $debt_id = $row['id'];
        $debt_amount = $row['amount'];
        $debt_paid = $row['amount_paid'];
        $remaining_amount = $debt_amount - $debt_paid;

        // Check if the remaining amount for this debt is greater than 0
        if ($remaining_amount > 0) {
            // Determine the amount to be paid for this debt
            $paid_amount_for_debt = min($remaining_amount, $amount);
            
            // Update the debt record
            $new_paid_amount = $debt_paid + $paid_amount_for_debt;
            $new_remaining_amount = $debt_amount - $new_paid_amount;
            
            // Check if the remaining balance is zero and update status accordingly
            if ($new_remaining_amount == 0) {
                $status = 2;
            }else{
              $status = 1;  
            }

            $sql_update = "UPDATE credits SET amount_paid = $new_paid_amount, status = $status WHERE id = $debt_id";
            
            if ($conn->query($sql_update) !== TRUE) {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error updating debt record: " . $conn->error;
                return;
            }
            
            // Deduct the paid amount from the total amount
            $amount -= $paid_amount_for_debt;
            
            // If the paid amount is fully utilized, break out of the loop
            if ($amount <= 0) {
                break;
    
}

    if ($amount > $total_debt) {
        header('HTTP/1.1 400 Bad Request');
        echo "Paid amount exceeds total debt.";
        return;
    }
            }
        }

    // Calculate the remaining balance
    
   
    // Respond with success message and updated debt records
    header('HTTP/1.1 201 Created');
    echo json_encode(['message' => 'credit paid successfully.', 'balance' => $balance]);
    
}
?>
