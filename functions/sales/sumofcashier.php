<?php
// Include the database connection file
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

// Get all sales by date
$user_id = $_GET['user_id'];
$spt = $_GET['spt'];

$shift_id = 0;

// SQL query
$sql_in_shift = "
SELECT record_id
FROM shift_records
WHERE spt = $spt
AND `end` = '0000-00-00 00:00:00'
AND shift_status = 1
ORDER BY record_id DESC
LIMIT 1
";

// Execute query
$result_in_shift = $conn->query($sql_in_shift);

if ($result_in_shift->num_rows > 0) {
    // Fetch the result row
    $row_in_shift = $result_in_shift->fetch_assoc();
    // Set the shift_id
    $shift_id = $row_in_shift['record_id'];
}

$sql = "
SELECT 
    IFNULL(SUM(SL.total_amount), 0) AS total,
    US.username,
    SR.record_id,
    IFNULL(COUNT(SL.sales_id), 0) AS salesnumber,
    (select names from shift where id = US.shift_id) as shift_names
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

// Get the total amount by shift record id
$shit_getsale_sum = "
SELECT 
    SUM(total_amount) AS total_sum, 
    (
        SELECT CONCAT(first_name, ' ', last_name) 
        FROM employee 
        WHERE user_id = sales.user_id
    ) AS user_name,
    (select names from shift where shift.id=users.shift_id) as shift_names
FROM sales, users 
WHERE sales.usershift_record = $shift_id AND sales.user_id=users.id;

";

$result_getsale_sum = $conn->query($shit_getsale_sum);
$row_get_sums = $result_getsale_sum->fetch_assoc();

// Initialize an array to store the data
$data = array();

while ($row = $result->fetch_assoc()) {
    $total = $row['total'];
    $formattedTotal = number_format($total, 0, '.', ',');

    $item = array(
        'total' => $formattedTotal,
        'username' => $row['username'],
        'record_id' => $row['record_id'],
        'salesnumber' => $row['salesnumber'],
        'shift_names' => $row_get_sums['shift_names'],
        'total_sum' => number_format($row_get_sums['total_sum'], 0, '.', ','),
        'user_name' => $row_get_sums['user_name']
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
