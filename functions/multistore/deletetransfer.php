<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $trans_id = $_POST['trans_id'];
    $product_id = $_POST['product_id'];
    $store_id = $_POST['store_id'];

    // Get product details
    $sqlqty = "SELECT ST.detail_id, ST.box_or_carton AS stbox, TR.box_or_carton AS trbox,TR.quantity_per_box AS trqty  
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
        $detail = $rowqty['detail_id'];
        $trqty = $rowqty['trqty'];
        $newbox = $stbox + $trbox;

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
            $newqty = $quantityinv - $invqty;

            // Delete the transfer record
            $sqlInve = "DELETE FROM transferHistory WHERE id=?";
            $stmtInve = $conn->prepare($sqlInve);
            $stmtInve->bind_param("i", $trans_id);

            if ($stmtInve->execute()) {
                // Update the store details
                $sql = "UPDATE storedetails SET box_or_carton = ? WHERE detail_id = ?";
                $stmtProduct = $conn->prepare($sql);
                $stmtProduct->bind_param("ii", $newbox, $detail);

                if ($stmtProduct->execute()) {
                    // Update the inventory quantity
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
                    echo "Error updating store: " . $stmtProduct->error;
                }

                $stmtProduct->close();
            } else {
                // Return an error message if the deletion failed
                http_response_code(500); // Internal Server Error
                echo "Error deleting from transfer: " . $stmtInve->error;
            }

            $stmtInve->close();
        } else {
            // Handle the case where inventory details are not found
            http_response_code(404); // Not Found
            echo "Inventory details not found.";
        }
    } else {
        // Handle the case where product details are not found
        http_response_code(404); // Not Found
        echo "Product details not found.";
    }

    $stmt->close();
}
?>
