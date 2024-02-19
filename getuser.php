<?php

session_start();

if(empty($_SESSION['user_id'])){
    header("Location:login.php");
}
else{
    $user_id=$_SESSION['user_id'];
    include('functions/connection.php');
    $query=mysqli_query($conn,"SELECT * FROM employee WHERE user_id='{$user_id}'");
    while($row=mysqli_fetch_array($query)){
        $names= $row['first_name']." ".$row['last_name'];
        $email=$row['email'];
        $phone=$row['phone'];
        $sales_point_id=$row['sales_point_id'];
    }
}