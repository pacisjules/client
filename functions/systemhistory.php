<?php

require_once 'connection.php';
// Create connection
$network = new mysqli($servername, $username, $password, $dbname);

function AddHistory($user_id, $action, $sales_point, $section)
{
    global $network;

    // Insert the history data into the database
    $sql = "INSERT INTO history (user_id, action, sales_point_id, section) VALUES ('$user_id', '$action', '$sales_point','$section')";

    if ($network->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "History added successfully.";
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $network->error;
    }
}
