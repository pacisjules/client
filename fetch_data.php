<?php
include('functions/connection.php');

$company = $_GET['company'];

$sql = "
SELECT
    ROW_NUMBER() OVER (ORDER BY sr.user_id) as num,
    (select first_name from employee where user_id=usr.id) as first_name,
    (select last_name from employee where user_id=usr.id) as last_name,
    (select location from salespoint where sales_point_id =sr.spt) as sales_point,
    (select names from shift where id =usr.shift_id) as shift_name,
    (select sum(total_amount)as num from sales where created_time>sr.start AND  sales_point_id=sr.spt) as income_number,
    sr.shift_status
FROM
    shift_records sr,
    users usr
WHERE
    sr.user_id = usr.id AND usr.company_ID =$company AND sr.end = '0000-00-00 00:00:00' AND sr.shift_status = 1 AND usr.shift_id!=0
";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = array(
    "data" => $data
);

echo json_encode($response);

$conn->close();
?>