<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category_id = $_POST["category_id"];
    $spt = $_POST["spt"];

    // Get the form data
    $categoryName = $_POST['categoryName'];
    $managedBy = $_POST['managedBy'];
    $user_id = $_POST['user_id'];

    
    
     $sqlasset = "SELECT categoryName FROM assetCategory WHERE category_id =$category_id";
    $resultp = $conn->query($sqlasset);
    
       $rowp = $resultp->fetch_assoc();
       $getname = $rowp['categoryName'];

    
    
    

    // Update the employee data into the database
    $sql = "UPDATE assetCategory SET categoryName='$categoryName', managedBy=$managedBy 
    WHERE category_id=$category_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "CATEGORY Updated successfully.";
        
        AddHistory($user_id, "Edit Asset Category From : ".$getname." To: ".$categoryName, $spt, "AssetCategoryChange");

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
