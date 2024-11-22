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
    SL.id,
    PD.name AS Product_Name,
    SP.manager_name,
    SP.phone_number,
    SP.location,
    PD.benefit,
    SL.product_id,
    SL.quantity,
    SL.received_qty,
    SL.created_at,
    SL.request_by_name,
    SL.request_status,
    SL.created_at
FROM
    requestransfer SL
JOIN products PD ON
    SL.product_id = PD.id
JOIN salespoint SP ON
    SL.sales_point_id = SP.sales_point_id
WHERE
    SL.created_at LIKE '$date %' AND SP.company_ID =$comID  AND SL.sales_point_id = $spt
GROUP BY
    SL.id
ORDER BY
    SL.created_at
DESC ";


$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num += 1;

    $created_time = new DateTime($row['created_at']);
    $sell_time=$created_time->format('Y-m-d H:i:s');


    $sts="";
    $endis="";
    $icon="";
    $msg="";

    if($row['request_status']==1){
        $sts="PENDING";
        $endis="btn btn-warning";
        $icon="fa fa-check-square text-white";
        $msg="PENDING";
    }else if($row['request_status']==2){
        $sts="APPROVED";
        $endis="btn btn-success";
        $icon="bi bi-x-circle";
        $msg="APPROVED";
    }else{
        $sts="REJECTED";
        $endis="btn btn-danger";
        $icon="bi bi-x-circle";
        $msg="REJECTED";
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


//echo $relativeTime; // Output: "1 hour ago" or "2 hours 30 minutes ago"



    $value .= '

        <tr>

        <td style="font-size: 14px;">'.$num.'. '.$row['Product_Name'].'</td>
        <td style="font-size: 14px;">'.$row['quantity'].'</td>
        <td style="font-size: 14px;">'.$row['received_qty'].'</td>
        <td style="font-size: 14px;">'.$row['request_by_name'].'</td>
        <td style="font-size: 14px;"><button  class="'. $endis.'" type="button" style="font-size:12px;"><i class="'. $icon.'"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">'.$msg.'</span></button></td>
        <td style="font-size: 14px;">'.$sell_time.'</td>
    
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