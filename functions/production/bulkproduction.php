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
        $rowIds = $_POST['row_id'];
        $standard_code = $_POST['standard_code'];
        $NeeddedQty = $_POST['needdedQty'];
        $company_id = $_POST['company_id'];
        $quantities = $_POST['quantity'];
        $units = $_POST['unit'];
        $user_id = $_POST['user_id'];
        $currentDate = date("Y-m-d");
        $status=1;


        if (is_array($rowIds)) {
            $successCount = 0;

           // $conn->begin_transaction();

            for ($i = 0; $i < count($rowIds); $i++) {
                $row_id = $rowIds[$i];
                $quantity = $quantities[$i];
                $unit = $units[$i];
                
                //$gresult [] = "ID: $product_id QTY: $quantity Type: $sales_type";



                // Get Product price and Current inventory quantity
                $sqlcurrent = "
                    SELECT
                        PD.raw_material_id ,
                        PD.raw_material_name,
                        PD.unit_of_measure,
                        INVE.quantity_in_stock,
                        INVE.box_container,
                        INVE.qty_per_box,
                        INVE.stock_id 
                    FROM
                        rawmaterials PD
                    JOIN
                        rawstock INVE ON PD.raw_material_id  = INVE.raw_material_id 
                    WHERE
                        PD.raw_material_id  = $row_id
                ";

                $result = $conn->query($sqlcurrent);
                $rowInfos = $result->fetch_assoc();

                $boxquantity = $rowInfos['box_container'];
                $quantity_perbox = $rowInfos['qty_per_box'];
                $current_inventory_quantity = $rowInfos['quantity_in_stock'];
                $raw_material_name = $rowInfos['raw_material_name'];
                $unit_of_measure = $rowInfos['unit_of_measure'];
                $stockiD = $rowInfos['stock_id'];

                    // Check if requested quantity is available
                    if ($quantity > $current_inventory_quantity) {
                        $response[] = "Impossible to add Row MATERIAL with ID: $row_id. You are asking for a quantity greater than the available stock ($current_inventory_quantity).";
                        continue; // Skip to the next iteration
                    }
                    
                    // Perform calculations
                    $ibivuyemwo = $quantity/$quantity_perbox;
                    $remainbox = $boxquantity - $ibivuyemwo;
                    $remain_quantity = $current_inventory_quantity - $quantity;

                    $gresult [] ="ID: $row_id SESSION: $Session_sale_ID USER: $user_id COMPANY_ID: $company_id  QTY: $quantity UNIT: $unit";
                    
                    
                    // Insert sales record
                    $sql = "INSERT INTO `production`( `session_id`, `raw_material_id`, `standard_code`, `unit`, `quantity`, `company_id`, `user_id`)
                    VALUES ('$Session_sale_ID','$row_id','$standard_code','$unit','$quantity','$company_id','$user_id')";



                    if ($conn->query($sql)) {
                        $successCount++;
                        

                        // Update inventory quantity
                        $sqlInventory = "UPDATE rawstock SET
                         box_container= $remainbox,
                         quantity_in_stock = $remain_quantity WHERE stock_id = $stockiD";
                        
                        
                        if($conn->query($sqlInventory)){
                           $response[] = "New  production Added successfully."; 
                        }
                        

                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add production record for row material with ID: $row_id.";
                    }
               
            }
            
            if ($successCount === count($rowIds)) {
                $sqlsaveSession = "INSERT INTO `finishedproduct`(`session_id`, `quantity`, `standard_code`, `company_id`, `user_id`, `status`) 
                VALUES ('$Session_sale_ID', '$NeeddedQty', '$standard_code', '$company_id','$user_id',1)";

                $conn->query($sqlsaveSession);
                
                // All sales records were inserted successfully
                $response[] = "All Production records added successfully.";
            } else {
                $conn->rollback(); // Rollback the transaction if not all records were inserted successfully
            }
            
            
            
        } else {
            // Return an error message if the product is not found
            $response[] = "Row Material with ID: $row_id not found.";
        }
    
}

echo json_encode($Session_sale_ID);
?>
