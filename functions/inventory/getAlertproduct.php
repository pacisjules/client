<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');


    $spt = $_GET['spt'];


        // Retrieve all users from the database
        $sql = " 
        
        SELECT
  INV.id,
  INV.product_id,
  PD.name,
  INV.quantity,
  INV.alert_quantity,
  INV.last_updated,
  INV.quantity*100/INV.alert_quantity as perc,
  CASE
    WHEN (INV.quantity) = 0 THEN 'Danger-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=10 THEN 'Danger-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=25 THEN 'High-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=50 THEN 'Medium-Risk'
    WHEN (INV.quantity*100/INV.alert_quantity) <=75 THEN 'Low-Risk'
    ELSE 'Normal'
  END AS STATUS,
  PD.sales_point_id
FROM
  inventory INV
JOIN
  products PD ON INV.product_id = PD.id
WHERE
  INV.quantity <= INV.alert_quantity AND PD.sales_point_id=$spt 
  
  ORDER BY INV.quantity*100/INV.alert_quantity ASC 
  ;

        ";
        $result = $conn->query($sql);


        // Convert the results to an array of objects
        $comp = array();
        
        $result = mysqli_query($conn, $sql);   
        
        $num = 0;
 while ($row = $result->fetch_assoc()) {
       
       if($row['STATUS']==='Danger-Risk'){
        $sty="color:red;";
        $perc="10%";
        $cll="bg-danger";
        $arielv="20";
        $widt="width: 20%;";
        $div = '<div class="progress-bar bg-danger" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="visually-hidden">10%</span></div>';
       }elseif($row['STATUS']==='High-Risk'){
        $sty="color:yellow;";
        $perc="25%";
        $cll="bg-warning";
        $arielv="40";
        $widt="width: 40%;";
        $div = '<div class="progress-bar bg-warning" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"><span class="visually-hidden">25%</span></div>';
       }elseif($row['STATUS']==='Medium-Risk'){
        $sty="color:blue;";
        $perc="50%";
        $cll="bg-primary";
        $arielv="60";
        $widt="width: 60%;";
        $div = ' <div class="progress-bar bg-primary" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="visually-hidden">50%</span></div>';
       }elseif($row['STATUS']==='Low-Risk-Risk'){
        $sty="color:olive;";
        $perc="75%";
        $cll="bg-info";
        $arielv="80";
        $widt="width: 80%;";
        $div = '<div class="progress-bar bg-info" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="visually-hidden">75%</span></div>';
       }else{
        $sty="color:green;";
        $perc="100%";
        $cll="bg-success";
        $arielv="100";
        $widt="width: 100%;";
        $div = '<div class="progress-bar bg-success" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="visually-hidden">100%</span></div>';
       }
           

        $comp[] = '
          
        <h4 class="small fw-bold" style="color:black;">'.$row['name'].' ('.$row['quantity'].')<span class="float-end">'.$perc.'</span></h4>
        <div class="progress mb-4">
        '.$div.'
        </div>
        

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
