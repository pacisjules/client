<?php
// Include the database connection file
require_once '../connection.php';
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
        
        // $sqlpurchase = "INSERT INTO ``( `store_id`, `product_id`, `unit_id`,`box_or_carton`,`quantity_per_box`, `company_ID`, `spt_id`, `user_id`) 
        // VALUES ('1','$productIdtrans','1','1','$qty_trans','$company','$sptTransfer','$UserID')";

        if ($conn->query($sqltransfer) === TRUE) {            
            echo "Record updated successfully";
        } else {            
            echo "Error updating record: " . $conn->error;
        }
    } else {
        
    }
} else {            
    echo "Error updating record: " . $conn->error;
}

?>