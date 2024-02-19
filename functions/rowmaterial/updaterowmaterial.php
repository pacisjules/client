<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $raw_material_id = $_POST["raw_material_id"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Retrieve the POST data
    $raw_material_name = $_POST['raw_material_name'];
    $unit_of_measure = $_POST['unit_of_measure'];
    
    $sqlproduct = "SELECT raw_material_name,unit_of_measure FROM rawmaterials WHERE raw_material_id=$raw_material_id";
    $resultp = $conn->query($sqlproduct);
    
       $rowp = $resultp->fetch_assoc();
       $getraw_material_name = $rowp['raw_material_name'];
       $getunity = $rowp['unit_of_measure'];

    // Update the employee data into the database
    $sql = "UPDATE rawmaterials SET 
    raw_material_name='$raw_material_name', 
    unit_of_measure='$unit_of_measure'
     
    
    WHERE raw_material_id=$raw_material_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Product Updated successfully.";

        //Set History
        AddHistory($UserID,"Edit row material From: ".$getraw_material_name." To: ".$raw_material_name. " And  Unity Type From : ".$getunity." To: ".$unit_of_measure,$salespt_id,"RowMaterialChange");

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
