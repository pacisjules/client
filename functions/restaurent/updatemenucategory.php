<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $CategoryID = $_POST["CategoryID"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Get the form data
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];

    // Update the employee data into the database
    $sql = "UPDATE menu_categories SET Name='$Name', Description='$Description'  
    WHERE CategoryID=$CategoryID";

    
    if ($conn->query($sql) === TRUE) {
        
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Menu category Updated successfully.";

        //Set History
        AddHistory($UserID,"Menu category Updated ".$Name,$salespt_id);

    } else {

        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}