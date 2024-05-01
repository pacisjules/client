<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT 
products.name,
packages.packgenumber,
packages.pack_id,
packages.created_at
       
FROM packages 
JOIN products on packages.product_id = products.id 
WHERE packages.company_id = $comID
ORDER BY packages.created_at DESC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
//     $myid = $row['pack_id '];
    $date = new DateTime($row['created_at']);
    $formattedDate = $date->format('l, F j, Y');
   
    $num+=1;

     $value .= '<tr>

        <td>'.$num.'. '.$row['name'].'</td>
        <td>'.$row['packgenumber'].'</td>
        <td>'.$formattedDate.'</td>
        <td><button class="btn btn-success" type="button" data-bs-target="#edit_category_modal" data-bs-toggle="modal" onclick="setUpdateCategory(`'.$row['packgenumber'].'`, `'.$row['pack_id'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal-category" data-bs-toggle="modal" onclick="RemoveCategoryID(`'.$row['pack_id'].'`)"><i class="fa fa-trash"></i></button></td>
 
        </tr>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
