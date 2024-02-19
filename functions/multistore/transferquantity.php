<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $company = $_POST["company"];
    $spt = $_POST["spt"];
    $product_id = $_POST["product_id"];
    $store_id = $_POST["store_id"];
    $quantity = $_POST["quantity"];
    $UserID = $_POST["user_id"];
    $alert_quantity = 5;
    
    
    
    
         $sqlstore = "SELECT * FROM storedetails WHERE product_id=$product_id AND store_id =$store_id ";
    $resultInfosstore = $conn->query($sqlstore);
    $rowInfostore = $resultInfosstore->fetch_assoc();

    $current_store = $rowInfostore['quantity'];
    
    if($current_store<$quantity){
         // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error THE QUANTITY IS GREATER THAN STOCK');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }else{
        
        
       
    $remain_quantity = $current_store - $quantity;
    
    $sqlupdateBigStock = "UPDATE 
             storedetails 
            SET quantity='$remain_quantity'
        WHERE product_id=$product_id AND store_id =$store_id ";
       
    
    if ($conn->query($sqlupdateBigStock) === TRUE) {
        
        $sqltransfer = "INSERT INTO `transferHistory`( `store_id`, `product_id`, `quantity`, `company_ID`, `spt_id`, `user_id`) 
        VALUES ('$store_id','$product_id','$quantity','$company','$spt','$UserID')";
        
        if ($conn->query($sqltransfer) === TRUE) {
          header('HTTP/1.1 201 Created');
      echo "add in Transfer table successfully.";    
        }else{
          header('HTTP/1.1 500 Internal Server Error for Transfer table history');
      echo "Error: " . $sql . "<br>" . $conn->error;  
        }
        
       header('HTTP/1.1 201 Created');
      echo "Update Storedetails successfully.";  
    }
    
    

    //Get if is in Inventory

    $sqlCHECKin = "SELECT COUNT(*) AS NUMBER FROM inventory WHERE product_id=$product_id AND spt_id=$spt";
    
    $resultIn = $conn->query($sqlCHECKin);

    $rowInfosIN = $resultIn->fetch_assoc();
    
    $ckeckNumber = $rowInfosIN['NUMBER'];

    if($ckeckNumber<1){
        
        // Insert the  products
  $sqlup = "INSERT INTO inventory (product_id, quantity, alert_quantity,company_ID,spt_id)
  VALUES ('$product_id', '$quantity','$alert_quantity','$company','$spt')";

  if ($conn->query($sqlup) === TRUE) {
    $sqlproduct = "SELECT 
             name  
            FROM products
        WHERE id=$product_id ";
        $resultInName = $conn->query($sqlproduct);
    
      $rowName = $resultInName->fetch_assoc();
      $getpro_name = $rowName['name'];
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory Transfer uPDATE successfully.";

        //Set History
        AddHistory($UserID,"Added Quantity: ".$quantity." of " . $getpro_name,$spt,"inventoryIn");
        
         
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error FAIL TO INSERT QUANTITY CHECH PHP CODES AND DATABASE');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
   
  
    }else{
    //Get current Quantity
    $sqlcurrent = "SELECT * FROM inventory WHERE product_id=$product_id AND spt_id=$spt";
    $resultInfos = $conn->query($sqlcurrent);
    $rowInfos = $resultInfos->fetch_assoc();

    $current_quantity = $rowInfos['quantity'];
    

    $remain = $current_quantity + $quantity;
   

    // Update the employee data into the database
    $sqlup = "UPDATE 
             inventory 
            SET quantity='$remain'
        WHERE product_id=$product_id AND spt_id=$spt";


    if ($conn->query($sqlup) === TRUE) {
          $sqlproduct = "SELECT 
             name  
            FROM products
        WHERE id=$product_id ";
        $resultInName = $conn->query($sqlproduct);
    
      $rowName = $resultInName->fetch_assoc();
      $getpro_name = $rowName['name'];
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory Transfer uPDATE successfully.";

        //Set History
        AddHistory($UserID,"Added Quantity: ".$quantity." of " . $getpro_name,$spt,"inventoryIn");
        
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error FAIL TO INSERT QUANTITY CHECH PHP CODES AND DATABASE');
        echo "Error: " . $sql . "<br>" . $conn->error;
    } 
    }
}

}