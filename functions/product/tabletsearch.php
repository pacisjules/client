<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];
$name = $_GET['name'];


// Retrieve all users from the database
$sql = "SELECT DISTINCT PD.id, PD.name, PD.price,PD.image, PD.benefit, PD.status, PD.description,PD.created_at ,IFNULL(INV.quantity, 0) AS invquantity
        FROM products PD
        LEFT JOIN inventory INV ON PD.id = INV.product_id
        WHERE PD.company_ID = $comID
        AND PD.name LIKE '%$name%'
        AND PD.sales_point_id = $spt 
       ORDER BY PD.created_at DESC
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
    if(!empty($row['image'])){
        $pro_image = "uploads/".$row['image'];
    }else{
        $pro_image = "uploads/noimage.jpg";
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
