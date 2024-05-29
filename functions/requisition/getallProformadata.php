<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

// Get the session ID from the query parameters
$spt = $_GET['spt'];

// Check if the session ID is set
if (!isset($spt)) {
    http_response_code(400); // Bad request
    echo json_encode(array("error" => "Spt is missing"));
    exit();
}

// SQL query to fetch sales records
$sql = "
SELECT DISTINCT
PR.id,
PR.sess_id,
PR.dedicated_to,
PR.product_name,
CONCAT(EP.first_name,' ',EP.last_name) AS full_name,
EP.phone,
SP.location,
PR.quantity,
PR.price,
(SELECT SUM(total) AS numm FROM requisition WHERE sess_id = PR.sess_id) AS total,
PR.created_at,
(SELECT COUNT(id) AS num FROM requisition WHERE sess_id = PR.sess_id) AS tottal_item


FROM
requisition PR

JOIN salespoint SP ON
PR.spt_id = SP.sales_point_id

JOIN employee EP ON
PR.user_id = EP.user_id

WHERE
PR.spt_id = $spt
GROUP BY
PR.sess_id
ORDER BY
PR.created_at DESC";

$result = $conn->query($sql);

$value = "";
$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $session_id = $row['sess_id'];
    $num+=1;

   
    $value .= '

        <tr>
        <td>'.$num.'. '.$row['dedicated_to'].'</td>
        <td>'.$row['tottal_item'].'</td>
        <td>'.number_format($row['total']).' FRW</td>
        <td>'.$row['full_name'].'</td>
        <td>'.$row['phone'].'</td>
        <td>'.$row['created_at'].'</td>
        <td class="d-flex flex-row justify-content-start align-items-center">
        <button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectSessionToPrint(`'.$session_id.'`)"><i class="fa fa-print" style="color: rgb(255,255,255);"></i>&nbsp;PRINT</button>&nbsp;
        <button class="btn btn-danger" type="button" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectSessionToPrint(`'.$session_id.'`)"><i class="fa fa-trash" style="color: rgb(255,255,255);"></i>&nbsp;DELETE</button>
       
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