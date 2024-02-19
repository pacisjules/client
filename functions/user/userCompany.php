<?php
require_once '../connection.php';
//require '../systemhistory.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // Get the form data
    $company_id = $_GET['id'];
    
    // Check if the username or email exists in the database
    $sql = "SELECT * FROM `companies` WHERE id=$company_id";
    $result = $conn->query($sql);

    // If there is a match, check the password
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    

        //Set History
        //AddHistory($row['id'],"User Login",$rowInfos['sales_point_id'] );
        
        $data = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'address' => $row['address'],
            'city' => $row['city'],
            'state'=>$row['state'],
            'zip_code'=>$row['zip_code'],
            'country'=>$row['country'],
            'phone'=>$row['phone'],
            'email'=>$row['email'],
            'website'=>$row['website'],
            'created_at'=>$row['created_at']
           
        );
        
        $json = json_encode($data);
        
        echo $json;
        
       
        
        //exit();
    } else {

        // If the password is incorrect, show an error message
        header('HTTP/1.1 500 Internal Server Error');
        echo "Invalid password.";
    }
    } else {

    // If the username or email doesn't exist, show an error message
    header('HTTP/1.1 500 Internal Server Error');
    echo "User not found.";
    }


// Close the database connection
$conn->close();
?>