<?php
require_once '../connection.php';
$request_id = $_POST['id'];

$sql="
UPDATE requestransfer SET request_status = 3 WHERE id = '$request_id'
";

if ($conn->query($sql) === TRUE) {
    header('HTTP/1.1 201 Created');
    echo "New Request Rejected SUCCESSFULLY:";
} else {
    // Return an error message
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: " . $conn->error;
}