<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
//header('Content-Type: application/json');

$comID = $_GET['company'];


// Retrieve all users from the database
$sql = "SELECT * FROM page_allowance WHERE `company_id` = $comID
        ORDER BY `prefix` ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
   
    $num+=1;

     $value .= '

        <li class="nav-item">
                <a class="nav-link" href="'.$row['path_name'].'" style="margin-left: 5px;"><i class="'.$row['menu_icon'].'" style="margin-left: 5px; color: #ed3705;"></i> '.$row['page_name'].'</a>
        </li>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
