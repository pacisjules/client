<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create an instance of PHPMailer
$mail = new PHPMailer(true);



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
    $mail->addAddress('pacisjules@gmail.com', 'Recipient Name'); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = '
    <table style="width:100%">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>John</td>
            <td>3</td>
            <td>$100</td>
        </tr>
        <tr>
            <td>Smith</td>
            <td>5</td>
            <td>$500</td>
        </tr>
        <tr>
            <td>Johnson</td>
            <td>2</td>
            <td>$200</td>
        </tr>
    </table>
    ';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send the email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


