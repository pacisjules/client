<?php

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');
session_start();
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


        $shift_rec=0;

        if(empty($_SESSION['shift_record_id'])){
            $shift_rec=0;
        }else{
            $shift_rec=$_SESSION['shift_record_id'];
        }
    
        // Get the form data
        $product_ids = $_POST['product_id'];
        $sales_point_id = $_POST['sales_point_id'];
        $customer_id = $_POST['customer_id'];
        $cust_name = $_POST['cust_name'];
        $phone = $_POST['phone'];
        $quantities = $_POST['quantity'];
        $customer_prices = $_POST['price'];
        $sales_type = $_POST['sales_type'];
        $paid_status = $_POST['paid_status'];
        $service_amount = $_POST['service_amount'];
        $user_id = $_POST['user_id'];
        $usershift = $shift_rec;
        $currentDate = date("Y-m-d");


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $quantity = $quantities[$i];
                $custom_price = $customer_prices[$i];
               
                
                //$gresult [] = "ID: $product_id QTY: $quantity Type: $sales_type";


                if ($sales_type == 1) {
                    // Check if requested quantity is available
  
                    $total_amount = $quantity * $custom_price;
                    $sales_price = $custom_price;
      
               

                    // Perform calculations
                    

                    $gresult [] ="ID: $product_id SESSION: $Session_sale_ID USER: $user_id  SHIFT: $usershift SPT_ID: $sales_point_id CUSTOMER_ID:$customer_id CUSTOMER: $cust_name PHONE: $phone QTY: $quantity SP: $sales_price TM: $total_amount STP: $sales_type STATUS: $paid_status";
                    
                    //Get product expiration time


                    // Insert sales record
                    $sql = "INSERT INTO `sales`(`sess_id`, `user_id`,`customer_id`, `product_id`, `sales_point_id`, `cust_name`, `phone`, `quantity`, `sales_price`, `total_amount`,`sales_type`, `paid_status`,usershift_record)
                    VALUES ('$Session_sale_ID','$user_id','$customer_id','$product_id','$sales_point_id','$cust_name','$phone','$quantity','$sales_price','$total_amount','$sales_type','$paid_status','$usershift')";



                    if ($conn->query($sql)) {
                        $successCount++;

                        // Insert debt record if paid_status is "Not Paid"
                        if ($paid_status === 'Not Paid') {
                            
                            $sqldebt = "INSERT INTO debts (`sess_id`, `product_id`, `customer_id`,  `amount`, `due_date`, `sales_point_id`,  `descriptions`, `qty`, `status`) 
                            VALUES ('$Session_sale_ID','$product_id','$customer_id','$total_amount',' $currentDate','$sales_point_id','New Debit Added','$quantity',1)";

                            $conn->query($sqldebt);
                          
                        }

                        // Update inventory quantity
                    
                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add sales record for product with ID: $product_id.";
                    }
                } else {
                    $response[] = "Error: Invalid sales type for product with ID: $product_id.";
                }
            }

            if ($successCount === count($product_ids)) {
                $sqlsaveSession = "INSERT INTO sell_session (id, customer_id, spt_id, status)
                VALUES ('$Session_sale_ID', '$customer_id', '$sales_point_id', '$paid_status')";

                $conn->query($sqlsaveSession);
                
                // All sales records were inserted successfully
                $response[] = "All sales records added successfully.";
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
