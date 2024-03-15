<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $raw_material_id = $_POST['row_id'];
    $container = $_POST['container'];
    $qtyperbox = $_POST['qtyperbox'];
    $company = $_POST['company'];
    $user = $_POST['user_id'];

    $sqlcurrent = "
    SELECT
        *
    FROM
         rawstock    
    WHERE
        raw_material_id=$raw_material_id;  
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
    $id = $rowInfos['stock_id'];
    $box = $rowInfos['box_container'];
    $tot = $rowInfos['quantity_in_stock'];

    $total = $container * $qtyperbox;
    
    
   

    // Update the products
    $sql = "UPDATE `rawstock` SET
            `box_container`='$container',
            `qty_per_box`='$qtyperbox',
            `quantity_in_stock`='$total'
            WHERE stock_id=$id";

    if ($conn->query($sql) === TRUE) {
        header('HTTP/1.1 201 Created');
        echo "New row inventory updated SUCCESSFULLY:";

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

           AddHistory($user, "Edit Inventory of " . $getpro_name . "Box/carton  From : " . $box . " to " . $container . " /nAnd total qty " . $tot . " to " . $total, $company, "RowStockChange");
        
    } else {
        // Return an error message if the update failed
        header('HTTP/1.1 500 Internal Server Error ');
        echo "Error: stock " . $sql . "<br>" . $conn->error;
    }
}
?>
