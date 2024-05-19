<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$dep_id = $_GET['dep_id'];


// Retrieve all users from the database
$sql = "
SELECT 
DE.dep_id,DE.departement_name,DE.chef_dept,DE.chef_tel,PR.program_id,PR.programtype,PR.program_duration,PR.from_time,PR.to_time,PR.created_at,PR.user_id 
FROM 
departements DE
LEFT JOIN programs PR ON DE.dep_id=PR.dept_id
WHERE DE.dep_id=$dep_id
        ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {
    

     $item = array(
        'dep_id'=> $row['dep_id'],
        'departement_name' => $row['departement_name'],
        'chef_dept' => $row['chef_dept'],
        'chef_tel' => $row['chef_tel'],
        'program_id' => $row['program_id'],
        'programtype' => $row['programtype'],
        'program_duration' => $row['program_duration'],
        'from_time' => $row['from_time'],
        'to_time' => $row['to_time'],
        'created_at' => $row['created_at'],
        'user_id' => $row['user_id'],
       
    );

    $data[] = $item;
}


$responseData = array(
    'data' => $data,
);
// Convert data to JSON
$jsonData = json_encode($responseData);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
