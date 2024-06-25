<?php
session_start();
require_once '../connection.php';
//require '../systemhistory.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the form data
    $username = $_POST['UName'];
    $password = $_POST['UPass'];
    
    //SetTime
    $date_time = date('Y-m-d H:i:s');
    
   

    
    // Check if the username or email exists in the database
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    // If there is a match, check the password
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        
        
        
        $ids=$row['id'];
        $id = $row['id'];
       $comp =  $row['company_ID'];
       $sal =  $row['salepoint_id'];
       $usercategory =  $row['user_category'];
       $usershift =  $row['shift_id'];
       $realshift = 0;
       if( $usershift>0){
        $realshift = $usershift;
       }else{
        $realshift = 0;
       }
        
        header('HTTP/1.1 201 Login Successful');
        //Get others users information
        $sqlGet = "SELECT * FROM employee WHERE user_id=$ids";
        $resultInfos = $conn->query($sqlGet);
        $rowInfos = $resultInfos->fetch_assoc();

        $sqlcomp = "SELECT * FROM company_information WHERE company_id=$comp";
        $resultComp = $conn->query($sqlcomp);
        $rowComp = $resultComp->fetch_assoc();


        $sqlcompany = "SELECT * FROM companies WHERE id=$comp";
        $resultCompany = $conn->query($sqlcompany);
        $rowCompany = $resultCompany->fetch_assoc();

        $sqlsa = "SELECT * FROM salespoint WHERE sales_point_id=$sal";
        $resultsa = $conn->query($sqlsa);
        $rowsa = $resultsa->fetch_assoc();

        $sqlog = "INSERT INTO `loginfo`(`user_id`,`login_time`, `sales_point_id`) 
        VALUES ('$id','$date_time','$sal') ";
        $resultlog = $conn->query($sqlog);

        //Set History
        //AddHistory($row['id'],"User Login",$rowInfos['sales_point_id'] );
        
        $data = array(
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'company_name' => $row['company_name'],
            'company_ID'=>$row['company_ID'],
            'salepoint_id'=>$rowInfos['sales_point_id'],
            'phone'=>$rowInfos['phone'],
            'names'=>$rowInfos['first_name']." ".$rowInfos['last_name'],
            'salepoint_id'=>$rowInfos['sales_point_id'],
            'userType'=>$row['userType'],
            'user_category'=>$usercategory, 
            'usershift'=> $realshift,
            'Logged_on'=>$date_time,
            'company_logo'=>$rowComp['logo'],
            'company_color'=>$rowComp['color'],
            'spt_name'=>$rowsa['location'],
            'phonemana'=>$rowsa['phone_number'],
            'phoneboss'=>$rowsa['report_to_phone'],
            'zone'=>$rowCompany['timezone_name'],
            'Message'=> 'Account passed'
        );
        
        $json = json_encode($data);
        
        echo $json;
        
        $_SESSION['user_id'] = $id;
        $_SESSION['Logged_on'] = $date_time;


        
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
}

// Close the database connection
$conn->close();
?>