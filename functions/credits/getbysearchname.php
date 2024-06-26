<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

$spt = $_GET['spt'];
$names = $_GET['names'];

// Validate and sanitize user input
$spt = intval($spt); // Ensure it's an integer
$names = mysqli_real_escape_string($conn, $names); // Sanitize input

$sql = "SELECT DISTINCT
            CU.names,
            CU.phone,
            CU.address,
            DE.due_date,
            DE.status,
            DE.customer_id,
            (SELECT SUM(amount - amount_paid) FROM debts WHERE customer_id = DE.customer_id AND sales_point_id = $spt) AS Amount
        FROM
            debts DE
        JOIN
            customer CU ON DE.customer_id = CU.customer_id 
        WHERE 
            DE.sales_point_id = $spt AND CU.names LIKE '%$names%'
            GROUP BY CU.customer_id
            ";

$value = "";
$result = mysqli_query($conn, $sql);

$num = 0;

// Convert the results to an array of objects
$comp = array();
while ($row = $result->fetch_assoc()) {
    $myid = $row['customer_id'];
    $num += 1;

    $sts = "";
    $endis = "";
    $icon = "";

    if ($row['status'] == 1) {
        $sts = "Loan";
        $endis = "red";
        $icon = "bi bi-x-circle";
    } else {
        $sts = "Full Paid";
        $endis = "green";
        $icon = "fa fa-check-square text-white";
    }
    
      $color="green";
    $is_paid="Paid";

    if($row['Amount']>0){
      $new = $row['Amount'];
      $tot += $new;
      $color="red";
      $is_paid="";
    }
    
     $formattedTotalAmount = number_format($row['Amount']); 

    $value .= '
        <tr>
        <td>' . $num . '. ' . $row['names'] . '</td>
        <td>' . $row['phone'] . '</td>
        <td>' . $row['address'] . '</td>
        <td style="color:'.$color.'; font-weight:bold;"> FRW ' . $formattedTotalAmount . ' '.$is_paid.'</td>
        
        <td>' . $row['due_date'] . '</td>
        <td class="d-flex flex-row justify-content-start align-items-center">
            <a class="nav-link active" href="debtdetails.php?customer_id=' . $myid . '">
                <button class="btn btn-success"  rounded-circle" style="background-color:#040536; border-radius:15px;" type="button">
                    <i class="fas fa-eye" style="font-size:20px; color: white; margin-top:3px;"></i>
                </button>
            </a>
        </td>
        </tr>
    ';
}

$response = array(
    'debts' => $value
);

// Convert data to JSON
$jsonData = json_encode($response);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>