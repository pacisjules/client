<?php
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];
include('functions/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_SESSION['mysalepoint'])){
            header("Location:login");
        }
       
        $start = date('Y-m-d H:i:s');
        $servername = "86.38.202.52";
        $spt = $_SESSION['mysalepoint'];
        
        $sql = "INSERT INTO shift_records(user_id,start,shift_status,spt) VALUES ( '$user_id','$start',1,'$spt')";
        if ($conn->query($sql) === TRUE) {
            
            // SQL query
            $sql = "SELECT *
            FROM shift_records
            WHERE user_id = $user_id
            AND `end` = '0000-00-00 00:00:00'
            AND shift_status = 1
            ORDER BY record_id DESC
            LIMIT 1";

            // Execute query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

            // Fetch the result row
            $row = $result->fetch_assoc();
            
            // Echo the record_id
            $_SESSION['shift_record_id'] = $row['record_id'];
            $_SESSION['user_shift_is_open']=1;
            header("Location:/client/shiftactivated.php");
            $_SESSION['shift_record_started_time'] = $row['start'];
            // echo "1";
            } else {
            header("Location:/client/shiftactivated.php");
            // echo "0";

            }

            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
   
} else {
    echo 'Invalid request method.';
}
?>

