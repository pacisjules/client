<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];
$name = $_GET['name'];


$spt = intval($spt); // Ensure it's an integer
$name = mysqli_real_escape_string($conn, $name); // Sanitize input

$sql = "SELECT 
        CUST.id , 
        CUST.asset_name,
        CUST.quantity, 
        CUST.register_at
        FROM asset CUST 
        WHERE CUST.spt = $spt 
        AND CUST.asset_name LIKE '%$name%'
        ORDER BY CUST.register_at DESC
";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num+=1;


    $value .= '

        <tr>
        <td>'.$num.'. '.$row['asset_name'].'</td>
        <td>'.$row['quantity'].'</td>
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
