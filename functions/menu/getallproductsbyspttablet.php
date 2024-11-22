<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "

SELECT 
    PD.id, 
    PD.name, 
    PD.price, 
    PD.image, 
    PD.status, 
    PD.description

FROM 
    products PD

WHERE 
    PD.company_ID = $comID
    AND PD.sales_point_id = $spt 


        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();
$qtycolor='';

while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    

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
    }else{
        $pro_image = "../uploads/noimage.jpg";
    }
    

    $value .= '
                <div class="pro" onclick="addCartTablet(`'.$row['id'].'`, `'.$row['name'].'`, `'.$row['price'].'`)">
                <div class="header">
                <img src="'.$pro_image.'" alt="" srcset="">
                </div>
                <div class="whole_body">
                    <h2>'.$row['name'].' <span style="color:'.$qtycolor.'"></h2>
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
