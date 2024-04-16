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
        $cust_name = $_POST['cust_name'];
        $phone = $_POST['phone'];
        $quantities = $_POST['quantity'];
        $customer_prices = $_POST['price'];
        $benefits = $_POST['benefit'];
        $sales_type = $_POST['sales_type'];
        $user_id = $_POST['user_id'];
        $currentDate = date("Y-m-d");


        if (is_array($product_ids)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $quantity = $quantities[$i];
                $custom_price = $customer_prices[$i];
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
                    

                    $gresult [] ="ID: $product_id SESSION: $Session_sale_ID USER: $user_id SPT_ID: $sales_point_id  CUSTOMER: $cust_name PHONE: $phone QTY: $quantity SP: $sales_price TM: $total_amount STP: $sales_type  TB:$total_benefit";
                    
                    
                    // Insert sales record
                    $sql = "INSERT INTO `proforma`( `session_id`, `user_id`, `customer_name`, `phone`, `product_id`, `spt_id`, `quantity`, `price`, `total_amount`, `total_benefit`) 
                    VALUES ('$Session_sale_ID','$user_id','$cust_name','$phone','$product_id','$sales_point_id','$quantity','$sales_price','$total_amount','$total_benefit')";



                    if ($conn->query($sql)) {
                        $successCount++;
                       
                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add sales record for product with ID: $product_id.";
                    }
                } else {
                    $response[] = "Error: Invalid sales type for product with ID: $product_id.";
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
            $response[] = "Product with ID: $product_id not found.";
        }
    
}

echo json_encode($Session_sale_ID);
?>
