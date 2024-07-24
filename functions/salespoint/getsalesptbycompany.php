<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

$company_ID = $_GET['company'];

// Retrieve all products and inventory for the given company and sales point
$sql = "SELECT * FROM salespoint SA, companies CO WHERE SA.company_ID=CO.id AND SA.company_ID=$company_ID";
$result = mysqli_query($conn, $sql);

$rows = array(); // Initialize an empty array to store the data




while ($row = $result->fetch_assoc()) {
    $rows[] = array(
        'location' => $row['location'],
        'manager_name' => $row['manager_name'],
        'phone_number' => $row['phone_number'],
        'name' => $row['name'],
        'sales_point_id' => $row['sales_point_id']
    );
}

// Now, let's construct the HTML markup
$html = ''; // Start the table

foreach ($rows as $index => $row) {
    $html .= '
        <tr>
            <td>' . ($index + 1) . '. ' . $row['location'] . '</td>
            <td>' . $row['manager_name'] . '</td>
            <td>' . $row['phone_number'] . '</td>
            <td>' . $row['name'] . '</td>
            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#visitsalespoint_modal" data-bs-toggle="modal" onclick="SelectEdisalespoint(' . $row['sales_point_id'] . ')"><i class="fa fa-map-marker" style="color: rgb(255,255,255);margin-right:5px;"></i>Visit</button></td>  
        </tr>';
}

; // Close the table

// Encode the HTML into JSON
$jsonData = json_encode($html);

// Send the JSON response
echo $jsonData;
?>
