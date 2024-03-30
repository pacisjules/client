<?php
// Include the database connection file
require_once '../connection.php';



header('Content-Type: application/json');



  //Get all sales by date
  $date = $_GET['date'];
  $spt = $_GET['spt'];





    $sql = "
    SELECT
    product_id,
    (select name from products WHERE id=SL.product_id) AS Product_name,
    SUM(quantity) AS total_sold,
    SUM(total_amount) AS Amount,
    SUM(total_benefit) AS Benefit
    
    FROM
        sales SL
    WHERE 
    sales_point_id=$spt AND created_time LIKE '$date %'

    GROUP BY product_id
    ORDER BY Benefit DESC
    LIMIT 3;


    ";
// Execute the SQL query
$result = $conn->query($sql);

// Convert the results to an array of objects
$comp = array();
$result = mysqli_query($conn, $sql);   
$num = 0;

while ($row = $result->fetch_assoc()) {
      if($num==0){
        $cls= "fas fa-circle text-primary";
      }elseif(($num==1)){
        $cls= "fas fa-circle text-success";
      }else{
        $cls= "fas fa-circle text-info";
      }
      $comp[] = '
            <span class="me-2"><i class="'.$cls.'"></i>&nbsp;'.$row['Product_name'].'</span>

      ';
    $num++;
      }

      $value = implode('', $comp);

      // Convert data to JSON
      $jsonData = json_encode($value);
      
      // Set the response header to indicate JSON content
      header('Content-Type: application/json');
      
      // Send the JSON response
      echo $jsonData;
?>      

