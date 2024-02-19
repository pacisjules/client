<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/expiredproducts/getproductsexpired.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $spt = $_GET['spt'];
    $today = $_GET['today'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/expired.php?spt=" . $spt . "&today=" . $today) {

        // Retrieve all users from the database
        $sql = "
        SELECT
    expired_id,
    product_id,
    (select name from products where id=product_id) AS Product_name,
    expiry_date,
    warning_hours,
    disposal_method,
    sales_point_id,
    expired_quantity,
    (select location from salespoint where sales_point_id=EP.sales_point_id) AS Sales_point_location,
    created_at
FROM
    expiredproducts EP
    
    WHERE
    EP.sales_point_id=$spt AND EP.expiry_date < '$today%'";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->expired_id  = $row['expired_id'];
                $com->product_id = $row['product_id'];
                $com->Product_name  = $row['Product_name'];
                $com->expiry_date = $row['expiry_date'];
                $com->expired_quantity = $row['expired_quantity'];
                $com->warning_hours = $row['warning_hours'];
                $com->disposal_method = $row['disposal_method'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->Sales_point_location = $row['Sales_point_location'];
                $com->created_at = $row['created_at'];
                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No expired products List found.";
        }
    }
}
