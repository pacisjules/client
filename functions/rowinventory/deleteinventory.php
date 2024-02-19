<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $stock_id = $_POST['stock_id'];
    $raw_material_id = $_POST['raw_material_id'];
    $purchase_date = $_POST['purchase_date'];
    $spt = $_POST['spt'];
    $user = $_POST['user_id'];

    $sqlcurrent = "
    SELECT
        PD.id,
        INVE.stock_id,
        INVE.date_added,
        PD.purchase_date
    FROM
         rawstock INVE,
        purchase PD
    WHERE
        INVE.raw_material_id=PD.raw_material_id AND
        INVE.date_added=PD.purchase_date AND
        INVE.raw_material_id=$raw_material_id AND
        INVE.date_added='$purchase_date';  
    ";
    $result = $conn->query($sqlcurrent);

    if (!$result) {
        // Print SQL query and error
        echo "SQL Query: " . $sqlcurrent . "<br>";
        echo "Error:select " . $conn->error;
        header('HTTP/1.1 500 Internal Server Error ');
        exit;
    }

    $rowInfos = $result->fetch_assoc();
    $id = $rowInfos['id'];
    
    
   

    // Update the products
    $sql = " DELETE FROM `rawstock`
            WHERE stock_id=$stock_id";

    if ($conn->query($sql) === TRUE) {
        header('HTTP/1.1 201 Created');
        echo "New PURCHASE DONE SUCCESSFULLY:";

        $sqlcurrentqty = "DELETE FROM `purchase`
            WHERE id=$id";

        if ($conn->query($sqlcurrentqty) === TRUE) {
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "New QUANTITY ENTER IN STOCK:";

            $sqlget_product = "SELECT raw_material_name FROM rawmaterials WHERE raw_material_id =$raw_material_id ";
            $resultInName = $conn->query($sqlget_product);

            if (!$resultInName) {
                // Print SQL query and error
                echo "SQL Query: " . $sqlget_product . "<br>";
                echo "Error: get row " . $conn->error;
                header('HTTP/1.1 500 Internal Server Error ');
                exit;
            }

            $rowName = $resultInName->fetch_assoc();
            $getpro_name = $rowName['raw_material_name'];

            AddHistory($user, "Delete Inventory all quantity of " . $getpro_name, $spt, "RowStockChange");
        } else {
            // Return an error message
            header('HTTP/1.1 500 Internal Server Error  ');
            echo "Error: purchase " . $sqlcurrentqty . "<br>" . $conn->error;
        }
    } else {
        // Return an error message if the update failed
        header('HTTP/1.1 500 Internal Server Error ');
        echo "Error: stock " . $sql . "<br>" . $conn->error;
    }
}
?>
