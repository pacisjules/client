<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "
       
WITH MonthlySales AS (
    SELECT 
        product_id,
        SUM(quantity) AS total_quantity_sold,
        SUM(total_amount) AS total_sales_amount
    FROM 
        sales
    WHERE 
        sales_point_id = 6
        AND created_time >= DATE_FORMAT(CURDATE(), '%Y-%m-01') -- Start of the current month
        AND created_time < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01') -- Start of the next month
    GROUP BY 
        product_id
)
SELECT 
    PD.id, 
    PD.name, 
    PD.price, 
    PD.image, 
    PD.benefit, 
    PD.status,
    PD.eid, 
    PD.eimage, 
    PD.description, 
    PD.created_at,
    IFNULL(INV.quantity, 0) AS invquantity,
    IFNULL(MS.total_quantity_sold, 0) AS total_quantity_sold,
    IFNULL(MS.total_sales_amount, 0) AS total_sales_amount
FROM 
    products PD
    LEFT JOIN inventory INV ON PD.id = INV.product_id
    LEFT JOIN MonthlySales MS ON PD.id = MS.product_id
WHERE 
    PD.company_ID = $comID
    AND PD.sales_point_id = $spt 
ORDER BY 
    total_quantity_sold DESC
LIMIT 50;

        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();
$qtycolor='';

while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $current_quantity="";

    $sqlInventory = "SELECT quantity FROM inventory WHERE product_id=$myid";
    $resultInv = mysqli_query($conn, $sqlInventory);
    $rowInv = $resultInv->fetch_assoc();

    if(empty( $rowInv['quantity'])){
        $current_quantity =0;
        $qtycolor="red";
    }else{
        $current_quantity = $rowInv['quantity'];
        $qtycolor="green";
    }
    
    $sts="";
    $endis="";
    $icon="";

    if($row['status']==1){
        $sts="Active";
        $endis="btn btn-danger";
        $icon="bi bi-x-circle";
    }else{
        $sts="Not Active";
        $endis="btn btn-success";
        $icon="fa fa-check-square text-white";
    }

    $num+=1;
    $formatted_money = number_format($row['price']);
    $pro_image="../uploads/noimage.jpg";

    if(!empty($row['image'])){
        $pro_image = "../uploads/".$row['image'];
    }else if(!empty($row['eid'])){
        
        $pro_image = $row['eimage'];
     } else{
  
        $pro_image = "../uploads/noimage.jpg";
    }
    

    $value .= '
                <div class="pro" onclick="addCartTablet(`'.$row['id'].'`, `'.$row['name'].'`,`'.$current_quantity.'`, `'.$row['price'].'`,`'.$row['benefit'].'`)">
                <div class="header">
                <img src="'.$pro_image.'" alt="" srcset="">
                </div>
                <div class="whole_body">
                    <h2>'.$row['name'].' <span style="color:'.$qtycolor.'">('.$current_quantity.')</span></h2>
                    <p>'.$formatted_money.' Rwf</p>
                </div>
            </div>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
