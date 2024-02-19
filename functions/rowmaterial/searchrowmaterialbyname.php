<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "product/searchproductbyname.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point


$spt = $_GET['spt'];
$name = $_GET['name'];



// Retrieve all users from the database
$sql = "SELECT  PD.raw_material_id , PD.raw_material_name, PD.unit_of_measure,PD.purchase_date ,IFNULL(INV.quantity_in_stock, 0) AS invquantity
        FROM rawmaterials PD
        LEFT JOIN rawstock INV ON PD.raw_material_id = INV.raw_material_id
        WHERE  PD.sales_point_id = $spt AND raw_material_name LIKE '%$name%'";

$value = "";
$result = mysqli_query($conn, $sql);
$num = 0;


$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $myid = $row['raw_material_id'];
    $current_quantity="";

    $sqlInventory = "SELECT quantity_in_stock FROM rawstock WHERE raw_material_id=$myid";
    $resultInv = mysqli_query($conn, $sqlInventory);
    $rowInv = $resultInv->fetch_assoc();

    if(empty( $rowInv['quantity_in_stock'])){
        $current_quantity =0;
    }else
    {
        $current_quantity = $rowInv['quantity_in_stock']; 
    }

    $num+=1;
    $value .= '
            <p style="margin-bottom: 0px; cursor:pointer;" class="hover-effect" onclick="getSelecteRow(`' . $row['raw_material_id'] . '`,`' . $row['raw_material_name'] . '`,`' . $row['unit_of_measure'] . '`,`' . $current_quantity . '`)">   ' . $num . '.  ' . $row['raw_material_name'] . '</p>
            ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
