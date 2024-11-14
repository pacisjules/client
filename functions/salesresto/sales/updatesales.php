<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id  = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $s_id = $_POST['s_id'];

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
  $current_price = $rowInfos['price'];
  $current_inventory_quantity = $rowInfos['quantity'];
  $AlertQuantity = $rowInfos['alert_quantity'];
  $Benefits = $rowInfos['benefit'];

  //Get Sales current infos
  $sqlcurrentsalesinfo = "select * from sales where sales_id=$s_id";
  $resultInfo = $conn->query($sqlcurrentsalesinfo);
  $rowSalesInfo = $resultInfo->fetch_assoc();
  $sale_current_quantity = $rowSalesInfo['quantity'];

  //Calculate
  //Down
  if($quantity<$sale_current_quantity){
    $remainQty=$sale_current_quantity-$quantity;
    $updateSlAmount=$quantity * $current_price;
    $updateSlBenefit=$quantity * $Benefits;

    $INVqty=$current_inventory_quantity + $remainQty;

    // Update the employee data into the database
    $sqlQty = "UPDATE inventory SET quantity=$INVqty
    WHERE product_id=$product_id";

    $sqlSales="UPDATE sales SET quantity=$quantity,
    total_amount=$updateSlAmount,
    total_benefit=$updateSlBenefit
    WHERE sales_id=$s_id
    ";


    if ($conn->query($sqlSales) === TRUE && $conn->query($sqlQty) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Sale product Updated successfully.";
    }


  }else if($quantity>$sale_current_quantity){
    $remainQty=$quantity-$sale_current_quantity;
    $updateSlAmount=$quantity * $current_price;
    $updateSlBenefit=$quantity * $Benefits;

    $INVqty=$current_inventory_quantity - $remainQty;

    // Update the employee data into the database
    $sqlQty = "UPDATE inventory SET quantity=$INVqty
    WHERE product_id=$product_id";

    $sqlSales="UPDATE sales SET quantity=$quantity,
    total_amount=$updateSlAmount,
    total_benefit=$updateSlBenefit
    WHERE sales_id=$s_id
    ";


    if ($conn->query($sqlSales) === TRUE && $conn->query($sqlQty) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Sale product Updated successfully.";
    }
  }

}
