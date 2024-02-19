<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/services/searchservicebyname.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];
    $spt = $_GET['spt'];
    $name = $_GET['name'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_services?company=" . $comID . "&spt=" . $spt."&name=".$name) {

        // Retrieve all users from the database
        $sql = "SELECT * FROM services WHERE company_ID=$comID AND sales_point_id=$spt AND 	service_name LIKE '%$name%'";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->service_id  = $row['id'];
                $com->service_name = $row['service_name'];
                $com->area_measure  = $row['area_measure'];
                $com->created_at = $row['created_at'];
                $com->company_ID = $row['company_ID'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];
                $com->description = $row['description'];

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No service List found.";
        }
    }
}
