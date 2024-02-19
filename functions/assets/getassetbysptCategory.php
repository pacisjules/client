<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        CUST.category_id  , 
        CUST.categoryName,
        CUST.managedBy, 
        (SELECT CONCAT(first_name,' ',last_name) AS manager_name FROM employee WHERE employee_id = CUST.managedBy) as Category_manager,
        CUST.created_at
        FROM assetCategory CUST 
        WHERE CUST.spt = $spt 
        GROUP BY CUST.category_id
        ORDER BY CUST.created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['category_id'];
    $num+=1;


    $value .= '

        <tr>
        <td>'.$num.'. '.$row['categoryName'].'</td>
        <td>'.$row['Category_manager'].'</td>
        <td>'.$row['created_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditCategory(`'.$row['category_id'].'`, `'.$row['categoryName'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteCategory(`'.$row['category_id'].'`, `'.$row['categoryName'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
