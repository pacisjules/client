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


    // Convert the results to an array of objects
    $comp = array();
    
    $result = mysqli_query($conn, $sql);   

    $num = 0;
    while ($row = $result->fetch_assoc()) {

  if($row['Sales_Count']<= 1){
    $msg = "Sale";
  }else{
    $msg = "Sales";
  }



      $comp[] = '
      
      <div class="text-uppercase text-primary fw-bold text-xs mb-1">Daily Earnings :  <span>'.$row['Sales_Count'].' </span>'.$msg.'</div>
      <div class="text-dark fw-bold h5 mb-0">Total : <span>Rwf '.number_format($row['Totat_sales_Amount']).'</span></div>
      
      ';

      }

      $value = implode('', $comp);
      // Convert data to JSON
      $jsonData = json_encode($value);
      
      // Set the response header to indicate JSON content
      header('Content-Type: application/json');
      
      // Send the JSON response
      echo $jsonData;
    

?>    
