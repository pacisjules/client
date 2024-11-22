<?php
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$countsptshift = $_SESSION['user_shift_is_open'] ?? 0;
$opensptshift = $_SESSION['is_shift_open_inspt'] ?? 0;
$usershift = $_SESSION['allowed_shift'] ?? 0;

// Update the last activity timestamp
$_SESSION['last_activity'] = time();

include('functions/connection.php');

// Check if the user is logged in
if (empty($user_id)) {
    header("Location:login");
} else {

    if ($usershift>0) {
        if ($countsptshift < 1) {
            if ($opensptshift == 1) {
                header("Location:/client/shiftstillopen");
                exit();
            } else {
                header("Location:/client/activateshift");
                exit();
            }


        }
    } 

    
}


    // Query the employee data
    $query = mysqli_query($conn, "SELECT * FROM employee WHERE user_id='{$user_id}'");
    while ($row = mysqli_fetch_array($query)) {
        $names = $row['first_name'] . " " . $row['last_name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $sales_point_id = $row['sales_point_id'];
    }

    // Set the timeout duration (5 minutes = 300 seconds)
    $timeout_duration = 180;

    // Check if 'last_activity' is set
    if (isset($_SESSION['last_activity'])) {
        $elapsed_time = time() - $_SESSION['last_activity'];

        // If the elapsed time exceeds the timeout, log out the user
        if ($elapsed_time > $timeout_duration) {
            session_unset();  // Unset session variables
            session_destroy();  // Destroy the session
            header("Location:logout");
            exit();
        }

        // Update the last activity timestamp
        $_SESSION['last_activity'] = time();
    }




?>
