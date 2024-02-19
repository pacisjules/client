<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $sales_id  = $_POST['sales_id'];


  //Get sales info
  $sqlcurrent="SELECT
  SL.quantity AS Sales_Quantity, 
  INVE.quantity AS Inventory_Quantity,
  INVE.product_id AS Prod_Id
FROM
  sales SL,
  inventory INVE
WHERE
SL.product_id=INVE.product_id
AND
SL.sales_id=$sales_id";

  $result = $conn->query($sqlcurrent);
  $rowInfos = $result->fetch_assoc();
  $current_quantity = $rowInfos['Sales_Quantity'];
  $Inventory_quantity = $rowInfos['Inventory_Quantity'];
  $ProductID = $rowInfos['Prod_Id'];

  $INVqty= $current_quantity + $Inventory_quantity;


  // Update the employee data into the database
  $sqlQty = "UPDATE inventory SET quantity=$INVqty
  WHERE product_id=$ProductID";




  // Insert the  products
  $sql = "DELETE FROM sales WHERE sales_id=$sales_id";

  if ($conn->query($sql) === TRUE && $conn->query($sqlQty) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Sales deleted successfully.";
  } else {
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
