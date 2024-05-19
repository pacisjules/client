<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
// $date = $_GET['date'];     FI.created_at LIKE '$date %' AND 
$company_ID = $_GET['company_ID'];





$sql = "
SELECT DISTINCT
FP.id,
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
FP.company_id=$company_ID AND FP.standard_code = PS.standard_code  COLLATE utf8mb4_unicode_ci ORDER BY FP.created_at DESC LIMIT 30;
";



$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $prod_session = $row['session_id'];
    //$prod_id = $row['product_id'];
    //$category =  $row['category_id'];
    $num += 1;

    $sts="";
    $style="";
    

    if($row['status']==1){
        $sts="Pending";
        $style="orange";
        
    }else if($row['status']==2){
        $sts="Approved";
        $style="green";
       
    }else if($row['status']==3){
        $sts="Rejected";
        $style="red";
       
    }else{
        $sts="Transferred";
        $style="blue"; 
    }



    $value .= '

        <tr>

        <td style="font-size: 12px;">'.$num.'. '.$row['product_name'].'</td>
        <td style="font-size: 12px;">'.$row['Excepted_qty'].'</td>
        <td style="font-size: 12px;">'.$row['produced_by'].'</td>
        <td style="font-size: 12px;">'.$row['real_produced_qty'].'</td>
        <td style="font-size: 12px;">'.$row['approved_by'].'</td>
         
        
        <td style="font-size: 12px;font-weight:bold; color:'.$style.';">'.$sts.'</td>
        <td style="font-size: 12px;">'.$row['created_at'].'</td>
         
        <td class="d-flex flex-row justify-content-start align-items-center" style="font-size: 12px; padding:10px;">
         
            <button class="btn btn-success" style="font-size: 5px;"   type="button" data-bs-target="#approvemodal" data-bs-toggle="modal" onclick="ApproveorRejectProduction(`'.$myid.'`,`'.$row['status'].'`)">
            <i class="fa fa-check-circle" style="color: white; font-weight:bold;font-size:10px;"></i>&nbsp; <span style="color: white; font-weight:bold;font-size:10px;">APPROVE</span> 
            </button>&nbsp;
            <button class="btn btn-primary" style="font-size: 5px; "   type="button" data-bs-target="#TransferAll" data-bs-toggle="modal" onclick="settransferProduct( `'.$row['real_produced_qty'].'`,`'.$myid.'`,`'.$row['status'].'`)">
            <i class="fa fa-random" style="color: white; font-weight:bold;font-size:10px;"></i>&nbsp; <span style="color: white; font-weight:bold;font-size:10px;">TRANSFER ALL</span> 
            </button>&nbsp;
            <button class="btn btn-dark" style="font-size: 5px; "   type="button" data-bs-target="#PackingAndTransfer" data-bs-toggle="modal" onclick="setPacktransferProduct( `'.$row['real_produced_qty'].'`,`'.$myid.'`,`'.$row['status'].'`)">
            <i class="fa fa-box" style="color: white; font-weight:bold;font-size:10px;"></i>&nbsp; <span style="color: white; font-weight:bold;font-size:10px;">PACKING</span> 
            </button>&nbsp;
        
            <a class="nav-link active" href="productiondetails?session_id=' . $prod_session . '">
                <button class="btn btn-light"  rounded-circle" style="background-color:#a9e7e8; border-radius:5px;font-size: 5px;" type="button">
                    <i class="fas fa-eye" style="font-size:10px; color: black; margin-top:3px;"></i>&nbsp;<span style="font-size:10px; color: black;">DETAILS</span>
                </button>
            </a>
        </td>
    
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