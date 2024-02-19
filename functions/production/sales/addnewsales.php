<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$length = 12; // Length of the random string
$randomString = base64_encode(random_bytes($length));

// Remove any non-alphanumeric characters
$randomString = preg_replace('/[^a-zA-Z0-9]/', '', $randomString);

// Trim the string to the desired length
$Session_sale_ID = substr($randomString, 0, $length);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the form data
  $product_id  = $_POST['product_id'];
  $sales_point_id = $_POST['sales_point_id'];
  $quantity = $_POST['quantity'];
  $sales_type = $_POST['sales_type'];
  $paid_status = $_POST['paid_status'];
  $service_amount = $_POST['service_amount'];

  $cust_name = $_POST['cust_name'];
  $phone = $_POST['phone'];

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

if($sales_type=1){
//Products
if ($quantity > $current_inventory_quantity) {
  header('HTTP/1.1 201 Created');
  echo "Impossible you are asking more quantity current quantity are: $current_inventory_quantity";
} else {
  $total_amount = $quantity * $current_price;
  $sales_price = $current_price;
  $total_benefit = $quantity * $Benefits;

  //Insert the  products
  $sql = "INSERT INTO sales (product_id,sess_id, sales_point_id, quantity, sales_price, total_amount, sales_type, paid_status, total_benefit,cust_name, phone)
  VALUES ('$product_id','$Session_sale_ID', '$sales_point_id','$quantity','$sales_price', '$total_amount','$sales_type', '$paid_status', '$total_benefit', '$cust_name','$phone')";

  //Update decrease in inventory quantity

  $remain_quantity = $current_inventory_quantity - $quantity;

  // Update the employee data into the database
  $sqlInventory = "UPDATE inventory SET quantity='$remain_quantity'  
  WHERE product_id=$product_id";

  if ($conn->query($sql) === TRUE && $conn->query($sqlInventory) === TRUE) {

    //Get current Quantity
    $sqlcurrentqty = "SELECT * FROM inventory WHERE product_id=$product_id";
    $resultqty = $conn->query($sqlcurrentqty);
    $rowqty = $resultqty->fetch_assoc();

    $last=$rowqty['quantity'];

    if($AlertQuantity>=$last){
      // Return a success message
    header('HTTP/1.1 201 Created');
    echo "New Sale product Added Please Fullfil quantity, Remain: $last";
    }else{
      // Return a success message
    header('HTTP/1.1 201 Created');
    echo "New Sale product Added successfully.";
    }
    
  } else {
    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
//End of Products
}else if($sales_type=2){

// Insert the  Service
$sql = "INSERT INTO sales (product_id, sales_point_id, quantity, sales_price, total_amount, sales_type, paid_status,cust_name, phone)
VALUES ('$product_id', '$sales_point_id',1,'$service_amount', '$service_amount','$sales_type', '$paid_status','$customer','$phone')";

  if ($conn->query($sql) === TRUE) {
    // Return a success message
    header('HTTP/1.1 201 Created');
    echo "New Sale service Added successfully.";
  } else {
    // Return an error message if the insert failed
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}else if($sales_type=3){
  header('HTTP/1.1 201 Created');
  echo "Sale restaurant Added ...........";
}
}
