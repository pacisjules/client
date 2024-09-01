





<?php
include('functions/connection.php');
// session_start();
// $user_id = $_SESSION['user_id'];
// $login_time = $_SESSION['Logged_on'];
// session_unset();
// header('Location:login');
session_start();
$user_id = $_SESSION['user_id'];
$login_time = $_SESSION['Logged_on'];
// // Database connection parameters
// $servername = "86.38.202.52";
// // $servername = "localhost";
// $username = "u774778522_sell_user_db";
// $password = "Ishimuko@123";
// $dbname = "u774778522_selleasep_db";


//
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "u774778522_selleasep_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function cleanServerSideData() {

    // Clear session data
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Clear cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/');
            setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
        }
    }
}

// Update logout time in the loginfo table
$logout_time = date("Y-m-d H:i:s");
$sql = "UPDATE loginfo SET logout_time = '$logout_time' WHERE login_time = '$login_time'";


if ($conn->query($sql) === TRUE) {
    // Success, proceed to session unset and redirection
    session_unset();
    cleanServerSideData();

    ?>
    <script>
    function cleanClientSideData() {
        // Clear local storage
        localStorage.clear();

        // Clear session storage
        sessionStorage.clear();

        // Clear indexedDB (can be used for Web SQL-like storage)
        indexedDB.databases().then(databases => {
            databases.forEach(db => {
                indexedDB.deleteDatabase(db.name);
            });
        });

        // Clear caches
        if ('caches' in window) {
            caches.keys().then(function(names) {
                for (let name of names) caches.delete(name);
            });
        }
        
        // Clear cookies using JavaScript
        document.cookie.split(";").forEach(function(c) {
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
        });
    }
    cleanClientSideData();
    </script>

    <?php

    header('Location: login');
} else {
    // Error handling, if needed
    echo "Error updating record: " . $conn->error;
}





$conn->close();
?>
