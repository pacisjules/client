<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable."product/getproductsbycompany.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_products?company=" . $comID) {

        // Retrieve all users from the database
        $sql = "SELECT * FROM products WHERE company_ID=$comID";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->product_id  = $row['id'];
                $com->name = $row['name'];
                $com->benefit  = $row['benefit'];
                $com->created_at = $row['created_at'];
                $com->company_ID = $row['company_ID'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];
                $com->description = $row['description'];
                $com->barcode = $row['barcode'];
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
