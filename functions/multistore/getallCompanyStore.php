<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT `store_id`, `storename`, `storekeeper`, `phone`, `address`, `company_ID`, `created_at` FROM `store` WHERE `company_ID` = $comID
        ORDER BY `created_at` ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['store_id'];
   
    $num+=1;

    $value .= '
       <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">'.$row['storename'].'</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">'.$row['storekeeper'].'</h5>
                        <p style="text-align: center;color:rgb(0,26,53);">'.$row['address'].'</p>
                     <div style="display:flex;flex-direction:column;">
                     <a class="nav-link active" href="storedetails.php?store_id=' . $myid . '">  <button style="background-color: rgb(0,26,53); color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;">Current Stock</button></a>
                        <a class="nav-link active" href="combinationMonthlyReport.php?store_id=' . $myid . '">  <button style="background-color: rgb(0,26,53); color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;">View Report</button></a>
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
