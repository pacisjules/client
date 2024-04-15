<?php
// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');




//Get all sales by date
// $date = $_GET['date'];     FI.created_at LIKE '$date %' AND 
$company_ID = $_GET['company_ID'];





$sql = "
SELECT DISTINCT
    FI.id,
    FI.product_name,
    FI.quantity,
    FI.created_at,
    FI.user_id,
    FI.standard_code,
    (SELECT CONCAT(first_name, ' ', last_name) AS names FROM employee WHERE user_id = FI.user_id) AS usernames
FROM
product_standard FI

WHERE
    FI.company_id = $company_ID
ORDER BY
    FI.created_at DESC
";



$result = $conn->query($sql);


// Convert the results to an array of objects
$comp = array();
$value = "";
$result = mysqli_query($conn, $sql);


$num = 0;
while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $prod_session = $row['standard_code'];
   
    $num += 1;

    $sts="";
    $style="";
  



    $value .= '

        <tr>

        <td style="font-size: 12px;">'.$num.'. '.$row['product_name'].'</td>
        <td style="font-size: 12px;">'.$row['quantity'].'</td>
        <td style="font-size: 12px;">'.$row['usernames'].'</td>
        <td style="font-size: 12px;">'.$row['created_at'].'</td>
         <td style="font-size: 12px;" class="d-flex flex-row justify-content-start align-items-center">
         <button class="btn btn-success" type="button" data-bs-target="#edit_product_modal" data-bs-toggle="modal" onclick="setUpdates(`'.$row['quantity'].'`, `'.$myid.'`,`'.$row['product_name'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
         <button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="RemoveProductID(`'.$myid.'`,`'.$row['product_name'].'`)"><i class="fa fa-trash"></i></button>
         
         
            <a style="font-size: 12px;margin-left:20px;" class="nav-link active" href="standarddetails.php?session_id=' . $prod_session . '">
                <button class="btn btn-success"  rounded-circle" style="background-color:#040536; border-radius:15px;" type="button">
                    <i class="fas fa-eye" style="font-size:20px; color: white; margin-top:3px;"></i><span style="font-size:15px; color: white; margin-left:13px;">View details</span>
                </button>
            </a>
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
?>