<?php
// Start a session
session_start();

// Include the database connection file
require_once '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the form data
    $email = $_POST['email'];
    
    // Check if the username or email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    // If there is a match, check the password
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row) {
        //Sending Email for recover password.

        //////////////////////////////////
        
        $ids=$row['id'];
        header('HTTP/1.1 201 Email found Successful');
        
        $data = array(
            'User_id' => $row['id'],
            'Message'=> 'Dear '. $row['username'] .' We sent to you email for new password and you can change after'
        );
        
        $json = json_encode($data);
        
        echo $json;
        
        exit();
    } else {

        // If the password is incorrect, show an error message
        header('HTTP/1.1 500 Internal Server Error');
        echo "Email failed";
    }
    } else {

    // If the username or email doesn't exist, show an error message
    header('HTTP/1.1 500 Internal Server Error');
    echo "User not found.";
    }
}

// Close the database connection
$conn->close();
?>