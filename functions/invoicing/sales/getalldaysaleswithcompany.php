<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/sales/getalldaysaleswithcompany.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    //Get all sales by date
    $date = $_GET['date'];
    $comID = $_GET['company'];

    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_sales_days?date=" . $date . "&company=" . $comID) {

    

    $sql = "
    SELECT
    SL.sales_id,
    (select name from products where id=SL.product_id) AS Product_Name,
    SP.manager_name,SP.phone_number,SP.location,PD.benefit,
    SL.quantity,SL.quantity,SL.sales_price,SL.total_amount,SL.total_benefit,SL.paid_status, SL.created_time
FROM
    sales SL,
    products PD,
    salespoint SP
WHERE 
SL.product_id=PD.id AND SL.sales_point_id=SP.sales_point_id AND SL.created_time LIKE '$date %' AND SP.company_ID=$comID
    ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            $numid=1;
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();
                $com->id  = $numid++;
                $com->manager_name  = $row['manager_name'];
                $com->price = $row['sales_price'];
                $com->phone_number = $row['phone_number'];
                $com->name = $row['Product_Name'];

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
