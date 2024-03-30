<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST["product_id"];
    $company_id= $_POST["company_id"];
    $proquantity = $_POST["quantitypro"]; 
    $prod_session = $_POST["prod_session"];    
    $ibipimo= $_POST["ibipimo"];
    $itempacked= $_POST["itempacked"];

    //Get if is in Inventory
    $gettedliter = $itempacked * $ibipimo;
    $remainliter = $proquantity - $gettedliter;

    if($gettedliter > $proquantity ){
        // Return an error message if the packaging quantity exceeds the product quantity
        header('HTTP/1.1 500 Internal Server Error ');
        echo "Error: Packaging quantity exceeds product quantity.";
    } else {
        $sqlCHECKin = "SELECT COUNT(*) AS NUMBER FROM packaging WHERE product_id=$product_id";
        $resultIn = $conn->query($sqlCHECKin);
        $rowInfosIN = $resultIn->fetch_assoc();
        $ckeckNumber = $rowInfosIN['NUMBER'];

        if($ckeckNumber < 1){
            // Insert the product into packaging table if it doesn't exist
            $sql = "INSERT INTO packaging (product_id, qty, company_id) VALUES ('$product_id', '$itempacked', '$company_id')";

            if ($conn->query($sql) === TRUE) {
                $sqlFinish = "UPDATE finishedproduct SET quantity='$remainliter' WHERE session_id='$prod_session'";
                
                if ($conn->query($sqlFinish) === TRUE) {
                    // Return a success message
                    header('HTTP/1.1 201 Created');
                    echo "Packing successfully.";
                } else {
                    // Return an error message if the update failed
                    header('HTTP/1.1 500 Internal Server Error');
                    echo "Error: " . $sqlFinish . "<br>" . $conn->error;
                }
            } else {
                // Return an error message if the insert failed
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Get current Quantity
            $sqlcurrent = "SELECT * FROM packaging WHERE product_id=$product_id";
            $resultInfos = $conn->query($sqlcurrent);
            $rowInfos = $resultInfos->fetch_assoc();
            $current_quantity = $rowInfos['qty'];
            $remain_quantity = $current_quantity + $itempacked;

            // Update the quantity in the packaging table
            $sql = "UPDATE packaging SET qty='$remain_quantity' WHERE product_id=$product_id";

            if ($conn->query($sql) === TRUE) {
                $sqlFinish = "UPDATE finishedproduct SET quantity='$remainliter' WHERE session_id='$prod_session'";
                
                if ($conn->query($sqlFinish) === TRUE) {
                    // Return a success message
                    header('HTTP/1.1 201 Created');
                    echo "Packing successfully.";
                } else {
                    // Return an error message if the update failed
                    header('HTTP/1.1 500 Internal Server Error');
                    echo "Error: " . $sqlFinish . "<br>" . $conn->error;
                }
            } else {
                // Return an error message if the update failed
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>
