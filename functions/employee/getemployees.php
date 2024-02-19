<?php
// Include the database connection file
require_once '../connection.php';



//Set master path
$masterHome = "/functions/employee/getemployees.php";
header('Content-Type: application/json');

//echo json_encode("Path: ".$masterHome);
//Get employees by company_ID and sales Point

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $comID = $_GET['company'];

    //Sales points Get
    if ($_SERVER['REQUEST_URI'] === $masterHome . "/all_employees?company=" . $comID) {


        // Retrieve all users from the database
        $sql = "SELECT EM.employee_id,EM.first_name, EM.last_name, EM.email, EM.phone, EM.hire_date, EM.salary,EM.sales_point_id,EM.user_id,
        (select location from salespoint WHERE sales_point_id =EM.sales_point_id) as sales_point_location,
        (select manager_name from salespoint WHERE sales_point_id =EM.sales_point_id) as sales_point_manager
        FROM employee EM, users US WHERE EM.user_id=US.id AND US.company_ID=$comID";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Convert the results to an array of objects
            $comp = array();
            while ($row = $result->fetch_assoc()) {

                $com = new stdClass();

                $com->employee_id  = $row['employee_id'];
                $com->names = $row['first_name']." ".$row['last_name'];
                $com->email  = $row['email'];
                $com->hire_date = $row['hire_date'];
                $com->salary = $row['salary'];
                $com->phone = $row['phone'];
                $com->sales_point_id = $row['sales_point_id'];
                $com->user_id = $row['user_id'];
                $com->sales_point_location = $row['sales_point_location'];
                $com->sales_point_manager = $row['sales_point_manager'];

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
