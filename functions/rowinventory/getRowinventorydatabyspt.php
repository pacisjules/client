<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$company_id = $_GET['company_id'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT
        INVE.box_container,
        INVE.qty_per_box,
        INVE.quantity_in_stock,
        INVE.raw_material_id, 
        PRO.raw_material_name, 
        PRO.unit_of_measure, 
        PRO.status,
        INVE.date_added 
       FROM rawstock INVE 
       INNER JOIN rawmaterials PRO ON INVE.raw_material_id  = PRO.raw_material_id 
       WHERE   INVE.company_id = $company_id
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
        <td>'.$row['box_container'].'</td>
        <td>'.$row['qty_per_box'].'</td>
        <td>'.$row['quantity_in_stock'].'</td>
        <td>'.$row['unit_of_measure'].'</td>
        <td>'.$sts.'</td>
        <td>'.$row['date_added'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditInventory(`'.$row['raw_material_id'].'`, `'.$row['box_container'].'`, `'.$row['qty_per_box'].'`, `'.$row['raw_material_name'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteInventory(`'.$row['raw_material_id'].'`, `'.$row['raw_material_name'].'`)"><i class="fa fa-trash"></i></button></td>   
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
