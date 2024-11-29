<?php
session_start();
// Include the database connection file
require_once '../connection.php';

$UserID=$_SESSION['user_id'];
$company = $_SESSION['company_ID'];

$producIdfrom = $_POST['productFrom'];
$productIdtrans = $_POST['productTo'];

$qty = $_POST['qtyFrom'];
$qty_trans = $_POST['qty_trans'];

$sptFrom = $_POST['sptFrom'];
$sptTransfer = $_POST['sptTransfer'];
$requestID= $_POST['requestID'];


$remainqtyfrom=$qty-$qty_trans;

// Get current Quantity from
$sqlcurrent = "SELECT * FROM inventory WHERE product_id=$productIdtrans";
$resultInfos = $conn->query($sqlcurrent);
$rowInfos = $resultInfos->fetch_assoc();
$current_quantity_trans = $rowInfos['quantity'];
$newqtytrans_now=$current_quantity_trans+$qty_trans;



// Get current purchase price from server
$sqlpurchase = "SELECT * FROM purchase WHERE product_id=$producIdfrom ORDER BY purchase_date DESC LIMIT 1";
$resultInfos = $conn->query($sqlpurchase);
$rowInfos = $resultInfos->fetch_assoc();
$priceper_unity = $rowInfos['price_per_unity'];
$total_price=$priceper_unity*$qty_trans;


// Update quantity from inventory
$sqlup = "UPDATE 
     inventory 
    SET 
    quantity='$remainqtyfrom' 
    WHERE product_id=$producIdfrom";


if ($conn->query($sqlup) === TRUE) {

    // Update quantity to inventory
    $sqlup = "UPDATE 
     inventory 
    SET 
    quantity='$newqtytrans_now' 
    WHERE product_id=$productIdtrans";
    if ($conn->query($sqlup) === TRUE) {
        $sqltransfer = "UPDATE requestransfer SET request_status=2, received_qty='$qty_trans' WHERE id=$requestID AND request_status=1";
        
        $sqlpurchase = "INSERT INTO `purchase`( `store_id`, `product_id`, `unit_id`, `container`, `company_ID`, `spt_id`, `user_id`, `quantity`,`price_per_unity`,`total_price`) 
        VALUES ('1','$productIdtrans','1','1','$company','$sptTransfer','$UserID', '$qty_trans','$priceper_unity','$total_price')";

        if ($conn->query($sqltransfer) === TRUE && $conn->query($sqlpurchase) === TRUE) 
        {
            echo "Record updated successfully";
            header('HTTP/1.1 201 Created');
        } else {            
            echo "Error updating record: " . $conn->error;
        }
    } else {
        
    }
} else {            
    echo "Error updating record: " . $conn->error;
}

?>