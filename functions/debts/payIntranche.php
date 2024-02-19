<?php
require_once '../connection.php';
require_once '../debtssystemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $amount = $_POST["amount"];
    $status = 1;
    $descriptions = $_POST['descriptions'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];
    
    $sql_query = "SELECT sum(amount) as t_amount FROM debts where customer_id=$id and status=1";
    $sql_result = $conn->query($sql_query);
    $amount_row = $sql_result->fetch_assoc();
    $current_amount = $amount_row['t_amount'];

    if ($amount > $current_amount) {
        echo "Paid Amount is greater than the current debt: " . $current_amount;
    } else {
        $query = "SELECT * FROM debts where customer_id=$id and status=1";
        $result = $conn->query($query);
        
        $comp = array();

        while ($row = $result->fetch_assoc()) {
            $com = new stdClass();
            $com->id = $row['id'];
            $com->cash = $row['amount'];
            $com->cpaid = $row['amount_paid'];
            $comp[] = $com;
        }

        // Sort the $comp array by cash amount in ascending order
        usort($comp, function ($a, $b) {
            return $a->cash - $b->cash;
        });
        
        $taken = array();
        $total_taken = 0;

        // Create a for loop
        for ($i = 0; $i < count($comp); $i++) {
            $obj = $comp[$i];

            if ($amount <= $obj->cash) {
                $tak = new stdClass();
                $tak->id = $obj->id;
                $tak->cash = $obj->cash;
                $tak->cpaid = $obj->cpaid;
                $taken[] = $tak;

                if (array_sum(array_column($taken, 'cash')) >= $amount) {
                    break;
                }
            }
        }
        
        // Update the debt data into the database
        foreach ($taken as $tak) {
            $settedid = $tak->id;
            $settedcash = 0;
            $settedpaid = $tak->cpaid + $tak->cash;

            if ($tak->cash > $amount) {
                $settedcash = $tak->cash;
                $settedpaid = $tak->cpaid + $amount;
            }
            
            $sql_updates = "
                UPDATE debts SET 
                descriptions='$descriptions', 
                status='$status',
                amount_paid='$settedpaid',
                amount='$settedcash'
                WHERE id='$settedid'";

            if ($conn->query($sql_updates) !== TRUE) {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . $sql_updates . "<br>" . $conn->error;
                return;
            }
        }
        
        header('HTTP/1.1 201 Created');
        echo "Debt Paid updated successfully.\n\n";
        
        
        $sql_histo = "SELECT sum(amount) as t_amount, sum(amount_paid) as p_amount FROM debts where customer_id=$id and status=1";
    $histresult = $conn->query($sql_histo);
    $amount_histo = $histresult->fetch_assoc();
    $t_amount = $amount_histo['t_amount'];
    $paid_amount = $amount_histo['p_amount'];
        $balance = $t_amount - $paid_amount;
        
        debtHistory($user_id, $id,"Pay in Installment", $amount, $balance, $spt);
        
        echo json_encode($taken);
    }
}
?>
