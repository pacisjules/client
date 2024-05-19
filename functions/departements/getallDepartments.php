<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$comID = $_GET['company'];
$spt_id = $_GET['spt_id'];


// Retrieve all users from the database
$sql = "SELECT `dep_id`, `departement_name`, `chef_dept`, `chef_tel`, `company_id`, `spt_id`, `created_at`, `user_id` FROM `departements`  WHERE `company_id` = $comID
        AND `spt_id`=$spt_id  ORDER BY `created_at` ASC
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    $myid = $row['dep_id'];
   
    $num+=1;

    $value .= '
       <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(44% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">Department: '.$row['departement_name'].'</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">Director: '.$row['chef_dept'].'</h5>
                        <p style="text-align: center;color:rgb(0,26,53);"> Tel :'.$row['chef_tel'].'</p>
                     <div style="display:flex; flex-direction: row;">
                     <a class="nav-link active" href="programs.php?dep_id=' . $myid . '">  <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">PROGRAMS</button></a>
                        <a class="nav-link active" href="courses.php?dep_id=' . $myid . '">  <button style="background-color:#071073 ; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">COURSES</button></a>&nbsp;&nbsp;
                        <a class="nav-link active" href="trainers.php?dep_id=' . $myid . '">  <button style="background-color: #38154f; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">TRAINERS</button></a>&nbsp;&nbsp;
                        <a class="nav-link active" href="trainees.php?dep_id=' . $myid . '">  <button style="background-color: #4f1521; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">TRAINEES</button></a>
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
