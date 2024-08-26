<?php

session_start();

if(empty($_SESSION['user_id'])){
    header("Location:login");
}


else{
    $user_id=$_SESSION['user_id'];
    include('functions/connection.php');
    $query=mysqli_query($conn,"SELECT * FROM employee WHERE user_id='{$user_id}'");
    while($row=mysqli_fetch_array($query)){
        $names= $row['first_name']." ".$row['last_name'];
        $email=$row['email'];
        $phone=$row['phone'];
        $sales_point_id=$row['sales_point_id'];
    }


    // Set the timeout duration (5 minutes = 300 seconds)
$timeout_duration = 120;

// Check if the user is logged in
if (empty($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location:logout");
    exit();
} else {

        // Check if 'last_activity' is set
        if (isset($_SESSION['last_activity'])) {
            // Calculate the elapsed time since the last activity
            $elapsed_time = time() - $_SESSION['last_activity'];
    
            // If the elapsed time is greater than the timeout duration, log out the user
            if ($elapsed_time > $timeout_duration) {
                session_unset();     // Unset session variables
                session_destroy();   // Destroy the session
                header("Location:logout"); // Redirect to login page with a timeout message
                exit();
            }
        }
    
        // Update the last activity time stamp
        $_SESSION['last_activity'] = time();
}
}