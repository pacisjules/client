<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "product/searchproductbyname.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point


$spt = $_GET['spt'];
$platename = $_GET['platename'];

// Retrieve data from the database
$sql = "SELECT 
        RE.id,
        RE.carName,
        RE.platename,
        RE.carType,
        RE.servicesNeeded,
        RE.status,
        CU.names,
        CU.phone,
        RE.created_at
    FROM
        serviceRequest RE
    JOIN customer CU ON CU.customer_id = RE.customer_id
    WHERE
        RE.status = 1
        AND RE.spt = $spt 
        AND platename LIKE '%$platename%'";

$result = $conn->query($sql);

if (!$result) {
    // Handle the error, you might want to log it or provide a meaningful response
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to execute the query.']);
    exit;
}

$value = "";
$num = 0;

while ($row = $result->fetch_assoc()) {
    $num += 1;
    $value .= '
        <p style="margin-bottom: 0px; cursor:pointer;" class="hover-effect" onclick="getRequestSelected(`' . $row['id'] . '`,`' . $row['carName'] . '`,`' . $row['platename'] . '`,`' . $row['names'] . '`,`' . $row['phone'] . '`,`' . $row['carType'] . '`,`' . $row['servicesNeeded'] . '`,`' . $row['status'] . '`)">   ' . $num . '.  ' . $row['carName'] . ' -- ' . $row['platename'] . '</p>
    ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>
