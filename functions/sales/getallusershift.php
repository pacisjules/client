<?php
// Include the database connection file
require_once '../connection.php';

// Set master path
header('Content-Type: application/json');

$spt = $_GET['spt'];

// Retrieve all users from the database
$sql = "SELECT * FROM close_checkout CC, users US, shift_records SR WHERE CC.spt=$spt AND CC.user_id=US.id AND CC.shiftrecord_id=SR.record_id
       ORDER BY CC.check_id DESC
       LIMIT 10";

$value = "";
$result = mysqli_query($conn, $sql);
$num = 0;

// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {
    $sts = "";
    $color = "";

    if ($row['shift_status'] == 1) {
        $sts = "Active";
        $color = "green";
    } else {
        $sts = "Closed";
        $color = "red";
    }

    // Adjust start and end times by adding two hours
    $start = new DateTime($row['start']);
    $end = new DateTime($row['end']);
    $start->modify('+2 hours');
    $end->modify('+2 hours');

    $num += 1;

    $value .= '
        <tr>
            <td style="font-size: 12px;">' . $num . '. ' . $row['username'] . '</td>
            <td style="font-size: 12px;">FRW ' . number_format($row['amount']) . '</td>
            <td style="font-size: 12px;">FRW ' . number_format($row['cashinhand']) . '</td>
            <td style="font-size: 12px;">FRW ' . number_format($row['mobilemoney']) . '</td>
            <td style="font-size: 12px;">FRW ' . number_format($row['bank']) . '</td>
            <td style="font-size: 12px;">' . $start->format('Y-m-d H:i:s') . '</td>
            <td style="font-size: 12px;">' . $end->format('Y-m-d H:i:s') . '</td>
            <td style="font-size: 14px; color: ' . $color . '; font-weight: bold;">' . $sts . '</td>
            <td style="font-size: 12px;">
            <div style="display:flex; justify-content:space-between;">
            <a class="nav-link active" href="shiftdetails?from=' . $row['start'] . '&to='.$row['end'].'">  <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">DETAILS</button></a>
            <button style="background-color: green; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;" type="button" data-bs-target="#shiftmodal" data-bs-toggle="modal" onclick="SelectExpand(`'.$row['shiftrecord_id'].'`,`'.$row['username'].'`)">EXPAND SHIFT</button>
           </div>
            </td>
        </tr>';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;