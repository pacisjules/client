<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT 
        id,
        names,
        shiftstart,
        shiftend
        
        FROM shift
        WHERE  spt = $spt 
        ORDER BY created_at DESC";

$value = "";
$result = mysqli_query($conn, $sql);


$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $num+=1;
    $date = new DateTime($row['shiftstart']);
    $period = $date->format('A');

    $dateend = new DateTime($row['shiftend']);
    $periodend = $dateend->format('A');


    $value .= '

        <tr>
        <td style="font-size:14px;">'.$num.'. '.$row['names'].'</td>
        <td style="font-size:14px;"><span class="badge bg-primary">'.$row['shiftstart'].' '.$period.'</span></td>
        <td style="font-size:14px;"><span class="badge bg-success">'.$row['shiftend'].' '.$periodend.'</span></td>
         <td  class="d-flex flex-row justify-content-start align-items-center">
         <button class="btn btn-success" type="button" style="font-size:12px;" data-bs-target="#edit_shift_modal" data-bs-toggle="modal" onclick="SelectEditCustomer(`'.$row['id'].'`, `'.$row['names'].'`, `'.$row['shiftstart'].'`, `'.$row['shiftend'].'`)"><i class="fa fa-edit" style="color: white;"></i>&nbsp; <span style="color: white;">EDIT</span></button>&nbsp; &nbsp;
         <button class="btn btn-danger" type="button" style="font-size:12px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteCustomer(`'.$row['id'].'`, `'.$row['names'].'`)"><i class="fa fa-trash"></i>&nbsp; DELETE</button>&nbsp; &nbsp;
         <a class="nav-link active" href="userbyshift?shift_id=' . $myid . '">  <button class="btn btn-primary" type="button"  style="font-size:12px;"><i class="fas fa-users" style="color: rgb(255,255,255);"></i>&nbsp; SHIFT USERS</button></a>&nbsp;&nbsp;
         <a class="nav-link active" href="salesbyshift?shift_id=' . $myid . '"> <button class="btn btn-success" type="button" style="font-size:12px;"><i class="fas fa-chart-line" style="color: rgb(255,255,255);"></i>&nbsp; SALES REPORT</button></a>
         </td>  
        </tr>

        ';
 
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
