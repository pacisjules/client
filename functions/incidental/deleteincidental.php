<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $incidental_id  = $_POST['incidental_id'];


  //Get sales info
  $sqlcurrent="SELECT
  SL.quantity AS Inci_Quantity, 
  INVE.quantity AS Inventory_Quantity,
  INVE.product_id AS Prod_Id
FROM
  incidental SL,
  inventory INVE
WHERE
SL.product_id=INVE.product_id
AND
SL.inc_id=$incidental_id";

  $result = $conn->query($sqlcurrent);
  $rowInfos = $result->fetch_assoc();
  $current_quantity = $rowInfos['Inci_Quantity'];
  $Inventory_quantity = $rowInfos['Inventory_Quantity'];
  $ProductID = $rowInfos['Prod_Id'];

  $INVqty= $current_quantity + $Inventory_quantity;


  // Update the employee data into the database
  $sqlQty = "UPDATE inventory SET quantity=$INVqty
  WHERE product_id=$ProductID";



  // Insert the  products
  $sql = "DELETE FROM incidental WHERE inc_id=$incidental_id";

  if ($conn->query($sql) === TRUE && $conn->query($sqlQty) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Incidental deleted successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
