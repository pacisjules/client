<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/restaurent/getall_orders_itemsbyOrderID.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];
    $spt = $_GET['spt'];
    $order_id = $_GET['order_id'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_menu?company=" . $comID . "&spt=" . $spt . "&order_id=" . $order_id) {

        // Retrieve all users from the database
        $sql = "
        SELECT
        OD.Orderid,
        ODT.OrderItemID,
        OD.place_name AS Place_name,
        ODT.Quantity,
        ODT.menuItem,
        (select Name from menu_items WHERE ItemID=ODT.menuItem) AS Menu_Item,
        (select Price from menu_items WHERE ItemID=ODT.menuItem) AS Menu_Price,
        (select Quantity from order_items where OrderItemID=ODT.OrderItemID) AS Item_Quantity,
        
        CASE
               WHEN OD.status = 0 THEN '(0) Command Cancelled'
               WHEN OD.status = 1 THEN '(1) Command Requested'
               WHEN OD.status = 2 THEN '(2) Command Ready for Delivery'
               WHEN OD.status = 3 THEN '(3) Command Done!'
               ELSE 'No Result'
           END AS Command_Process,
           OD.created_date AS Ordered_Time,
           OD.company_ID,
           OD.sales_point_id,
           ODT.status
    FROM
        orders OD,
        order_items ODT
    WHERE
    OD.Orderid=ODT.OrderID
    AND OD.Orderid='$order_id' AND OD.company_ID='$comID' AND OD.sales_point_id='$spt'
        ";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->OrderID  = $row['Orderid'];
                $com->Name  = $row['Menu_Item'];
                $com->Quantity  = $row['Item_Quantity'];
                $com->Price  = $row['Menu_Price'];
                $com->Total  = $row['Menu_Price'] * $row['Item_Quantity'];
                $com->Command_status = $row['Command_Process'];
                $com->Ordered_time = $row['Ordered_Time'];
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
