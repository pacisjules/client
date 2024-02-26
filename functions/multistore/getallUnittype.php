<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

// Retrieve all users from the database
$sql = "SELECT `unit_id`, `unitname`, `abbreviation`, `description` FROM `unittype`
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['unit_id'];
   
    $num+=1;

     $value .= '

        <option value = '.$row['unit_id'].'>'.$num.'. '.$row['abbreviation'].'</option>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
