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

$response = array(); // Initialize the response array
$gresult=array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data
    $jsonData = json_decode(file_get_contents('php://input'), true);
    
        // Get the form data
        $product_ids = $_POST['product_id'];
        $sales_point_id = $_POST['sales_point_id'];
        $customer_id = $_POST['customer_id'];
        $quantities = $_POST['quantity'];
        $amount_dues = $_POST['amount_due'];
        $sales_type = $_POST['sales_type'];
        $user_id = $_POST['user_id'];
        $currentDate = date("Y-m-d");
        $due_date =$_POST['due_date'];


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $quantity = $quantities[$i];
                $amount_due = $amount_dues[$i];
                
                $totot = $amount_due * $quantity;
                //$gresult [] = "ID: $product_id QTY: $quantity Type: $sales_type";


                if ($sales_type == 1) {
                    

                    $gresult [] ="ID: $product_id SESS_ID:$Session_sale_ID USER: $user_id  SPT_ID: $sales_point_id CUSTOMER_ID:$customer_id  QTY: $quantity AD: $totot   STP: $sales_type ";
                    
                    
                    // Insert sales record
                    $sql = "INSERT INTO debts (`sess_id`, `product_id`, `customer_id`,  `amount`, `amount_paid`,`due_date`, `sales_point_id`,  `descriptions`, `qty`, `status`) 
                            VALUES ('$Session_sale_ID','$product_id','$customer_id','$totot',0,' $due_date','$sales_point_id','New Debit Added','$quantity',1)";



                    if ($conn->query($sql)) {
                        $successCount++;

                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add debts record for product with ID: $product_id.";
                    }
                } else {
                    $response[] = "Error: Invalid sales type for product with ID: $product_id.";
                }
            }

            if ($successCount === count($product_ids)) {
                
                // All sales records were inserted successfully
                $response[] = "All debts records added successfully.";
            } else {
                $conn->rollback(); // Rollback the transaction if not all records were inserted successfully
            }
        } else {
            // Return an error message if the product is not found
            $response[] = "Product with ID: $product_id not found.";
        }
    
}

echo json_encode($Session_sale_ID);
?>
