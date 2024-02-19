<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve the POST data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $company_name = $_POST['company_name'];
    $company_ID = $_POST['company_ID'];
    $userType = $_POST['userType'];
    $salepoint_id = $_POST['salepoint_id'];

    // Employees Information
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $salary = $_POST['salary'];
    $hired_date = $_POST['hired_date'];
    $phone = $_POST['phone'];

    // Insert the user data into the database
    $sql = "INSERT INTO users (username, email, password, company_name, company_ID, userType, salepoint_id) VALUES ('$username', '$email', '$password','$company_name','$company_ID','$userType','$salepoint_id')";


    if ($conn->query($sql) === TRUE) {

       

            // Get the last inserted user ID
            $sqlGet = "SELECT MAX(id) AS last_id FROM users";
            $resultInfos = $conn->query($sqlGet);
            $rowInfos = $resultInfos->fetch_assoc();
            $CURRENT_USER_ID = $rowInfos['last_id'];

            // Insert the user data into the database
            $sqlInsertEmployee = "INSERT INTO employee (first_name, last_name, email, hire_date, salary, phone, sales_point_id, user_id) VALUES ('$f_name', '$l_name', '$email','$hired_date','$salary','$phone','$salepoint_id', '$CURRENT_USER_ID')";


            
            if ($conn->query($sqlInsertEmployee) === TRUE) {
                
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "User created successfully and its employee profile.";
             }
    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
