<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
//header('Content-Type: application/json');

$cat_id = $_GET['cat_id'];


// Retrieve all users from the database
$sql = "SELECT PA.path_name, PA.page_name,PA.menu_icon,PA.id, (select category_name from users_category where cat_id=UC.cat_id) as user_category_name FROM page_allowance PA, permissions UC where PA.id=UC.page_id AND UC.cat_id=$cat_id";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['id'];
   
    $num+=1;

     $value .= '

        <li class="nav-item" >
                <a class="nav-link"  href="'.$row['path_name'].'" style="margin-left: 5px;text-transform: uppercase;font-weight:bold; display: flex; align-items: center; justify-content: flex-start; gap: 5px"><div class="menu_icon_cont" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px;  color:white; border-radius: 50%;"><i class="'.$row['menu_icon'].'" style=" color: #ed3705;"></i></div> <span class="page_name"> '.$row['page_name'].'</span></a>
        </li>
 
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
