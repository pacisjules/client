<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST["product_id"];
    $company_id = $_POST["company_id"];
    $salespt_id = $_POST["salespt_id"];
    $quantity = $_POST["quantity"];
    $alert_quantity =5;


    
    //Get if is in Inventory

    $sqlCHECKin = "SELECT COUNT(*) AS NUMBER FROM inventory WHERE product_id=$product_id";
    $resultIn = $conn->query($sqlCHECKin);

    $rowInfosIN = $resultIn->fetch_assoc();
    
    $ckeckNumber = $rowInfosIN['NUMBER'];

    if($ckeckNumber<1){
        // Insert the  products
  $sql = "INSERT INTO inventory (product_id, quantity, alert_quantity,company_ID,spt_id)
  VALUES ('$product_id', '$quantity','$alert_quantity','$company_id','$salespt_id')";

  if ($conn->query($sql) === TRUE) {
      $sqlget_product = "SELECT name FROM products WHERE id=$product_id";
        $resultInName = $conn->query($sqlget_product);
    
       $rowName = $resultInName->fetch_assoc();
       $getpro_name = $rowName['name'];
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
      AddHistory($UserID,"Added Quantity: ".$quantity." of " . $getpro_name,$salespt_id,"inventoryIn");
    
     $sqlFinish = "UPDATE 
             packaging 
            SET qty=0
        WHERE product_id=$product_id";
        
  if ($conn->query($sqlFinish) === TRUE) {

  
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
      AddHistory($UserID,"Transferred Quantity: ".$added_quantity." of " . $getpro_name,$salespt_id,"TransferStock");
      
}
      
      
      
      
      
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
    $current_Aquantity = $rowInfos['alert_quantity'];

    $remain_quantity = $current_quantity + $quantity;

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
        
        
         $sqlFinish = "UPDATE 
         packaging 
        SET qty=0
    WHERE product_id=$product_id";
        
    if ($conn->query($sqlFinish) === TRUE) {
     
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
      AddHistory($UserID,"Transferred Quantity: ".$quantity." of " . $getpro_name,$salespt_id,"TransferStock");
      
}
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    } 
    }


}
