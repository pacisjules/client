<?php
// Include the database connection file
require_once '../connection.php';


//Set master path
$masterHome = "/functions/sales/mostsaldproductday.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  //Get all sales by date
  $date = $_GET['date'];
  $spt = $_GET['spt'];

  if ($_SERVER['REQUEST_URI'] === $masterHome . "/DaysTotal?date=" . $date . "&spt=" . $spt) {



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
    ORDER BY total_sold DESC
    LIMIT 5;


    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Convert the results to an array of objects
      $comp = array();
      $numid = 1;
      while ($row = $result->fetch_assoc()) {

        $com = new stdClass();
        $com->product_id  = $row['product_id'];
        $com->Product_name  = $row['Product_name'];
        $com->total_sold = $row['total_sold'];
        $com->Amount = $row['Amount'];
        $com->Benefit = $row['Benefit'];
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
