<?php
// Include the database connection file
require_once '../connection.php';



require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "company/getallcompanies.php";
header('Content-Type: application/json');

//$currentPath = $_SERVER['PHP_SELF'];
//echo json_encode("Path: ".$currentPath);

//Get employees by company_ID and sales Point




// Retrieve all users from the database
$sql = "select * from companies";

$value = "";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    $value .= '

                <tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row['city'] . ', ' . $row['country'] . ' ' . $row['address'] . '</td>
                <td>' . $row['phone'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['created_at'] . '</td>
                <td><button class="btn btn-success" type="button" style="margin-right: 10px;" data-bs-target="#Editco-modal" data-bs-toggle="modal" onclick="setUpdates(`'. $row['name'] .'`,`'. $row['address'] .'`,`'. $row['city'] .'`,`'. $row['state'] .'`,`'. $row['zip_code'] .'`,`'. $row['country'] .'`,`'. $row['phone'] .'`,`'. $row['email'] .'`,`'. $row['website'] .'`,`'. $row['id'] .'`)"><i class="fas fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="deletecompany(`'. $row['id'] .'`, `'. $row['name'] .'`)"><i class="fa fa-trash" style="color: rgb(255,255,255);"></i></button></td>
                </tr>
                
                ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
