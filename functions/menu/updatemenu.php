<?php
// Include the database connection file
require_once '../connection.php';
require '../systemhistory.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $product_id = $_POST["product_id"];
    $salespt_id = $_POST["salespt_id"];
    $UserID = $_POST["user_id"];

    // Retrieve the POST data
    $name = $_POST['name'];
    $price = $_POST['price'];

    $description=$_POST['description'];



    $sqlproduct = "SELECT name,price FROM menu_items WHERE id=$product_id";
    $resultp = $conn->query($sqlproduct);
    
       $rowp = $resultp->fetch_assoc();
       $getp = $rowp['name'];
       $getprice = $rowp['price'];
 

    // Update the employee data into the database
    $sql = "UPDATE menu_items SET 
    name='$name', 
    price='$price',
    description='$description', 
  
    WHERE id=$product_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "menu_items Updated successfully.";
        $getbenefit = 0;
        $benefit = 0;

        //Set History
        AddHistory($UserID,"Edit menu_items From: ".$getp." To: ".$name. "\n Price From : ".$getprice." To: ".$price."\n Benefit From: ".$getbenefit." To: ".$benefit,$salespt_id,"Menuchange");

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
