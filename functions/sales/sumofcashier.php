<?php
// Include the database connection file
require_once '../connection.php';



header('Content-Type: application/json');



  //Get all sales by date
  $user_id = $_GET['user_id'];
  $spt = $_GET['spt'];





    $sql = "
    SELECT SUM(total_amount) as total ,US.username  FROM sales SL, shift_records SR, users US WHERE sales_point_id=$spt  AND  SL.user_id=$user_id AND SR.user_id=SL.user_id AND SL.user_id=US.id AND SL.created_time > SR.start;


    ";
// Execute the SQL query
$result = $conn->query($sql);


// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'total' => $row['total'],
        'username' => $row['username'],
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
?>      

