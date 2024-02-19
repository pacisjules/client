<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
$masterHome = "/functions/restaurent/getall_menu_itemsbycompany.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_menu?company=" . $comID) {

        // Retrieve all users from the database
        $sql = "
        SELECT
    MI.Name,
    MI.Description,
    MI.Price,
    MI.status,
    MC.Name AS category_Name,
    MI.company_ID,
    MI.sales_point_id,
    MI.created_time,
    MI.status
FROM
    menu_items MI,
    menu_categories MC
    WHERE MI.CategoryID=MC.CategoryID AND 
    MI.company_ID='$comID'
        ";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->Name  = $row['Name'];
                $com->Description = $row['Description'];
                $com->category_Name  = $row['category_Name'];
                $com->created_time = $row['created_time'];
                $com->company_ID = $row['company_ID'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->status = $row['status'];

                $comp[] = $com;
            }

            // Return the users as JSON
            header('Content-Type: application/json');
            echo json_encode($comp);
        } else {
            // Return an error message if no users were found
            header('HTTP/1.0 404 Not Found');
            echo "No Service List found.";
        }
    }
}
