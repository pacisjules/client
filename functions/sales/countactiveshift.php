<?php
// Include the database connection file
require_once '../connection.php';



header('Content-Type: application/json');



  //Get all sales by date
  $user_id = $_GET['user_id'];





    $sql = "
  SELECT COUNT(*) AS countshift FROM shift_records WHERE user_id=$user_id AND shift_status=1

    ";
// Execute the SQL query
$result = $conn->query($sql);


// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'countshift' => $row['countshift'],
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

