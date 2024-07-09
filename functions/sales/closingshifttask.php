<?php
// Include the database connection file
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $cashinhand = $_POST["cashinhand"];
    $mobilemoney = $_POST['mobilemoney'];
    $bank = $_POST['bank'];
    $spt = $_POST["spt"];
    $record_id = $_POST['record_id'];
    $total = $_POST['total'];
    $salesnumber = $_POST["salesnumber"];
    $user_id = $_POST['user_id'];
    $end = date('Y-m-d H:i:s');


    // Update the employee data into the database
    $sql = "INSERT INTO `close_checkout`(`user_id`, `shiftrecord_id`, `amount`, `cashinhand`, `mobilemoney`, `bank`, `sales_number`, `closing_time`, `spt`)
     VALUES ('$user_id','$record_id','$total','$cashinhand','$mobilemoney','$bank','$salesnumber','$end','$spt')";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Customer Updated successfully.";


        $sqlshift = "UPDATE `shift_records` SET `end`='$end', `shift_status`=2 WHERE `record_id` =$record_id ";

        if ($conn->query($sqlshift) === TRUE) {
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "Customer Updated successfully.";
        }else{
            header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sqlshift . "<br>" . $conn->error;  
        }




    } else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
