<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$spt_id = $_GET['spt_id'];
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];


// Retrieve all users from the database
$sql = "SELECT payments.PaymentMethod,sum(payments.Amount) as totaltransation FROM payments WHERE payments.spt=$spt_id AND payments.PaymentDate >= '$fromDate 00:00:00' AND payments.PaymentDate <= '$toDate 23:59:59' GROUP BY payments.PaymentMethod
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {

   
    $num+=1;

    $value .= '
       <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(44% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">'.$row['PaymentMethod'].'</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">'.$row['totaltransation'].'</h5>    
                    </div>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
