<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $asset_id = $_POST["asset_id"];
    $spt = $_POST["spt"];

    // Get the form data
    $names = $_POST['names'];
    $qty = $_POST['qty'];
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    
    
     $sqlasset = "SELECT asset_name,quantity FROM asset WHERE id=$asset_id";
    $resultp = $conn->query($sqlasset);
    
       $rowp = $resultp->fetch_assoc();
       $getname = $rowp['asset_name'];
       $getquantity = $rowp['quantity'];

    
    
    

    // Update the employee data into the database
    $sql = "UPDATE asset SET asset_name='$names', quantity=$qty ,status='$status'
    WHERE id=$asset_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Customer Updated successfully.";
        
        AddHistory($user_id, "Edit Asset From : ".$getname." To: ".$names. "\n Quantity From : ".$getquantity." To: ".$qty, $spt, "AssetChange");

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
