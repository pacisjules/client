<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Sanitize and validate input values
    $trans_id = $_POST["trans_id"];
    $product_id = $_POST["product_id"];
    $created_at = $_POST['created_at'];
    $store_id = $_POST['store_id'];
    $quantity_per_box = $_POST['quantity'];
    $box_or_carton = $_POST['box'];
    $UserID = $_POST["user_id"];
    
echo "Product ID: $product_id, Store ID: $store_id, Trans ID: $trans_id<br>";

// Get product details
$sqlqty = "SELECT ST.detail_id, ST.box_or_carton AS stbox, TR.box_or_carton AS trbox, TR.quantity_per_box AS trqty,TR.created_at  
           FROM storedetails ST, transferHistory TR 
           WHERE ST.product_id = ? AND ST.store_id = ? AND TR.id=?";
$stmt = $conn->prepare($sqlqty);
$stmt->bind_param("iii", $product_id, $store_id, $trans_id);
$stmt->execute();
$resultqty = $stmt->get_result();


    // Check if there are rows in the result
    if ($resultqty->num_rows > 0) {
        $rowqty = $resultqty->fetch_assoc();
        $stbox = $rowqty['stbox'];
        $trbox = $rowqty['trbox'];
        $trqty = $rowqty['trqty'];
        $date =  $rowqty['created_at'];
        $detail = $rowqty['detail_id'];
        
        if($trbox < $box_or_carton){
            
            $newbox = $stbox - ($box_or_carton - $trbox);
        }else{
            $newbox = $stbox + ($trbox - $box_or_carton);
        }
        
        
         $sqlinv = "SELECT id, container, item_per_container, quantity  
                   FROM inventory 
                   WHERE product_id = ?";
        $stmtinv = $conn->prepare($sqlinv);
        $stmtinv->bind_param("i", $product_id);
        $stmtinv->execute();
        $resultinv = $stmtinv->get_result();

        if ($resultinv->num_rows > 0) {
            $rowinv = $resultinv->fetch_assoc();  
            $idinv = $rowinv['id'];
            $containerinv = $rowinv['container'];
            $item_per_containerinv = $rowinv['item_per_container'];
            $quantityinv = $rowinv['quantity'];
            $invqty =  $trbox *  $trqty;
            $invupdate = $quantity_per_box * $box_or_carton;
           
           if($invqty < $invupdate){
             $newqty = $quantityinv +($invupdate - $invqty) ;  
           }else{
             $newqty = $quantityinv - ( $invqty - $invupdate) ;     
           }
           

        // Update the transfer history
        $sqlUpdateTransfer = "UPDATE transferHistory SET box_or_carton=?, quantity_per_box=?, created_at=? WHERE id=?";
        $stmtUpdateTransfer = $conn->prepare($sqlUpdateTransfer);
        $stmtUpdateTransfer->bind_param("iisi", $box_or_carton, $quantity_per_box, $date, $trans_id);

        if ($stmtUpdateTransfer->execute()) {
            // Update the storedetails
            $sqlUpdateStoreDetails = "UPDATE storedetails SET box_or_carton=? WHERE detail_id=?";
            $stmtUpdateStoreDetails = $conn->prepare($sqlUpdateStoreDetails);
            $stmtUpdateStoreDetails->bind_param("ii", $newbox, $detail);

            if ($stmtUpdateStoreDetails->execute()) {
                
                $sqlupinv = "UPDATE inventory SET quantity = ? WHERE id = ?";
                    $stmtsqlupinv = $conn->prepare($sqlupinv);
                    $stmtsqlupinv->bind_param("ii", $newqty, $idinv);

                    if ($stmtsqlupinv->execute()) {
                        // Return a success message
                        http_response_code(201); // Created
                        echo "Inventory updated successfully.";
                    } else {
                        // Return an error message if the update failed
                        http_response_code(500); // Internal Server Error
                        echo "Error updating inventory: " . $stmtsqlupinv->error; 
                    }
            } else {
                // Return an error message if the update failed
                http_response_code(500); // Internal Server Error
                echo "Error updating store details: " . $stmtUpdateStoreDetails->error;
            }

            $stmtUpdateStoreDetails->close();
        } else {
            // Return an error message if the update failed
            http_response_code(500); // Internal Server Error
            echo "Error updating transfer history: " . $stmtUpdateTransfer->error;
        }

        $stmtUpdateTransfer->close();
        
        }else{
           http_response_code(404); // Not Found
        echo "inventory details not found.";  
        }    
        
    } else {
        // Handle the case where product details are not found
        http_response_code(404); // Not Found
        echo "Product details not found.";
    }

    $stmt->close();
}
?>
