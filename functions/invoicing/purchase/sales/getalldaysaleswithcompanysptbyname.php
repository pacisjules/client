<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/sales/getalldaysaleswithcompanysptbyname.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    //Get all sales by date
    $date = $_GET['date'];
    $comID = $_GET['company'];
    $spt=$_GET['spt'];
    $name=$_GET['name'];

    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_sales_days?date=" . $date . "&company=" . $comID . "&spt=". $spt . "&name=". $name) {

    

    $sql = "
SELECT
    SL.sales_id,
    (select name from products where id=SL.product_id) AS Product_Name,
    SP.manager_name,SP.phone_number,SP.location,PD.benefit,SL.product_id,
    SL.quantity,SL.quantity,SL.sales_price,SL.total_amount,SL.total_benefit,SL.paid_status, SL.created_time, SL.paid_status, SL.sales_type,INV.alert_quantity, INV.quantity AS remain_stock
FROM
    sales SL,
    products PD,
    salespoint SP,
    inventory INV
WHERE 
SL.product_id=PD.id AND SL.product_id=INV.product_id AND SL.sales_point_id=SP.sales_point_id AND SL.created_time LIKE '$date %' AND SP.company_ID=$comID AND SL.sales_point_id=$spt AND PD.name LIKE '%$name%'

    ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            $numid=1;
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();
                $com->id  = $numid++;
                $com->sales_id = $row['sales_id'];
                $com->product_id = $row['product_id'];
                $com->manager_name  = $row['manager_name'];
                $com->price = $row['sales_price'];
                $com->phone_number = $row['phone_number'];
                $com->name = $row['Product_Name'];
                $com->Total = $row['total_amount'];
                $com->paid_status = $row['paid_status'];
                $com->remain_stock = $row['remain_stock'];
                $com->alert_quantity = $row['alert_quantity'];
                $com->sales_type = $row['sales_type'];

                $com->quantity = $row['quantity'];
                $com->Total = $row['total_amount'];

                $com->benefit = $row['benefit'];
                $com->Totalbenefit = $row['total_benefit'];

                $created_time = new DateTime($row['created_time']);
                $com->Sales_time = $created_time->format('Y-m-d H:i:s');

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No List found.";
        }
    }
}
