<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/sales/daytotalandcount.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  //Get all sales by date
  $date = $_GET['date'];
  $comID = $_GET['company'];

  if ($_SERVER['REQUEST_URI'] === $masterHome . "/DaysTotal?date=" . $date . "&company=" . $comID) {



    $sql = "
    SELECT
DISTINCT
    SUM(total_amount) AS Totat_sales_Amount,
    SUM(total_benefit) AS Totat_sales_Benefits,
    COUNT(*) AS Sales_Count
FROM
    sales SL
WHERE 
SL.sales_point_id IN (select sales_point_id  from salespoint where 	company_ID=$comID) AND SL.created_time LIKE '$date %'
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Convert the results to an array of objects
      $comp = array();
      $numid = 1;
      while ($row = $result->fetch_assoc()) {

        $com = new stdClass();
        $com->Totat_sales_Amount  = $row['Totat_sales_Amount'];
        $com->Totat_sales_Benefits = $row['Totat_sales_Benefits'];
        $com->Sales_Count = $row['Sales_Count'];
        $comp[] = $com;
      }

      // Return the users as JSON
      header('Content-Type: application/json');
      echo json_encode($comp);
    } else {
      // Return an error message if no users were found
      header('HTTP/1.0 404 Not Found');
      echo "No List found.";
    }
  }
}
