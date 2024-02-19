<?php
// Include the database connection file
require_once '../connection.php';

require_once '../path.php';

//Set master path
$masterHome = $globalVariable."product/getproductsbysalespt.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];
    $spt = $_GET['spt'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_products?company=" . $comID . "&spt=" . $spt) {

        // Retrieve all users from the database
        $sql = "SELECT * FROM products WHERE company_ID=$comID AND sales_point_id=$spt ORDER BY created_at DESC";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {
                $myid=$row['id'];
                $sqlgetinventory = "SELECT * FROM inventory WHERE product_id=$myid";
                $resultINVE = $conn->query($sqlgetinventory);

                $rowInfos = $resultINVE->fetch_assoc();
                $current_quantity = $rowInfos['quantity'];
                $alert_quantity = $rowInfos['alert_quantity'];
                
                $cqty=0;
                $cal=0;
                
                if($current_quantity==""){
                    $cqty=0;
                }else{
                    $cqty=$current_quantity;
                }
                
                if($alert_quantity==""){
                    $cal=0;
                }else{
                    $cal=$alert_quantity;
                }

                $com = new stdClass();

                $com->product_id  = $row['id'];
                $com->name = $row['name'];
                $com->price = $row['price'];
                $com->benefit  = $row['benefit'];
                $com->company_ID = $row['company_ID'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];
                $com->current_quantity = $cqty;
                $com->alert_quantity = $cal;
                $com->description = $row['description'];
                $com->barcode = $row['barcode'];
                
                $salesTime = new DateTime($row['created_at']);
                $salesTime->modify('+2 hours');
                $com->created_at = $salesTime->format('Y-m-d H:i:s');;
                
                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No products List found.";
        }
    }
}
