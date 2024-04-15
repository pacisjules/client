<?php
// Include the database connection file
require_once '../connection.php';
require_once '../path.php';

//Set master path
$masterHome = $globalVariable . "product/searchproductbyname.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point


$comID = $_GET['company'];
$name = $_GET['name'];


// Retrieve all users from the database
$sql = "SELECT * FROM product_standard CO, unittype UT WHERE CO.company_id=$comID AND UT.unit_id=CO.unit_id  AND CO.product_name LIKE '%$name%'";

$value = "";
$result = mysqli_query($conn, $sql);
$num = 0;


$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  
   


    $num+=1;
    $value .= '
            <p style="margin-bottom: 0px; cursor:pointer;" class="hover-effect" onclick="getSelected(`' . $row['standard_code'] . '`,`' . $row['product_name'] . '`,`' . $row['quantity'] . '`,`' . $row['unitname'] . '`)">   ' . $num . '.  ' . $row['product_name'] .'  '.( $row['unitname'] ).'</p>
            ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
