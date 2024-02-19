<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/inventory/getproductsandinventory.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_inventory?company=" . $comID) {

        // Retrieve all users from the database
        $sql = "SELECT
        INVE.id,
        PRO.name,
        PRO.description,
        INVE.quantity,
        INVE.alert_quantity,
        inve.last_updated,
        PRO.status,
        PRO.sales_point_id
    FROM
        inventory INVE,
        products PRO
    WHERE
        INVE.product_id = PRO.id
        AND PRO.company_ID=$comID";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->id  = $row['id'];
                $com->name = $row['name'];
                $com->Current_quantity  = $row['quantity'];
                $com->alert_quantity = $row['alert_quantity'];
                $com->last_updated = $row['last_updated'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];
                $com->description = $row['description'];
                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No Inventory List found.";
        }
    }

}
