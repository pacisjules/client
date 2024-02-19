<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST["product_id"];
    $taken_quantity = $_POST["taken"];

    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    //Get current Quantity
    $sqlcurrent = "SELECT * FROM inventory WHERE product_id=$product_id";
    $resultInfos = $conn->query($sqlcurrent);
    $rowInfos = $resultInfos->fetch_assoc();

    $current_quantity = $rowInfos['quantity'];
    if ($current_quantity < $taken_quantity) {
        header('HTTP/1.1 201 Created');
        echo "Please add inventory before take current quantity";
    } else {
        $remain_quantity = $current_quantity - $taken_quantity;

        // Update the employee data into the database
        $sql = "UPDATE inventory SET quantity='$remain_quantity'  
        WHERE product_id=$product_id";


        if ($conn->query($sql) === TRUE) {
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "Product Decreased successfully.";

            //Set History
            AddHistory($UserID, "Decreased inventory", $salespt_id);
        } else {
            // Return an error message if the insert failed
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
