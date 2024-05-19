<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');


$dep_id = $_GET['dep_id'];
$trainer_id = $_GET['trainer_id'];


// Retrieve all users from the database
$sql = "SELECT *,
(SELECT departements.departement_name AS depa FROM departements WHERE departements.dep_id=trainers.dep_id)AS departement 
FROM 
trainers 
LEFT JOIN courses ON trainers.trainer_id=courses.trainer_id
WHERE trainers.dep_id=$dep_id AND trainers.trainer_id=$trainer_id
        ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {

     $item = array(
        'trainer_id'=> $row['trainer_id'],
        'full_name' => $row['full_name'],
        'phone' => $row['phone'],
        'address' => $row['address'],
        'qualification' => $row['qualification'],
        'course_id' => $row['course_id'],
        'course_name' => $row['course_name'],
        'duration' => $row['duration'],
        'departement' => $row['departement'],
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
