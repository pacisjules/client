<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $production_id = $_POST["production_id"];
    $store_id = $_POST["store_id"];
    $product_id = $_POST["product_id"];
    $company_id = $_POST["company_id"];
    $quantity = $_POST["transf_qty"];
    $created_at = $_POST["created_at"];
    $UserID = $_POST["user_id"];
    $item =1;


    
    //Get if is in Inventory

    $sqlCHECKin = "SELECT COUNT(*) AS NUMBER FROM storedetails WHERE product_id=$product_id AND store_id=$store_id";
    $resultIn = $conn->query($sqlCHECKin);

    $rowInfosIN = $resultIn->fetch_assoc();
    
    $ckeckNumber = $rowInfosIN['NUMBER'];

    if($ckeckNumber<1){
        // Insert the  products
  $sql = "INSERT INTO storedetails (store_id,product_id,unit_id, box_or_carton, quantity_per_box,company_ID,user_id)
  VALUES ('$store_id','$product_id', 5,'$quantity','$item','$company_id','$UserID')";

  if ($conn->query($sql) === TRUE) {
      $sqlget_product = "SELECT name FROM products WHERE id=$product_id";
        $resultInName = $conn->query($sqlget_product);
    
       $rowName = $resultInName->fetch_assoc();
       $getpro_name = $rowName['name'];
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
     // AddHistory($UserID,"Added Quantity: ".$quantity." of " . $getpro_name,$salespt_id,"inventoryIn");
    
     $sqlFinish = "UPDATE 
             finishedproduct 
            SET status=4
        WHERE id=$production_id";
        
  if ($conn->query($sqlFinish) === TRUE) {
    $sqltrsns = "INSERT INTO fromproductiontostock (`store_id`, `product_id`, `quantity`, `company_id`, `status`, `created_at`,`user_id`)
  VALUES ('$store_id','$product_id','$quantity','$company_id',1,'$created_at',$UserID)";
  
  if ($conn->query($sqltrsns) === TRUE) {
      
       // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
     // AddHistory($UserID,"Transferred Quantity: ".$quantity." of " . $getpro_name,$salespt_id,"TransferStock");
      
      
  }else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sqltrsns . "<br>" . $conn->error;
  }
  
     
      
}
      
      
      
      
      
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
    }else{
    //Get current Quantity
    $sqlcurrent = "SELECT * FROM storedetails WHERE product_id=$product_id AND store_id=$store_id";
    $resultInfos = $conn->query($sqlcurrent);
    $rowInfos = $resultInfos->fetch_assoc();

    $current_quantity = $rowInfos['box_or_carton'];
   

    $remain_quantity = $current_quantity + $quantity;

    // Update the employee data into the database
    $sql = "UPDATE 
             storedetails 
            SET box_or_carton='$remain_quantity'
        WHERE product_id=$product_id AND store_id=$store_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        //echo "Product inventory Increased successfully.";

        
        $sqlFinish = "UPDATE 
        finishedproduct 
       SET status=4
   WHERE id=$production_id";
        
     if ($conn->query($sqlFinish) === TRUE) {
        $sqltrsns = "INSERT INTO fromproductiontostock (`store_id`, `product_id`, `quantity`, `company_id`, `status`, `created_at`,`user_id`)
        VALUES ('$store_id','$product_id','$quantity','$company_id',1,'$created_at',$UserID)";
        
  if ($conn->query($sqltrsns) === TRUE) {
      
       // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory successfully.";
    
      
  }else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sqltrsns . "<br>" . $conn->error;
  }
  
  
     
      
}
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    } 
    }


}
