<?php
// Include the database connection file
require_once '../connection.php';


// Retrieve all users from the database
$sql = "SELECT * FROM employee";
$value = "";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    $spt=$row['sales_point_id'];

    $getcompanyNamesql = "select location as spt_location from salespoint where sales_point_id=$spt";
    $res = mysqli_query($conn, $getcompanyNamesql);
    $resrow = mysqli_fetch_assoc($res);


    $value .= '
        <tr>
        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
        <td>'.$row['email'].'</td> 
        <td>'.$row['phone'].'</td>
        <td>'.$resrow['spt_location'].'</td>
        <td>'.$row['hire_date'].'</td>
        <td><button class="btn btn-success" type="button" style="margin-right: 11px;" data-bs-target="#Editco-modal" data-bs-toggle="modal"><i class="fas fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="RemoveUserInfo(`'. $row['user_id'].'`)"><i class="fa fa-trash" style="color: rgb(255,255,255); "></i></button></td>
        </tr>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
