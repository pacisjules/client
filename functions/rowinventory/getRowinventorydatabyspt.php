<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT
        INVE.quantity_in_stock ,  
        INVE.raw_material_id, 
        PRO.raw_material_name, 
        PRO.unit_of_measure, 
        PRO.status,
        INVE.date_added 
       FROM rawstock INVE 
       INNER JOIN rawmaterials PRO ON INVE.raw_material_id  = PRO.raw_material_id 
       WHERE   PRO.sales_point_id = $spt 
       GROUP BY PRO.raw_material_id ORDER BY INVE.date_added DESC";


$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['raw_material_id'];
    $num+=1;

    $sts="";
    $endis="";
    $icon="";

    if($row['status']==1){
        $sts="Active";
        $endis="btn btn-danger";
        $icon="bi bi-x-circle";
    }else{
        $sts="Not Active";
        $endis="btn btn-success";
        $icon="fa fa-check-square text-white";
    }

    $value .= '

        <tr>
        <td>'.$num.'. '.$row['raw_material_name'].'</td>
        <td>'.$row['quantity_in_stock'].'</td>
        <td>'.$row['unit_of_measure'].'</td>
        <td>'.$sts.'</td>
        <td>'.$row['date_added'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center">
            <a class="nav-link active" href="stockdetails.php?raw_material_id=' . $myid . '">
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
