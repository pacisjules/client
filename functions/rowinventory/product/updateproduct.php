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
    $benefit = $_POST['benefit'];
    $description=$_POST['description'];
    $barcode =$_POST['barcode'];
    
    $sqlproduct = "SELECT name,price,benefit FROM products WHERE id=$product_id";
    $resultp = $conn->query($sqlproduct);
    
       $rowp = $resultp->fetch_assoc();
       $getp = $rowp['name'];
       $getprice = $rowp['price'];
       $getbenefit = $rowp['benefit'];

    // Update the employee data into the database
    $sql = "UPDATE products SET 
    name='$name', 
    price='$price',
    description='$description', 
    benefit='$benefit', 
    barcode='$barcode' 
    
    WHERE id=$product_id";

    
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Product Updated successfully.";

        //Set History
        AddHistory($UserID,"Edit Product From: ".$getp." To: ".$name. "\n Price From : ".$getprice." To: ".$price."\n Benefit From: ".$getbenefit." To: ".$benefit,$salespt_id,"ProductChange");

    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
