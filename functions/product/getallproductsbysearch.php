<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt = $_GET['spt'];
$name=$_GET['name'];

// Retrieve all users from the database
$sql = "SELECT  PD.id, PD.name, PD.price, PD.benefit, PD.status, PD.description,PD.created_at ,IFNULL(INV.quantity, 0) AS invquantity
        FROM products PD
        LEFT JOIN inventory INV ON PD.id = INV.product_id
        WHERE PD.company_ID = $comID
        AND PD.sales_point_id = $spt AND name LIKE '%$name%'";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
    $current_quantity="";

    $sqlInventory = "SELECT quantity FROM inventory WHERE product_id=$myid";
    $resultInv = mysqli_query($conn, $sqlInventory);
    $rowInv = $resultInv->fetch_assoc();

    if(empty( $rowInv['quantity'])){
        $current_quantity =0;
    }else{
        $current_quantity = $rowInv['quantity'];
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

    $value .= '
    <tr>
    <td>'.$num.'. ' . $row['name'] . '</td>
    <td>' . number_format($row['price']) . '</td>
    <td>' . number_format($row['benefit']) . '</td>
    <td>' . number_format($row['invquantity']) . '</td>
    <td>' . $sts . '</td>
    <td>' . $row['created_at'] . '</td>
    <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success" type="button" data-bs-target="#edit_product_modal" data-bs-toggle="modal" onclick="setUpdates(`'.$row['name'].'`,`'.$row['price'].'`, `'.$row['benefit'].'`, `'.$row['description'].'`, `'.$row['id'].'`)"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="RemoveProductID(`'.$row['id'].'`)"><i class="fa fa-trash"></i></button><button class="'.$endis.'" type="button" style="margin-left: 20px;" data-bs-target="#disable-product" data-bs-toggle="modal" onclick="DisableProductID(`'.$row['id'].'`, `'.$row['status'].'`)"><i class="'.$icon.'"></i></button><button class="btn btn-primary" type="button" style="margin-left: 18px;min-width: 128px;" data-bs-target="#purchaseSalespoint_modal" data-bs-toggle="modal" onclick="SetSPProductID(`'.$row['id'].'`)"=><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-fill">
                <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
            </svg>&nbsp; Inventory SP</button>
            
            <button class="btn btn-primary" type="button" style="margin-left: 18px;background: rgb(223,139,78);font-weight: bold;border-color: rgb(255,255,255);width: 151.6875px;" data-bs-target="#purchase_modal" data-bs-toggle="modal" onclick="getProductid(`'.$row['id'].'`)"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cart-fill">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
            </svg>&nbsp; Purchase it Now</button></td>
</tr>
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
