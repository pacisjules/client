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
        $company = $_POST['company'];
        $spt_id = $_POST['spt_id'];
        $quantities = $_POST['quantity'];
        $customer_prices = $_POST['price'];
        $user_id = $_POST['user_id'];
        $currentDate = date("Y-m-d");
        


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_name = $product_ids[$i];
                $quantity = $quantities[$i];
                $custom_price = $customer_prices[$i];
                
                
                  
                $total_amount =  $quantity * $custom_price;
                    // Perform calculations
                    

                    $gresult [] ="PRODUCT: $product_name SESSION: $Session_sale_ID USER: $user_id COMPANY: $company  SPT: $spt_id  QTY: $quantity SP: $custom_price TM: $total_amount   ";
                    
                    
                    // Insert sales record
                    $sql = "INSERT INTO `requisition`( `sess_id`, `user_id`, `spt_id`, `product_name`, `company_id`, `quantity`, `price`, `total`,status) 
                    VALUES ('$Session_sale_ID','$user_id','$spt_id','$product_name','$company','$quantity','$custom_price','$total_amount',1)";



                    if ($conn->query($sql)) {
                        $successCount++;
                       
                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add proforma record for product with NAME: $product_name.";
                    }
                
            }

            if ($successCount === count($product_ids)) {  
                // All sales records were inserted successfully
                $response[] = "All data of proforma records added successfully.";
            } else {
                $conn->rollback(); // Rollback the transaction if not all records were inserted successfully
            }
        } else {
            // Return an error message if the product is not found
            $response[] = "Product with NAME: $product_name not found.";
        }
    
}

echo json_encode($Session_sale_ID);
?>
