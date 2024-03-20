<?php
// Include the database connection file
require_once '../connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    // Retrieve the location of the sales point by ID
    $sql = "SELECT location FROM salespoint WHERE sales_point_id =$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the location
        $row = $result->fetch_assoc();
        $location = $row['location'];

        // Return the location as JSON
        echo json_encode(array('location' => $location));
    } else {
        // Return an error message if no location was found
        header('HTTP/1.0 404 Not Found');
        echo "Location not found.";
    }
}
?>
