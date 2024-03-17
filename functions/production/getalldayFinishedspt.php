<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
// $date = $_GET['date'];     FI.created_at LIKE '$date %' AND 
$company_ID = $_GET['company_ID'];





$sql = "
SELECT DISTINCT
    FI.id,
    PD.name AS Product_Name,
    FI.quantity,
    FI.created_at,
    FI.user_id,
    FI.session_id,
    FI.product_id,
    FI.status,
    (SELECT CONCAT(first_name, ' ', last_name) AS names FROM employee WHERE user_id = FI.user_id) AS usernames
FROM
    FinishedProduct FI
JOIN products PD ON
    FI.product_id = PD.id
WHERE
    FI.company_id = $company_ID
ORDER BY
    FI.created_at DESC
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
    $prod_id = $row['product_id'];
    $num += 1;

    $sts="";
    $style="";
    

    if($row['status']==1){
        $sts="Pending";
        $style="orange";
        
    }else{
        $sts="Stocked";
        $style="green";
       
    }



    $value .= '

        <tr>

        <td style="font-size: 14px;">'.$num.'. '.$row['Product_Name'].'</td>
        <td style="font-size: 14px;">'.$row['quantity'].'</td>
        <td style="font-size: 14px;">'.$row['usernames'].'</td>
        <td style="font-size: 14px;">'.$row['created_at'].'</td>
         <td style="font-size: 16px;font-weight:bold; color:'.$style.';">'.$sts.'</td>
         <td >
         <a class="nav-link active" href="packingproducts.php?session_id=' . $prod_session . '&product_id='.$prod_id.'">
            <button class="btn btn-success"    type="button" data-bs-target="#edit_product_modal" data-bs-toggle="modal" onclick="setFinishedProduct(`'.$prod_id.'`,`'.$prod_session.'`, `'.$row['quantity'].'`,`'.$row['Product_Name'].'`)">
            <i class="fa fa-exclamation-circle" style="color: white;"></i> Packing
            </button>
         </a>
         </td>
         <td class="d-flex flex-row justify-content-start align-items-center">
            <a class="nav-link active" href="productiondetails.php?session_id=' . $prod_session . '&product_id='.$prod_id.'">
                <button class="btn btn-success"  rounded-circle" style="background-color:#040536; border-radius:15px;" type="button">
                    <i class="fas fa-eye" style="font-size:20px; color: white; margin-top:3px;"></i><span style="font-size:15px; color: white; margin-left:13px;">View More</span>
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