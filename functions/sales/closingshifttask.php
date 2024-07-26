<?php
// Include the database connection file
require_once '../connection.php';
require_once '../vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $spt = $_POST["spt"];
    $record_id = $_POST['record_id'];
    $total = $_POST['total'];
    $salesnumber = $_POST["salesnumber"];
    $user_id = $_POST['user_id'];
    $end = date('Y-m-d H:i:s');

    $user_id = $_SESSION['user_id'];
    $login_time = $_SESSION['Logged_on'];


    // Update the employee data into the database
    $sql = "INSERT INTO `close_checkout`(`user_id`, `shiftrecord_id`, `amount`, `sales_number`, `closing_time`, `spt`)
     VALUES ('$user_id','$record_id','$total','$salesnumber','$end','$spt')";


    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "Customer Updated successfully.";


        $sqlshift = "UPDATE `shift_records` SET `end`='$end', `shift_status`=2 WHERE `record_id` =$record_id ";
        
        $sql_user = "
                   SELECT
                    ep.first_name,
                    ep.last_name,
                    (
                    SELECT
                        location
                    FROM
                        salespoint
                    WHERE
                        sales_point_id = ep.sales_point_id
                    ) AS location,
                    (select email from companies where id =us.company_ID) as email
                    FROM
                        employee ep,
                     users us
                    WHERE
                        ep.user_id = $user_id and ep.user_id=us.id;
                    ";
        $result_user = $conn->query($sql_user);
        $row_user = $result_user->fetch_assoc();
        

        if ($conn->query($sqlshift) === TRUE) {
            // Return a success message
            header('HTTP/1.1 201 Created');
            echo "Customer Updated successfully.";
            
            

            $subject="Shift closed by ".$row_user['first_name']." ".$row_user['last_name'];
            $email = $row_user['email'];

// '<center><h1>Shift Closing notification</h1><p>Shift closed by '.$row_user['first_name'].' '.$row_user['last_name'].' at '.$row_user['location'].'Closing amount: '.$total>'</p></center>';
            // Send email

            try {
                // Server settings
                $mail->SMTPDebug = 3; // Enable verbose debug output
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.titan.email'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'infos@selleasep.com'; // SMTP username
                $mail->Password = 'Ishimuko@123'; // SMTP password
                $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, 'tls' also accepted
                $mail->Port = 465; // TCP port to connect to
            
                // Recipients
                $mail->setFrom('infos@selleasep.com', 'Selleaseap App');
                $mail->addAddress($email, 'Recipient Name'); // Add a recipient
            
                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = '
    <center><h1>Shift Closing notification</h1>
    <table style="width:70%" border="2">
        <tr>
            <th style="text-align:left">Closed by</th>
            <th style="text-align:left">Sales point</th>
            <th style="text-align:left">Amount</th>
        </tr>
        <tr>
            <td style="text-align:left; font-size:15px">'.$row_user['first_name'].' '.$row_user['last_name'].'</td>
            <td style="text-align:left"; font-size:15px>'.$row_user['location'].'</td>
            <td style="text-align:left; font-weight:bold; font-size:18px"><b>'.number_format($total, 0, ',', ','). ' Rwf </b></td>
        </tr>
        
    </table>
    <p>Thank you for using Selleasep</p>
    </center>
    ';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                // Send the email
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // End sending Email

            // Update logout time in the loginfo table
            $logout_time = date("Y-m-d H:i:s");
            $sql = "UPDATE loginfo SET logout_time = '$logout_time' WHERE login_time = '$login_time'";

            // Success, proceed to session unset and redirection
            session_unset();
            header('Location: login');

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
