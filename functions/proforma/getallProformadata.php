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
PR.session_id,
PR.customer_name,
PR.phone,
PR.product_name,
SP.manager_name,
SP.phone_number,
SP.location,
PR.quantity,
PR.price,
PR.total_amount,
PR.created_at,
(SELECT COUNT(id) AS num FROM proforma WHERE session_id = PR.session_id) AS tottal_item


FROM
proforma PR

JOIN salespoint SP ON
PR.spt_id = SP.sales_point_id

WHERE
PR.spt_id = $spt
GROUP BY
PR.session_id
ORDER BY
PR.created_at DESC";

$result = $conn->query($sql);

$value = "";
$num=0;


// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $session_id = $row['session_id'];
    $num+=1;

   
    $value .= '

        <tr>
        <td>'.$num.'. '.$row['customer_name'].'</td>
        <td>'.$row['phone'].'</td>
        <td>'.$row['tottal_item'].'</td>
        <td>'.number_format($row['total_amount']).' FRW</td>
        <td>'.$row['manager_name'].'</td>
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