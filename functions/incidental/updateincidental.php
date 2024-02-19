<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id  = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $cause = $_POST['cause'];
  $inc_id = $_POST['inc_id'];
  
   //Get Product price and Current inventory quantity
  $sqlcurrent = "
  SELECT
    PD.id,
    PD.price,
    PD.benefit,
    INVE.quantity,
    INVE.alert_quantity
    FROM
    products PD,
    inventory INVE
    WHERE
    PD.id=INVE.product_id AND
    PD.id=$product_id
  ";
  $result = $conn->query($sqlcurrent);
  $rowInfos = $result->fetch_assoc();
  $current_inventory_quantity = $rowInfos['quantity'];
  
  //Get Incidental current infos
  $sqlcurrentqty = "select quantity from incidental where inc_id=$inc_id";
  $resultInfo = $conn->query($sqlcurrentqty);
  $rowIncidInfo = $resultInfo->fetch_assoc();
  $incidental_current_quantity = $rowIncidInfo['quantity'];

  if($quantity<$incidental_current_quantity){
      $remainQty=$incidental_current_quantity-$quantity;
      $INVqty=$current_inventory_quantity + $remainQty;
      
      // Update the employee data into the database
      $sqlInvetnory = "UPDATE inventory SET quantity=$INVqty WHERE product_id=$product_id";
      $sqlIncidi="UPDATE incidental SET quantity=$quantity, cause='$cause' WHERE inc_id=$inc_id";
      
      
      if ($conn->query($sqlInvetnory) === TRUE && $conn->query($sqlIncidi) === TRUE){
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Incidental Updated successfully UP.";
      }
      
    }else if($quantity>$incidental_current_quantity){
      
      $remainQty=$quantity-$incidental_current_quantity;
      $INVqty=$current_inventory_quantity - $remainQty;
      
      // Update the employee data into the database
      $sqlInvetnory = "UPDATE inventory SET quantity=$INVqty WHERE product_id=$product_id";
      $sqlIncidi="UPDATE incidental SET quantity=$quantity, cause='$cause' WHERE inc_id=$inc_id";
      
      
      if ($conn->query($sqlInvetnory) === TRUE && $conn->query($sqlIncidi) === TRUE){
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Incidental Updated successfully DOWN.";
      }
    }

}
