<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];

    // Retrieve the POST data
    $descriptions = $_POST['descriptions'];
    $amount_paid = $_POST['amount_for_paid'];

    //Get current amount

    $sqlcurrent = "SELECT * FROM debts WHERE id=$id";
    $result = $conn->query($sqlcurrent);

    $rowInfos = $result->fetch_assoc();
    $current = $rowInfos['amount'];
    $current_amount_paid = $rowInfos['amount_paid'];

    //Remain amount
    $remain = $current - $amount_paid;
    $curr_paid = $amount_paid + $current_amount_paid;
    $descr = 'Current amount paid: ' . $amount_paid;


    if ($current < $amount_paid) {
        header('HTTP/1.1 201 Created');
        echo "Entering money is greater than debt of $current";
    } else {
        // Update the debt data into the database
        $sql = "UPDATE debts SET 

    descriptions='$descr', 
    status=2,
    amount=$remain,
    amount_paid=$curr_paid

    WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "Debt Paid updated successfully.";
        } else {
            // Return an error message if the insert failed
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
