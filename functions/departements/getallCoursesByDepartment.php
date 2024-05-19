<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$dep_id = $_GET['dep_id'];


// Retrieve all users from the database
$sql = "
SELECT 
DE.dep_id,DE.departement_name,DE.chef_dept,DE.chef_tel,PR.course_id ,PR.course_name,PR.course_code,PR.duration,PR.created_at,PR.user_id,TR.full_name 
FROM 
departements DE
LEFT JOIN courses PR ON DE.dep_id=PR.dep_id
LEFT JOIN trainers TR ON PR.trainer_id=TR.trainer_id
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
        'course_id ' => $row['course_id'],
        'course_name' => $row['course_name'],
        'course_code' => $row['course_code'],
        'duration' => $row['duration'],
        'full_name'=> $row['full_name'],
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
