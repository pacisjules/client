<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_ID = $_GET['company'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.supplier_id , 
        CUST.names,
        CUST.phone, 
        CUST.address,
        CUST.created_at
        FROM supplier CUST 
        WHERE CUST.company_ID = $company_ID 
        GROUP BY CUST.supplier_id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['supplier_id'];
    $num+=1;

    $phone = empty($row['phone']) ? '<span style="color: red; font-weight: bold;">N/A</span>' : '<span style="color: green; font-weight: bold;">'.$row['phone'].'</span>';
    $address= empty($row['address']) ? '<span style="color: red; font-weight: bold;">N/A</span>' : '<span style="text-transform:uppercase;font-weight: bold;">'.$row['address'].'</span>';
   

    $value .= '

        <tr>
        <td>'.$num.'. '.$row['names'].'</td>
        <td>'.$phone.'</td>
        <td>'.$address.'</td>
        <td>'.$row['created_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditsupplier(`'.$row['supplier_id'].'`, `'.$row['names'].'`, `'.$row['phone'].'`, `'.$row['address'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeletesupplier(`'.$row['supplier_id'].'`, `'.$row['names'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
