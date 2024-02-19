<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/restaurent/getall_orders_itemsbycompanyspt.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];
    $spt = $_GET['spt'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_menu?company=" . $comID . "&spt=" . $spt) {

        // Retrieve all users from the database
        $sql = "
        SELECT
    OD.place_name,OD.status,
    OI.ItemName,OI.Quantity,OI.company_ID,OI.sales_point_id,OI.created_time,
    (select Name from menu_items where ItemID=OI.menuItem) AS Menu_Item,
    (select Price from menu_items where ItemID=OI.menuItem) AS Menu_Price
FROM
order_items OI,
orders OD
WHERE OI.OrderID=OD.Orderid
AND  OI.company_ID='$comID' AND OI.sales_point_id='$spt'
        ";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->Name  = $row['Menu_Item'];
                $com->Description = $row['ItemName'];
                $com->Quantity  = $row['Quantity'];
                $com->Price  = $row['Menu_Price'];
                $com->Total  = $row['Menu_Price'] * $row['Quantity'];
                $com->created_time = $row['created_time'];
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
