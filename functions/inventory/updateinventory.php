<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST["product_id"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Get the form data
    $quantity = $_POST['quantity'];
    $alert_quantity = $_POST['alert_quantity'];
    
    
    $sqlqty = "SELECT quantity FROM inventory WHERE  product_id=$product_id";
    $resultqty = $conn->query($sqlqty);
    
       $rowqty = $resultqty->fetch_assoc();
       $getqty = $rowqty['quantity'];
    

    // Update the employee data into the database
    $sql = "UPDATE inventory SET quantity='$quantity', alert_quantity='$alert_quantity'  
    WHERE product_id=$product_id";


    if ($conn->query($sql) === TRUE) {
        $sqlget_product = "SELECT name FROM products WHERE id=$product_id";
        $resultInName = $conn->query($sqlget_product);
    
       $rowName = $resultInName->fetch_assoc();
       $getpro_name = $rowName['name'];
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Inventory Updated successfully.";

        //Set History
        AddHistory($UserID, "Edited Quantity of " . $getpro_name . " From :".$getqty ." To: ".$quantity,$salespt_id,"inventoryChanged");
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
