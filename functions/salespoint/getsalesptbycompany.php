<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/salespoint/getsalesptbycompany.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    $com_id = $_GET['com_id'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_sales_point?com_id=" . $com_id) {

        // Retrieve all users from the database
        $sql = "SELECT * FROM salespoint WHERE company_ID=$com_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->sales_point_id  = $row['sales_point_id'];
                $com->manager_name = $row['manager_name'];
                $com->location = $row['location'];
                $com->phone_number = $row['phone_number'];
                $com->company_ID = $row['company_ID'];
                $com->email = $row['email'];

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
