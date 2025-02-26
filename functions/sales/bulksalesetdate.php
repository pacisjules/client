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
        $customer_paids = $_POST['paid'];
        $benefits = $_POST['benefit'];
        $sales_type = $_POST['sales_type'];
        $paid_status = $_POST['paid_status'];
        $service_amount = $_POST['service_amount'];
        $user_id = $_POST['user_id'];
        $usershift = $shift_rec;
        if (isset($_POST['payments'])) {
            $payments = $_POST['payments'];
        } else {
            $payments = []; // Handle the case where there are no payments
        }
        $currentDate = $_POST['created_time'];;


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $quantity = $quantities[$i];
                $custom_price = $customer_prices[$i];
                $custom_paid = $customer_paids[$i];
                $benefit = $benefits[$i];
                
                //$gresult [] = "ID: $product_id QTY: $quantity Type: $sales_type";



                // Get Product price and Current inventory quantity
                $sqlcurrent = "
                    SELECT
                        PD.id,
                        PD.price,
                        PD.benefit,
                        INVE.quantity,
                        INVE.alert_quantity
                    FROM
                        products PD
                    JOIN
                        inventory INVE ON PD.id = INVE.product_id
                    WHERE
                        PD.id = $product_id
                ";

                $result = $conn->query($sqlcurrent);
                $rowInfos = $result->fetch_assoc();

                $current_price = $rowInfos['price'];
                $current_inventory_quantity = $rowInfos['quantity'];
                $AlertQuantity = $rowInfos['alert_quantity'];
                $Benefits = $rowInfos['benefit'];

                if ($sales_type == 1) {
                    // Check if requested quantity is available
                    if ($quantity > $current_inventory_quantity) {
                        $response[] = "Impossible to add product with ID: $product_id. You are asking for a quantity greater than the available stock ($current_inventory_quantity).";
                        continue; // Skip to the next iteration
                    }
                    
                    if($custom_price==0){
                    $total_amount = $quantity * $current_price;
                    $sales_price = $current_price;
                    $total_benefit = $quantity * $Benefits;
                    $remain_quantity = $current_inventory_quantity - $quantity;    
                    }else{
                      $total_amount = $quantity * $custom_price;
                    $sales_price = $current_price;
                    $total_benefit = $quantity * $benefit;
                    $remain_quantity = $current_inventory_quantity - $quantity;  
                    }

                    // Perform calculations
                    

                    $gresult [] ="ID: $product_id SESSION: $Session_sale_ID USER: $user_id  SHIFT: $usershift SPT_ID: $sales_point_id CUSTOMER_ID:$customer_id CUSTOMER: $cust_name PHONE: $phone QTY: $quantity SP: $sales_price TM: $total_amount PAID: $custom_paid  STP: $sales_type STATUS: $paid_status TB:$total_benefit";
                    
                    //Get product expiration time
                    $sqlExpiry = "SELECT `expired_time`, `allow_exp` FROM `products` WHERE `id` = $product_id";
                    $result = $conn->query($sqlExpiry);
                    $rowInfos = $result->fetch_assoc();
                    $hours_of_expiry = $rowInfos['expired_time'];
                    $allow_exp = $rowInfos['allow_exp'];

               

                    // Insert sales record
                    $sql = "INSERT INTO `sales`(`sess_id`, `user_id`,`customer_id`, `product_id`, `sales_point_id`, `cust_name`, `phone`, `quantity`, `sales_price`, `total_amount`,`paid`,`total_benefit`, `sales_type`, `paid_status`,`usershift_record`,`created_time`)
                    VALUES ('$Session_sale_ID','$user_id','$customer_id','$product_id','$sales_point_id','$cust_name','$phone','$quantity','$sales_price','$total_amount','$custom_paid','$total_benefit','$sales_type','$paid_status','$usershift','$currentDate')";



                    if ($conn->query($sql)) {
                        $successCount++;

                        // Insert debt record if paid_status is "Not Paid"
                        if ($total_amount > $custom_paid ) {
                            
                            $sqldebt = "INSERT INTO debts (`sess_id`, `product_id`, `customer_id`,  `amount`, `amount_paid`, `due_date`, `sales_point_id`,  `descriptions`, `qty`, `status`) 
                            VALUES ('$Session_sale_ID','$product_id','$customer_id','$total_amount','$custom_paid',' $currentDate','$sales_point_id','New Debit Added','$quantity',1)";

                            $conn->query($sqldebt);
                          
                        }

                        // Update inventory quantity
                        $sqlInventory = "UPDATE inventory SET quantity = $remain_quantity WHERE product_id = $product_id";
                        $conn->query($sqlInventory);
                        

                        // Get current quantity
                        $sqlcurrentqty = "SELECT * FROM inventory WHERE product_id = $product_id";
                        $resultqty = $conn->query($sqlcurrentqty);
                        $rowqty = $resultqty->fetch_assoc();
                        $last = $rowqty['quantity'];

                        // Check alert quantity
                        if ($AlertQuantity >= $last) {
                            // Return a success message
                            $response[] = "New Sale product Added. Please fulfill the quantity. Remaining quantity: $last";
                        } else {
                            // Return a success message
                            $response[] = "New Sale product Added successfully.";
                        }
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

               // Check if the payments array has elements before proceeding
               if (isset($payments) && is_array($payments) && count($payments) > 0) {
                    foreach ($payments as $payment) {
                        $method = $payment['method'];
                        $amount = $payment['amount'];

                        // Insert each payment
                        $sqlPayment = "INSERT INTO `payments`(`sessionId`, `PaymentMethod`, `Amount`, `Status`,`spt`,`PaymentDate`) 
                                    VALUES ('$Session_sale_ID', '$method', '$amount', 'Completed', '$sales_point_id', '$currentDate')";
                        $conn->query($sqlPayment);
                    }
                } 



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
