<?php
// Include the database connection file
require_once '../connection.php';



//Set master path

header('Content-Type: application/json');



  //Get all sales by date
  $date = $_GET['date'];
  $spt = $_GET['spt'];




    $sql = "
    SELECT
DISTINCT
    SUM(total_amount) AS Totat_sales_Amount,
    SUM(total_benefit) AS Totat_sales_Benefits,
    COUNT(*) AS Sales_Count
FROM
    sales SL
WHERE 
SL.sales_point_id=$spt AND SL.created_time LIKE '$date %'
    ";


    $result = $conn->query($sql);


    
$data = array();
while ($row = $result->fetch_assoc()) {
    $data['Total_sales_Amount'] = $row['Totat_sales_Amount'];
    $data['Total_sales_Benefits'] = $row['Totat_sales_Benefits'];
}

// Send the data as JSON response
echo json_encode($data);
    

?>    
