<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
$date = $_GET['date'];
$comID = $_GET['company'];
$spt = $_GET['spt'];





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
    SL.created_time LIKE '$date %' AND SP.company_ID =$comID  AND SL.sales_point_id = $spt
GROUP BY
    SL.sales_id
ORDER BY
    SL.created_time
DESC
LIMIT 5 ";


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


    $timestamp = $sell_time;
$currentTimestamp = time(); // Get the current timestamp

// Convert the given timestamp and the current timestamp to UNIX timestamps
$timestampUnix = strtotime($timestamp);
$currentTimestampUnix = strtotime('now');

// Calculate the difference in seconds
$diffSeconds = $currentTimestampUnix - $timestampUnix;

// Convert seconds to hours and minutes
$hours = floor($diffSeconds / 3600);
$minutes = floor(($diffSeconds % 3600) / 60);

// Build the relative time string
if ($hours > 0) {
    $relativeTime = $hours . ' hour';
    if ($hours > 1) {
        $relativeTime .= 's';
    }
    if ($minutes > 0) {
        $relativeTime .= ' ' . $minutes . ' min';
        if ($minutes > 1) {
            $relativeTime .= 's';
        }
    }
    $relativeTime .= ' ago';
} elseif ($minutes > 0) {
    $relativeTime = $minutes . ' min';
    if ($minutes > 1) {
        $relativeTime .= 's';
    }
    $relativeTime .= ' ago';
} else {
    $relativeTime = 'Just now';
}



$tprice = $row['total_amount'];
$qty = $row['quantity'];
$pic = $tprice/$qty;

//echo $relativeTime; // Output: "1 hour ago" or "2 hours 30 minutes ago"



    $value .= '

        <tr>

        <td style="font-size: 14px;">'.$num.'. '.$row['Product_Name'].'</td>
        <td style="font-size: 14px;">'.number_format($pic).'</td>
        <td style="font-size: 14px;">'.$row['quantity'].'</td>
        <td style="font-size: 14px;">'.number_format($row['total_amount']).'</td>
        <td style="font-size: 14px;">'.number_format($row['total_benefit']).'</td>
        <td style="font-size: 14px;"><button  class="'. $endis.'" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="'. $icon.'"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">'.$msg.'</span></button></td>
        <td style="font-size: 14px;">'.$relativeTime.'</td>
    
        </tr>

        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>