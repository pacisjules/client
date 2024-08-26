<?php
// Start or resume the session
session_start();

// Set the timeout duration (5 minutes = 300 seconds)
$timeout_duration = 180;

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === true) {
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
} else {
    // If the user is not logged in, redirect to the login page
    header("Location:logout");
    exit();
}
?>
