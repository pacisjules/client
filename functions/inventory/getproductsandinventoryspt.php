<?php
// Include the database connection file
require_once '../connection.php';

// Set master path
$masterHome = "/functions/inventory/getproductsandinventoryspt.php";
header('Content-Type: application/json');


$comID = $_GET['company'];
$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT INVE.id, INVE.quantity, INVE.alert_quantity, INVE.last_updated, PRO.status, PRO.sales_point_id, PRO.name, PRO.description, PRO.id AS product_id FROM inventory INVE INNER JOIN products PRO ON INVE.product_id = PRO.id WHERE PRO.company_ID = $comID AND PRO.sales_point_id = $spt GROUP BY PRO.id ORDER BY INVE.last_updated DESC;";


$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
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
        <td>'.$num.'. '.$row['name'].'</td>
        <td>'.$row['quantity'].'</td>
        <td>'.$row['alert_quantity'].'</td>
        <td>'.$sts.'</td>
        <td>'.$row['description'].'</td>
        <td>'.$row['last_updated'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditInventory(`'.$row['product_id'].'`, `'.$row['quantity'].'`, `'.$row['alert_quantity'].'`, `'.$row['name'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteInventory(`'.$row['product_id'].'`, `'.$row['name'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
