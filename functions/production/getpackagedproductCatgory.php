<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$category_id = $_GET['category_id'];
$comID = $_GET['company_ID'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "SELECT  PD.id, PD.name, PD.price, PD.benefit, PD.status, PD.description,PD.created_at ,
      IFNULL(INV.quantity, 0) AS invquantity,IFNULL(PG.qty, 0) AS packitems
FROM products PD
LEFT JOIN inventory INV ON PD.id = INV.product_id
LEFT JOIN packaging PG ON PD.id = PG.product_id
WHERE PD.company_ID = $comID
AND PD.sales_point_id = $spt AND PD.category_id=$category_id ORDER BY PD.created_at ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
   
    $num+=1;

    $value .= '
    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
    <h4 style="text-align: center;color:rgb(0,26,53);">'.$row['name'].'</h4>
    <h5 style="text-align: center;color:rgb(0,26,53);">Stock items: '.$row['invquantity'].'</h5>
    <p style="text-align: center;color:rgb(0,26,53);font-size:14px;">Package items : '.$row['packitems'].'</p>
 <div style="display:flex; flex-direction: row;">
   <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;"  data-bs-target="#packaging_modal" data-bs-toggle="modal" onclick="setpackingdata(`'.$myid.'`)">Packing</button>
   <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;" data-bs-target="#transfer_modal" data-bs-toggle="modal" onclick="settransferdata(`'.$myid.'`,`'.$row['packitems'].'`)">Transfer</button>
 </div>
    
</div>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
