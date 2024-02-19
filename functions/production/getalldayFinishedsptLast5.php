<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
// $date = $_GET['date'];      FI.created_at LIKE '$date %' AND
$spt = $_GET['spt'];





$sql = "
SELECT DISTINCT
    FI.id,
    PD.name AS Product_Name,
    FI.quantity,
    FI.created_at,
    FI.user_id,
    (SELECT CONCAT(first_name, ' ', last_name) AS names FROM employee WHERE user_id = FI.user_id) AS usernames
FROM
    FinishedProduct FI
JOIN products PD ON
    FI.product_id = PD.id
WHERE
    FI.spt = $spt
ORDER BY
    FI.created_at DESC
LIMIT 5";



$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    $myid = $row['sales_id'];
    $num += 1;





    $value .= '

        <tr>

        <td style="font-size: 14px;">'.$num.'. '.$row['Product_Name'].'</td>
        <td style="font-size: 14px;">'.$row['quantity'].'</td>
        <td style="font-size: 14px;">'.$row['usernames'].'</td>
        <td style="font-size: 14px;">'.$row['created_at'].'</td>
    
        </tr>

        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
?>