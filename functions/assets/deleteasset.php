<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];
    $spt = $_POST["spt"];
    $user_id = $_POST["user_id"];
    
     $sqlasset = "SELECT asset_name,quantity FROM asset WHERE id=$id";
    $resultp = $conn->query($sqlasset);
    
       $rowp = $resultp->fetch_assoc();
       $getname = $rowp['asset_name'];
       $getquantity = $rowp['quantity'];
    
    
    //Get if is in Inventory

    $sql = "DELETE FROM asset WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Asset Deleted  successfully.";
      
      AddHistory($user_id, "Remove Asset ".$getname. "And All Quantity: ".$getquantity, $spt, "AssetRemove");
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
    

}
