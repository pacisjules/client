<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/restaurent/getall_orders_bycompany.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_menu?company=" . $comID) {

        // Retrieve all users from the database
        $sql = "
        SELECT
	OD.Orderid,
    OD.place_name,
    (select count(*) from orders where Orderid=OD.Orderid) AS Items_count,
    OD.status,
    OD.created_date,
    OD.company_ID,
    OD.sales_point_id
FROM
order_items OI,
orders OD
WHERE OI.OrderID=OD.Orderid
AND  OI.company_ID='$comID'
        ";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->Orderid  = $row['Orderid'];
                $com->place_name = $row['place_name'];
                $com->Items_count  = $row['Items_count'];
                $com->status  = $row['status'];
                $com->created_time  = $row['created_date'];
                $com->company_ID = $row['company_ID'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No Service List found.";
        }
    }
}
