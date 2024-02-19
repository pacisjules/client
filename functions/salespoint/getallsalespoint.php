<?php
// Include the database connection file
require_once '../connection.php';


// Retrieve all users from the database
$sql = "SELECT * FROM salespoint";
$value = "";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {


    $getcompanyNamesql = "select * from companies";
    $res = mysqli_query($conn, $getcompanyNamesql);
    $resrow = mysqli_fetch_assoc($res);

    $value .= '
        <tr>
            <td>'. $row['manager_name'].'</td>
            <td>'. $resrow['name'].'</td>
            <td>' . $row['location']. '</td>
            <td>' . $row['phone_number']. '</td>
            <td>' . $row['email']. '</td>
            <td>' . $row['created_at']. '</td>
            <td><button class="btn btn-success" type="button" style="margin-right: 11px;" data-bs-target="#Editco-modal" data-bs-toggle="modal" onclick="setSptUpdate(`'. $row['sales_point_id'].'`,`'. $row['manager_name'].'`,`'. $row['location'].'`,`'. $row['phone_number'].'`,`'. $row['company_ID'].'`,`'. $row['email'].'`)"><i class="fas fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="setSptDelete(`'. $row['sales_point_id'].'`)"><i class="fa fa-trash" style="color: rgb(255,255,255);"></i></button></td>
        </tr>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
