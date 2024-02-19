<?php

// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id = $_POST['product_id'];
  $user_id = $_POST['user_id'];
  $spt = $_POST['salespt_id'];
 
  
  
  $sqlqty = "SELECT  INV.quantity, PD.name 
              FROM products PD
              JOIN inventory INV ON PD.id = INV.product_id 
              WHERE  product_id=$product_id";
    $resultqty = $conn->query($sqlqty);
    
       $rowqty = $resultqty->fetch_assoc();
       $getqty = $rowqty['quantity'];
       $getpro_name = $rowqty['name'];

  // Delete the  product
  $sql = "DELETE FROM inventory WHERE product_id=$product_id";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Product Inventory deleted successfully.";
      
      AddHistory($user_id, "Removed all stock  : ".$getqty ." of " . $getpro_name,$spt,"inventoryRemoved");
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
