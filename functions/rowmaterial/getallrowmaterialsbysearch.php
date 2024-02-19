<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$spt = $_GET['spt'];
$name=$_GET['name'];

// Retrieve all users from the database
$sql = "SELECT  PD.raw_material_id, PD.raw_material_name, PD.unit_of_measure, PD.purchase_date,IFNULL(INV.quantity_in_stock, 0) AS stock
        FROM rawmaterials PD
        LEFT JOIN rawstock INV ON PD.raw_material_id = INV.raw_material_id
        WHERE PD.sales_point_id = $spt
        AND raw_material_name LIKE '%$name%'";


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
                                            <td>'.$num.'. ' . $row['raw_material_name'] . '</td>
                                            <td>' . $row['stock'] . '</td>
                                            <td>' . $row['unit_of_measure'] . '</td>
                                            <td><button class="'.$endis.'" type="button" style="margin-left: 20px;" data-bs-target="#disable-product" data-bs-toggle="modal" onclick="DisableProductID(`'.$row['raw_material_id'].'`, `'.$row['status'].'`)"><i class="'.$icon.'"></i></button></td>
                                            <td>' . $row['purchase_date'] . '</td>
                                           <td class="d-flex flex-row justify-content-start align-items-center">
                                            <button class="btn btn-success" type="button" data-bs-target="#edit_rowmaterial_modal" data-bs-toggle="modal" onclick="setUpdates(`'.$row['raw_material_name'].'`,`'.$row['unit_of_measure'].'`, `'.$row['raw_material_id'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                                            <button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="RemoveProductID(`'.$row['raw_material_id'].'`)"><i class="fa fa-trash"></i></button>
                                            
                                                    
                                                    <button class="btn btn-primary" type="button" style="margin-left: 18px;background: rgb(223,139,78);font-weight: bold;border-color: rgb(255,255,255);width: 151.6875px;" data-bs-target="#purchasemodal" data-bs-toggle="modal" 
                                                    onclick="setRowmaterialId(`'.$row['raw_material_id'].'`)"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cart-fill">
                                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                                    </svg>&nbsp; Purchase</button>
                                            
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
