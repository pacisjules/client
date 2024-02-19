<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST["product_id"];
    $added_quantity = $_POST["quantity"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];
    $alert_quantity=5;

    
    //Get if is in Inventory

    $sqlCHECKin = "SELECT COUNT(*) AS NUMBER FROM inventory WHERE product_id=$product_id";
    $resultIn = $conn->query($sqlCHECKin);

    $rowInfosIN = $resultIn->fetch_assoc();
    
    $ckeckNumber = $rowInfosIN['NUMBER'];

    if($ckeckNumber<1){
        // Insert the  products
  $sql = "INSERT INTO inventory (product_id, quantity, alert_quantity)
  VALUES ('$product_id', '$added_quantity','$alert_quantity')";

  if ($conn->query($sql) === TRUE) {
      $sqlget_product = "SELECT name FROM products WHERE id=$product_id";
        $resultInName = $conn->query($sqlget_product);
    
       $rowName = $resultInName->fetch_assoc();
       $getpro_name = $rowName['name'];
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
      AddHistory($UserID,"Added Quantity: ".$added_quantity." of " . $getpro_name,$salespt_id,"inventoryIn");
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
    }else{
    //Get current Quantity
    $sqlcurrent = "SELECT * FROM inventory WHERE product_id=$product_id";
    $resultInfos = $conn->query($sqlcurrent);
    $rowInfos = $resultInfos->fetch_assoc();

    $current_quantity = $rowInfos['quantity'];
    

    $remain_quantity = $current_quantity + $added_quantity;
   

    // Update the employee data into the database
    $sql = "UPDATE 
             inventory 
            SET quantity='$remain_quantity'
        WHERE product_id=$product_id";


    if ($conn->query($sql) === TRUE) {
        $sqlget_product = "SELECT name FROM products WHERE id=$product_id";
        $resultInName = $conn->query($sqlget_product);
    
       $rowName = $resultInName->fetch_assoc();
       $getpro_name = $rowName['name'];
        // Return a success message
        header('HTTP/1.1 201 Created');
        //echo "Product inventory Increased successfully.";

        //Set History
        AddHistory($UserID,"Added Quantity: ".$added_quantity." of " . $getpro_name,$salespt_id,"inventoryIn");
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    } 
    }


}
