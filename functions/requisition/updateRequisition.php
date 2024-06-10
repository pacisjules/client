<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $req_id= $_POST["req_id"];

    // Get the form data
    $editproduct = $_POST['editproduct'];
    $editquantity = $_POST['editquantity'];
    $editprice = $_POST['editprice'];
    $total = $editquantity * $editprice;
    // Update the employee data into the database
    $sql = "UPDATE requisition SET product_name='$editproduct', quantity='$editquantity', price='$editprice', total='$total'  
    WHERE id=$req_id";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "requisition Updated successfully.";

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
