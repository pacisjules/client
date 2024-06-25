<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_id = $_GET['coid'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT US.id,US.status,US.shift_id,EP.first_name,EP.last_name, US.username, US.email, EP.phone, US.user_category, (select category_name from users_category WHERE cat_id=US.user_category) as category_name FROM users US, employee EP WHERE US.id=EP.user_id AND US.company_ID=$company_id ORDER BY EP.hire_date DESC";

$value = '';
$result = mysqli_query($conn, $sql);


$num=0;
$status_name='';
$status_color='';

// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num+=1;

    if($row['status']==1){
        $status_name = 'Active';
        $status_color='green';
    }else{
        $status_name = 'Inactive';
        $status_color='red';
    }


    $value .= '

        <tr>
        <td style="color:'.$status_color.'; font-weight: bold">'.$num.'. '.$status_name.'</td>
        <td> '.$row['first_name'].' '.$row['last_name'].'</td>
        <td> '.$row['username'].'</td>
        <td> '.$row['email'].'</td>
        <td> '.$row['phone'].'</td>
        <td> '.$row['category_name'].'</td>

        <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#modal_user" data-bs-toggle="modal" onclick="SelectEditUsers(`'.$row['id'].'`, `'.$row['first_name'].'`, `'.$row['last_name'].'`, `'.$row['username'].'`, `'.$row['email'].'`, `'.$row['phone'].'`, `'.$row['user_category'].'`, `'.$row['shift_id'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px; display: none;" data-bs-target="#user-delete-modal" data-bs-toggle="modal" onclick="SelectDeleteUser(`'.$row['id'].'`, `'.$row['first_name'].' '.$row['last_name'].'`)"><i class="fa fa-trash"></i></button></td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
