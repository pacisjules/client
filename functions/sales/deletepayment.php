<?php
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $pay_id = $_POST['pay_id'];

 
  // Insert the products
  $sql = "DELETE FROM payments WHERE PaymentID=$pay_id";
  
  if (!$conn->query($sql)) {
            $error = true;
    }

}
?>
