<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.id ,
        CUST.category_id , 
        (SELECT categoryName FROM assetCategory WHERE category_id=CUST.category_id) as category,
        CUST.asset_name,
        CUST.quantity,
        CUST.status,
        CUST.register_at
        FROM asset CUST 
        WHERE CUST.spt = $spt 
        GROUP BY CUST.id
        ORDER BY CUST.register_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
     $color = "";
    $num += 1;

    if ($row['status'] === "Active") {
        $color = "green";
    } else if ($row['status'] === "Inactive") {
        $color = "gray";
    } else if ($row['status'] === "Under Maintenance") {
        $color = "orange";
    } else if ($row['status'] === "Disposed") {
        $color = "red";
    } else if ($row['status'] === "In Repair") {
        $color = "yellow";
    } else if ($row['status'] === "Lost or Stolen") {
        $color = "purple";
    } else if ($row['status'] === "Reserved") { // Fixed typo here
        $color = "blue";
    } else if ($row['status'] === "Damaged") {
        $color = "brown";
    }






    $value .= '

        <tr>
        <td>'.$num.'. '.$row['category'].'</td>
        <td>'.$row['asset_name'].'</td>
        <td>'.$row['quantity'].'</td>
        <td style="color:'.$color.'; font-weight:bold;">'.$row['status'].'</td>
        <td>'.$row['register_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditCustomer(`'.$row['id'].'`, `'.$row['asset_name'].'`, `'.$row['quantity'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteCustomer(`'.$row['id'].'`, `'.$row['asset_name'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
