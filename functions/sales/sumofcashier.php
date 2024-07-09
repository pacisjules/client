<?php
// Include the database connection file
require_once '../connection.php';



header('Content-Type: application/json');



  //Get all sales by date
  $user_id = $_GET['user_id'];
  $spt = $_GET['spt'];





    $sql = "
   SELECT 
    IFNULL(SUM(SL.total_amount), 0) AS total,
    US.username,
    SR.record_id,
    IFNULL(COUNT(SL.sales_id), 0) AS salesnumber
FROM 
    sales SL
JOIN 
    users US ON SL.user_id = US.id
JOIN 
    shift_records SR ON SL.user_id = SR.user_id
WHERE 
    SL.sales_point_id = $spt 
    AND SL.user_id = $user_id 
    AND SR.record_id = (
        SELECT record_id
        FROM shift_records
        WHERE  user_id = $user_id 
        ORDER BY start DESC
        LIMIT 1
    )
    AND SL.created_time > SR.start
    AND SR.shift_status=1;



    ";
// Execute the SQL query
$result = $conn->query($sql);


// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'total' => $row['total'],
        'username' => $row['username'],
        'record_id' => $row['record_id'],
        'salesnumber' => $row['salesnumber'],
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

