<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date

$comID = $_GET['company'];
$week = $_GET['week'];
$spt = $_GET['spt'];

// Get the start and end dates of the week
$year = date('Y');
$start_date = date('Y-m-d', strtotime($year . 'W' . $week));
$end_date = date('Y-m-d', strtotime($year . 'W' . $week . '7'));// Get the current date

$sql = "
SELECT DISTINCT
    SL.sales_id,
    PD.name AS Product_Name,
    SP.manager_name,
    SP.phone_number,
    SP.location,
    PD.benefit,
    SL.product_id,
    SL.quantity,
    SL.sales_price,
    SL.total_amount,
    SL.total_benefit,
    SL.paid_status,
    SL.created_time,
    SL.sales_type,
    INV.alert_quantity,
    INV.quantity AS remain_stock
FROM
    sales SL
JOIN products PD ON
    SL.product_id = PD.id
JOIN salespoint SP ON
    SL.sales_point_id = SP.sales_point_id
JOIN inventory INV ON
    SL.product_id = INV.product_id
WHERE
    SL.created_time >= '$start_date 00:00:00' 
    AND SL.created_time <= '$end_date 23:59:59' 
    AND SP.company_ID = $comID 
    AND SL.sales_point_id = $spt
GROUP BY
    SL.sales_id
ORDER BY
    SL.created_time DESC";


   


$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    $myid = $row['sales_id'];
    $num += 1;

    $created_time = new DateTime($row['created_time']);
    $sell_time=$created_time->format('Y-m-d H:i:s');


    $sts="";
    $endis="";
    $icon="";
    $msg="";

    if($row['paid_status']=="Paid"){
        $sts="Active";
        $endis="btn btn-success";
        $icon="fa fa-check-square text-white";
        $msg="Paid";
    }else{
        $sts="Not Active";
        $endis="btn btn-danger";
        $icon="bi bi-x-circle";
        $msg="Debt";
    }

//echo $relativeTime; // Output: "1 hour ago" or "2 hours 30 minutes ago"



    $value .= '

        <tr>

        <td style="font-size: 14px;">'.$num.'. '.$row['Product_Name'].'</td>
        <td style="font-size: 14px;">'.number_format($row['sales_price']).'</td>
        <td style="font-size: 14px;">'.$row['quantity'].'</td>
        <td style="font-size: 14px;">'.number_format($row['total_amount']).'</td>
        <td style="font-size: 14px;">'.number_format($row['total_benefit']).'</td>
        <td style="font-size: 14px;"><button  class="'. $endis.'" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="'. $icon.'"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">'.$msg.'</span></button></td>
        <td style="font-size: 14px;">'.$row['created_time'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" data-sale-id="'.$myid.'"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" data-sale-id="'.$myid.'"><i class="fa fa-trash"></i></button></td>
    
        </tr>

        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
