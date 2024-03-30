<?php
$servername = "localhost";
$username = "u774778522_sell_user_db";
$password = "Ishimuko@123";
$dbname = "u774778522_selleasep_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming your Excel file is in the same directory as this PHP script
$target_file = 'products.xlsx'; // Replace with your actual Excel file name

// Insert data into MySQL
$sql = "LOAD DATA INFILE '/client/products.xlsx' INTO TABLE products FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS (name, price, benefit, created_at, company_ID, sales_point_id, status, description, barcode)";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully into MySQL.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
