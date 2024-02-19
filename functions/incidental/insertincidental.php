<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
     
    // Retrieve the POST data
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $cause = $_POST["cause"];
    $quantity=$_POST['quantity'];
    
    //Get Product price and Current inventory quantity
  $sqlcurrent = "
  SELECT
    PD.id,
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

    
    // Insert the user data into the database
    $sql = "INSERT INTO incidental (product_id, user_id, cause, quantity) 
    VALUES ('$product_id', '$user_id', '$cause', '$quantity')";
    
    $remain_quantity = $current_inventory_quantity - $quantity;
    
      // Update the employee data into the database
  $sqlInventory = "UPDATE inventory SET quantity='$remain_quantity'  
  WHERE product_id=$product_id";

    if ($conn->query($sql) === TRUE && $conn->query($sqlInventory) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Incidental created successfully.";
    } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}