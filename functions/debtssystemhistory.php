<?php

require_once 'connection.php';
// Create connection
$network = new mysqli($servername, $username, $password, $dbname);

function debtHistory($user_id, $customer_id,$action, $amount_paid, $balance, $spt)
{
    global $network;

    // Insert the history data into the database
    $sql = "INSERT INTO debts_history (user_id,customer_id, action, amount_paid,current_balance,spt) VALUES ('$user_id', '$customer_id','$action', '$amount_paid', '$balance','$spt')";

    if ($network->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "History added successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $network->error;
    }
}
