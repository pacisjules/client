<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/expenses/dayExpenses.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //Get all data
    $salespoint=$_GET['salespoint'];
    $date=$_GET['date'];

    if ($_SERVER['REQUEST_URI'] === $masterHome . "/getTotalExpenses?salespoint=" . $salespoint . "&date=" . $date) {

        // Retrieve all users from the database
        $sql = "SELECT SUM(amount) AS Today_Expenses FROM shop_expenses WHERE created_date LIKE '$date%' AND sales_point_id=$salespoint";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();
                $com->Today_Expenses = $row['Today_Expenses'];
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
