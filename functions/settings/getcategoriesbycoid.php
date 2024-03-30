<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_id = $_GET['coid'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
cat_id,	
category_name,	
company_id,	
status,	
created_at FROM `users_category` WHERE company_id=$company_id ORDER BY created_at DESC";

$value = '';
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['cat_id'];
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
        <td>'.$num.'. '.$row['category_name'].'</td>
        <td><button class='.$endis.' type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditCustomer(`'.$row['cat_id'].'`, `'.$row['category_name'].'`)"><i class="'.$icon.'" style="color: rgb(255,255,255);"></i> '.$sts.'</button></td>
        <td>'.$row['created_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_category" data-bs-toggle="modal" onclick="SelectEditCategory(`'.$row['cat_id'].'`, `'.$row['category_name'].'`, `'.$row['status'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#categorydelete-modal" data-bs-toggle="modal" onclick="SelectdeleteCategory(`'.$row['cat_id'].'`, `'.$row['category_name'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
