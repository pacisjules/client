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
        $standardname = $_POST['standardname'];
        $ExpectededQty = $_POST['expectedQty'];
        $company_id = $_POST['company_id'];
        $quantities = $_POST['quantity'];
        $units = $_POST['unit'];
        $user_id = $_POST['user_id'];
        $currentDate = date("Y-m-d");
        


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
                    
                    

                    $gresult [] ="ID: $row_id SESSION: $Session_sale_ID USER: $user_id COMPANY_ID: $company_id  QTY: $quantity UNIT: $unit";
                    
                    
                    // Insert sales record
                    $sql = "INSERT INTO `standardrowmaterial`( `standard_code`, `raw_material_id`, `unit_id`, `quantity`, `company_id`, `user_id`)
                    VALUES ('$Session_sale_ID','$row_id','$unit','$quantity','$company_id','$user_id')";



                    if ($conn->query($sql)) {
                        $successCount++;

                    } else {
                        // Return an error message if the insert failed
                        $response[] = "Error: Failed to add production record for row material with ID: $row_id.";
                    }
               
            }
            
            if ($successCount === count($rowIds)) {
                $sqlsaveSession = "INSERT INTO `product_standard`(`standard_code`, `product_name`, `quantity`,`company_id`, `user_id`) 
                VALUES ('$Session_sale_ID', '$standardname','$ExpectededQty', '$company_id','$user_id')";

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
