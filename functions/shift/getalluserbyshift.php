<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$shift_id = $_GET['shift_id'];


// Retrieve all users from the database
$sql = "SELECT US.id,US.status,US.shift_id, (select names from shift WHERE id=US.shift_id) as shift_name,EP.first_name,EP.last_name, US.username, US.email, EP.phone, US.user_category, (select category_name from users_category WHERE cat_id=US.user_category) as category_name FROM users US, employee EP WHERE US.id=EP.user_id AND US.company_ID=$comID AND US.shift_id=$shift_id
ORDER BY EP.hire_date DESC ";

$result = mysqli_query($conn, $sql);
$data = array();


$num=0;


// Convert the results to an array of objects
$comp = array();

while ($row = $result->fetch_assoc()) {
    
   

     $item = array(
        'id'=> $row['id'],
        'status' => $row['status'],
        'shift_id' => $row['shift_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'username' => $row['username'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'shift_name' => $row['shift_name'],
        'category_name' => $row['category_name'],
       
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
