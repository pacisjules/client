<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ItemID = $_POST["ItemID"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Get the form data
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];
    $Price = $_POST['Price'];

    // Update the employee data into the database
    $sql = "UPDATE menu_items SET Price='$Price', Description='$Description', Name='$Name' 
    WHERE ItemID=$ItemID";


    if ($conn->query($sql) === TRUE) {

        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Menu item Updated successfully.";

        //Set History
        AddHistory($UserID,"Menu item Updated ".$Name,$salespt_id);

    } else {

        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
