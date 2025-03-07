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
        $company_ID = $_POST['company'];
        $supplier_id = $_POST['supplier_id'];
        $quantities = $_POST['quantity'];
        $customer_prices = $_POST['price'];
        $sales_type = $_POST['sales_type'];
        $paid_status = $_POST['paid_status'];
        $user_id = $_POST['user_id'];
        $currentDate = $_POST['purchase_date'];


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $quantity = $quantities[$i];
                $custom_price = $customer_prices[$i];
              
                //$gresult [] = "ID: $product_id QTY: $quantity Type: $sales_type";



                // Get Product price and Current inventory quantity
                $sqlcurrent = "
                SELECT
                COUNT(*) as number, 
                 
                  quantity,
                  alert_quantity
              FROM
                 
                  inventory 
              WHERE
                  product_id = $product_id
                ";

                $result = $conn->query($sqlcurrent);
                $rowInfos = $result->fetch_assoc();

               
                $current_inventory_quantity = $rowInfos['quantity'];
                $AlertQuantity = $rowInfos['alert_quantity'];
                $number = $rowInfos['number'];
                

                if ($number<1) { 
                    


                    if ($sales_type == 1) {
                    
                    
                    
                        $total_amount = $quantity * $custom_price;
                        $purchase_price = $custom_price;
                        $remain_quantity = $current_inventory_quantity + $quantity;  
                     
                        // Perform calculations
                        $gresult [] ="ID: $product_id SESSION: $Session_sale_ID USER: $user_id SPT_ID: $sales_point_id COMPANY_ID: $company_ID  SUPPLIER_ID:$supplier_id  QTY: $quantity SP: $purchase_price TM: $total_amount STP: $sales_type STATUS: $paid_status ";
                        
                        //Get product expiration time
                        $sqlExpiry = "SELECT `expired_time`, `allow_exp` FROM `products` WHERE `id` = $product_id";
                        $result = $conn->query($sqlExpiry);
                        $rowInfos = $result->fetch_assoc();
                        $hours_of_expiry = $rowInfos['expired_time'];
                        $allow_exp = $rowInfos['allow_exp'];

                        if ($allow_exp == 1) {
                            //Add this now time to expiry time
                            $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $hours_of_expiry . ' hours', strtotime(date('Y-m-d H:i:s'))));
                            
                            // Insert expiration table record
                            $sql_insert_expiry = "INSERT INTO `expiration_table`(`product_id`, `quantity`, `user_id`, `status`, `due_date`) VALUES ('$product_id','$quantity','$user_id','1','$expiry_date')";
                            $conn->query($sql_insert_expiry);
                        }
                    
                        // Insert sales record
                        $sql = "INSERT INTO `purchase`(`sess_id`, `user_id`,`supplier_id`, `product_id`, `spt_id`,`company_ID`, `quantity`, `price_per_unity`, `total_price`, `paid_status`,`purchase_date`)
                        VALUES ('$Session_sale_ID','$user_id','$supplier_id','$product_id','$sales_point_id','$company_ID','$quantity','$purchase_price','$total_amount','$paid_status','$currentDate')";
    
    
    
                        if ($conn->query($sql)) {
                            $successCount++;
    
                            // Insert debt record if paid_status is "Not Paid"
                            if ($paid_status === 'Not Paid') {
                                

                                $sqldebt = "INSERT INTO credits (`sess_id`, `product_id`, `supplier_id`,  `amount`, `due_date`, `sales_point_id`,`qty`, `status`) 
                                VALUES ('$Session_sale_ID','$product_id','$supplier_id','$total_amount',' $currentDate','$sales_point_id','$quantity',1)";
    
                                $conn->query($sqldebt);
                              
                            }
    
                            // Update inventory quantity
                            $sqlInventory = "INSERT INTO `inventory`(`product_id`, `quantity`, `alert_quantity`, `company_ID`, `spt_id`) 
                            VALUES ('$product_id','$quantity',5,'$company_ID','$sales_point_id')";
                            $conn->query($sqlInventory);

                            $sqlproducts = "UPDATE products SET price = $purchase_price WHERE id = $product_id";
                            $conn->query($sqlproducts);
                            
    
                            // Get current quantity
                            $sqlcurrentqty = "SELECT * FROM inventory WHERE product_id = $product_id";
                            $resultqty = $conn->query($sqlcurrentqty);
                            $rowqty = $resultqty->fetch_assoc();
                            $last = $rowqty['quantity'];
    
                            // Check alert quantity
                            if ($AlertQuantity >= $last) {
                                // Return a success message
                                $response[] = "New PURCHASE product Added. Please fulfill the quantity. Remaining quantity: $last";
                            } else {
                                // Return a success message
                                $response[] = "New PURCHASE product Added successfully.";
                            }
                        } else {
                            // Return an error message if the insert failed
                            $response[] = "Error: Failed to add PURCHASE record for product with ID: $product_id.";
                        }
                    } else {
                        $response[] = "Error: Invalid PURCHASE type for product with ID: $product_id.";
                    }



                }else{
                 if ($sales_type == 1) {
                    
                    
                    
                    $total_amount = $quantity * $custom_price;
                    $purchase_price = $custom_price;
                    $remain_quantity = $current_inventory_quantity + $quantity;  

                    // Perform calculations
                    

                    $gresult [] ="ID: $product_id SESSION: $Session_sale_ID USER: $user_id SPT_ID: $sales_point_id COMPANY_ID: $company_ID  SUPPLIER_ID:$supplier_id  QTY: $quantity SP: $purchase_price  TM: $total_amount STP: $sales_type STATUS: $paid_status ";
                    
                    //Get product expiration time
                    $sqlExpiry = "SELECT `expired_time`, `allow_exp` FROM `products` WHERE `id` = $product_id";
                    $result = $conn->query($sqlExpiry);
                    $rowInfos = $result->fetch_assoc();
                    $hours_of_expiry = $rowInfos['expired_time'];
                    $allow_exp = $rowInfos['allow_exp'];

                    if ($allow_exp == 1) {
                        //Add this now time to expiry time
                        $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $hours_of_expiry . ' hours', strtotime(date('Y-m-d H:i:s'))));
                        
                        // Insert expiration table record
                        $sql_insert_expiry = "INSERT INTO `expiration_table`(`product_id`, `quantity`, `user_id`, `status`, `due_date`) VALUES ('$product_id','$quantity','$user_id','1','$expiry_date')";
                        $conn->query($sql_insert_expiry);
                    }
                    
                    // Insert sales record
                    $sql = "INSERT INTO `purchase`(`sess_id`, `user_id`,`supplier_id`, `product_id`, `spt_id`,`company_ID`, `quantity`, `price_per_unity`, `total_price`, `paid_status`)
                    VALUES ('$Session_sale_ID','$user_id','$supplier_id','$product_id','$sales_point_id','$company_ID','$quantity','$purchase_price','$total_amount','$paid_status')";



                    if ($conn->query($sql)) {
                        $successCount++;

                        // Insert debt record if paid_status is "Not Paid"
                        if ($paid_status === 'Not Paid') {
                            
                            $sqldebt = "INSERT INTO credits (`sess_id`, `product_id`, `supplier_id`,  `amount`, `due_date`, `sales_point_id`,`qty`, `status`) 
                            VALUES ('$Session_sale_ID','$product_id','$supplier_id','$total_amount',' $currentDate','$sales_point_id','$quantity',1)";

                            $conn->query($sqldebt);
                          
                        }

                        // Update inventory quantity
                        $sqlInventory = "UPDATE inventory SET quantity = $remain_quantity WHERE product_id = $product_id";
                        $conn->query($sqlInventory);

                        $sqlproducts = "UPDATE products SET price = $purchase_price WHERE id = $product_id";
                        $conn->query($sqlproducts);
                        

                        // Get current quantity
                        $sqlcurrentqty = "SELECT * FROM inventory WHERE product_id = $product_id";
                        $resultqty = $conn->query($sqlcurrentqty);
                        $rowqty = $resultqty->fetch_assoc();
                        $last = $rowqty['quantity'];

                        // Check alert quantity
                        if ($AlertQuantity >= $last) {
                            // Return a success message
                            $response[] = "New PURCHASE product Added. Please fulfill the quantity. Remaining quantity: $last";
                        } else {
                            // Return a success message
                            $response[] = "New PURCHASE product Added successfully.";
                        }
                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add PURCHASE record for product with ID: $product_id.";
                    }
                } else {
                    $response[] = "Error: Invalid PURCHASE type for product with ID: $product_id.";
                }   
                }
                

                
            }

            if ($successCount === count($product_ids)) {
                // $sqlsaveSession = "INSERT INTO sell_session (id, customer_id, spt_id, status)
                // VALUES ('$Session_sale_ID', '$customer_id', '$sales_point_id', '$paid_status')";

                // $conn->query($sqlsaveSession);
                
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
