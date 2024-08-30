<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "product/searchproductbyname.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point


$comID = $_GET['company'];
$spt = $_GET['spt'];
$name = $_GET['name'];



// Retrieve all users from the database
$sql = "SELECT  PD.id, PD.name, PD.price, PD.benefit, PD.status, PD.description,PD.created_at ,IFNULL(INV.quantity, 0) AS invquantity
        FROM products PD
        LEFT JOIN inventory INV ON PD.id = INV.product_id
        WHERE PD.company_ID = $comID
        AND PD.sales_point_id = $spt AND PD.name LIKE '%$name%'";

$value = "";
$result = mysqli_query($conn, $sql);
$num = 0;


$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $current_quantity="";

    $sqlInventory = "SELECT quantity FROM inventory WHERE product_id=$myid";
    $resultInv = mysqli_query($conn, $sqlInventory);
    $rowInv = $resultInv->fetch_assoc();

    if(empty( $rowInv['quantity'])){
        $current_quantity =0;
    }else
    {
        $current_quantity = $rowInv['quantity']; 
    }

    

    $num+=1;
    $value .= '
            <p style="margin-bottom: 10px; cursor:pointer; font-weight: bold; font-size: 14px; text-transform: uppercase;" class="hover-effect" onclick="getSelected(`' . $row['id'] . '`,`' . $row['name'] . '`,`' . $row['price'] . '`,`' . $row['benefit'] . '`,`' . $current_quantity . '`)">   ' . $num . '.  ' . $row['name'] . '</p>
            ';
    $name="";
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
