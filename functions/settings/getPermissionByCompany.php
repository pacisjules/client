<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_id = $_GET['coid'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT PA.perm_id,
PA.name, 
PA.cat_id,UC.category_name,
PA.page_id, PE.page_name AS pagename,
PA.company_id, 
PA.created_at 
FROM permissions PA,users_category UC, page_allowance PE
WHERE PA.company_id=$company_id AND PA.cat_id= UC.cat_id AND PA.page_id=PE.id ORDER BY PA.created_at DESC";

$value = '';
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['perm_id'];
    $num+=1;


  

    $value .= '

        <tr>
        <td>'.$num.'. '.$row['name'].'</td>
        <td> '.$row['category_name'].'</td>
        <td> '.$row['pagename'].'</td>
        <td>'.$row['created_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_permission" data-bs-toggle="modal" onclick="SelectEditCustomer(`'.$row['perm_id'].'`, `'.$row['name'].'`, `'.$row['cat_id'].'`, `'.$row['page_id'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#permissiondelete-modal" data-bs-toggle="modal" onclick="SelectDeleteCustomer(`'.$row['perm_id'].'`, `'.$row['name'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
