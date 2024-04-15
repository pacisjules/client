<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
// $date = $_GET['date'];      FI.created_at LIKE '$date %' AND
$company_ID = $_GET['company_ID'];

//echo $company_ID;



$sql = "
SELECT DISTINCT
FP.session_id,
FP.standard_code,
PS.product_name,
FP.quantity AS Excepted_qty,
FP.real_produced_qty,
(select concat(employee.first_name,' ',employee.last_name) as nms from employee where user_id=FP.user_id) as produced_by,
(select concat(employee.first_name,' ',employee.last_name)  as nms from employee where user_id=FP.approved_by) as approved_by,
FP.created_at,
FP.status
FROM
finishedproduct FP,
product_standard PS
WHERE
FP.company_id=$company_ID AND FP.standard_code = PS.standard_code  COLLATE utf8mb4_unicode_ci ORDER BY FP.status ASC LIMIT 5;
";



$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    
    $num += 1;
    
    $msg="";
    $color="";

    if($row['status']==1){
        $msg="Pending";
        $color="orange";
    }else if($row['status']==2){
        $msg="Approved";
        $color="green";
    }else if($row['status']==3){
        $msg="Rejected";
        $color="red";
    }else{
        $msg="Transferred";
        $color="blue";  
    }




    $value .= '

        <tr>
        <td style="font-size: 12px;">'.$num.'. '.$row['product_name'].'</td>
        <td style="font-size: 12px;">'.$row['Excepted_qty'].'</td>
        <td style="font-size: 12px;">'.$row['produced_by'].'</td>
        <td style="font-size: 12px;">'.$row['real_produced_qty'].'</td>
        <td style="font-size: 12px;">'.$row['approved_by'].'</td>
        <td style="font-size: 12px; font-weight:bold; color:'.$color.'">'.$msg.'</td>
        <td style="font-size: 12px;">'.$row['created_at'].'</td>
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