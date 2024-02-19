<?php
// Include the database connection file
require_once '../connection.php';



require_once '../path.php';

//Set master path
$masterHome = $globalVariable."company/getallcompanies.php";
header('Content-Type: application/json');

//$currentPath = $_SERVER['PHP_SELF'];
//echo json_encode("Path: ".$currentPath);

//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_companies") {


        // Retrieve all users from the database
        $sql = "select * from companies";

        $value = "";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {


                $value .='';

                $com = new stdClass();

                $com->id  = $row['id'];
                $com->name = $row['name'];
                $com->address  = $row['address'];
                $com->email  = $row['email'];
                
                $com->city  = $row['city'];
                $com->state  = $row['state'];
                $com->zip_code  = $row['zip_code'];
                $com->country  = $row['country'];

                $com->phone  = $row['phone'];
                $com->website  = $row['website'];
                $com->created_at  = $row['created_at'];

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No Employees List found.";
        }
    }
}
