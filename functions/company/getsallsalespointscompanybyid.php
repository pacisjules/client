<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/company/getsallsalespointscompanybyid.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = $_GET['id'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/company?id=" . $id) {
        // Retrieve all users from the database
        $sql = "SELECT
        SP.sales_point_id,
        SP.location,
        SP.manager_name,
        SP.phone_number,
        SP.email,
        SP.company_ID,
        SP.created_at,
        (select COUNT(*) from products where sales_point_id=SP.sales_point_id) AS Products_Count
    FROM 
        salespoint SP
    WHERE
        SP.company_ID =$id";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->sales_point_id  = $row['sales_point_id'];
                $com->location = $row['location'];
                $com->manager_name = $row['manager_name'];
                $com->phone_number = $row['phone_number'];

                $com->email = $row['email'];
                $com->company_ID = $row['company_ID'];
                $com->created_at = $row['created_at'];
                $com->Products_Count = $row['Products_Count'];

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No Company List found.";
        }
    }
}
