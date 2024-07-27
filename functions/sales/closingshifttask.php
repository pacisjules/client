<?php
// Include the database connection file
require_once '../connection.php';
// require_once '../vendor/autoload.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer(true);

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $spt = $_POST["spt"];
    $end = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];
    $login_time = $_SESSION['Logged_on'];

    // Check if user is in shift
    $sql_in_shift = "
        SELECT record_id, user_id, start
        FROM shift_records
        WHERE spt = $spt
          AND `end` = '0000-00-00 00:00:00'
          AND shift_status = 1
        ORDER BY record_id DESC
        LIMIT 1
    ";
    $result_in_shift = $conn->query($sql_in_shift);

    if ($result_in_shift && $result_in_shift->num_rows > 0) {
        $row_in_shift = $result_in_shift->fetch_assoc();
        $shift_id = $row_in_shift['record_id'];
        $start = $row_in_shift['start'];

        // Get shift data
        $sqlgetdta = "
            SELECT 
                IFNULL(SUM(SL.total_amount), 0) AS total,
                US.username,
                SR.record_id,
                SR.user_id,
                IFNULL(COUNT(SL.sales_id), 0) AS salesnumber,
                (SELECT names FROM shift WHERE id = US.shift_id) as shift_names,
                (
                    SELECT CONCAT(first_name, ' ', last_name) 
                    FROM employee 
                    WHERE user_id = SR.user_id
                ) AS user_name
            FROM 
                sales SL
            JOIN 
                users US ON SL.user_id = US.id
            JOIN 
                shift_records SR ON SL.user_id = SR.user_id
            WHERE 
                SL.sales_point_id = $spt
                AND SR.record_id = $shift_id
                AND SL.created_time > SR.start
                AND SR.shift_status = 1
        ";
        $resultsqlgetdta = $conn->query($sqlgetdta);
        $rowdata = $resultsqlgetdta->fetch_assoc();

        $total = $rowdata['total'];
        $salesnumber = $rowdata['salesnumber'];

        // Prepare insert query
        $sql = "INSERT INTO close_checkout (user_id, shiftrecord_id, amount, sales_number, closing_time, spt)
                VALUES ('$user_id', '$shift_id', '$total', '$salesnumber', '$end', '$spt')";

        // Debug: Print the SQL query
        echo "SQL Query: $sql<br>";

        // Execute the insert query
        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully.<br>";

            // Update shift record
            $sqlshift = "UPDATE shift_records SET `end`='$end', shift_status=2 WHERE record_id = $shift_id";
            if ($conn->query($sqlshift) === TRUE) {
                echo "Shift record updated successfully.<br>";

                // Get user data
                $sql_user = "
                    SELECT
                        ep.first_name,
                        ep.last_name,
                        (
                            SELECT location
                            FROM salespoint
                            WHERE sales_point_id = ep.sales_point_id
                        ) AS location,
                        (SELECT email FROM companies WHERE id = us.company_ID) AS email
                    FROM
                        employee ep
                    JOIN 
                        users us ON ep.user_id = us.id
                    WHERE
                        ep.user_id = $user_id;
                ";
                $result_user = $conn->query($sql_user);
                $row_user = $result_user->fetch_assoc();

                // // Send email notification
                // $subject = "Shift closed by " . $row_user['first_name'] . " " . $row_user['last_name'];
                // $email = $row_user['email'];

                // try {
                //     $mail->isSMTP();
                //     $mail->Host = 'smtp.titan.email';
                //     $mail->SMTPAuth = true;
                //     $mail->Username = 'infos@selleasep.com';
                //     $mail->Password = 'Ishimuko@123';
                //     $mail->SMTPSecure = 'ssl';
                //     $mail->Port = 465;

                //     $mail->setFrom('infos@selleasep.com', 'Selleaseap App');
                //     $mail->addAddress($email);

                //     $mail->isHTML(true);
                //     $mail->Subject = $subject;
                //     $mail->Body = '
                //         <center><h1>Shift Closing notification</h1>
                //         <table style="width:70%" border="2">
                //             <tr>
                //                 <th style="text-align:left">Closed by</th>
                //                 <th style="text-align:left">Sales point</th>
                //                 <th style="text-align:left">Amount</th>
                //             </tr>
                //             <tr>
                //                 <td style="text-align:left; font-size:15px">' . $row_user['first_name'] . ' ' . $row_user['last_name'] . '</td>
                //                 <td style="text-align:left; font-size:15px">' . $row_user['location'] . '</td>
                //                 <td style="text-align:left; font-weight:bold; font-size:18px"><b>' . number_format($total, 0, ',', ',') . ' Rwf </b></td>
                //             </tr>
                //         </table>
                //         <p>Thank you for using Selleasep</p>
                //         </center>
                //     ';
                //     $mail->AltBody = 'Shift closed by ' . $row_user['first_name'] . ' ' . $row_user['last_name'] . ' at ' . $row_user['location'] . ' Closing amount: ' . $total . ' Rwf.';

                //     $mail->send();
                //     echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                // }

                // Update logout time
                $logout_time = date("Y-m-d H:i:s");
                $sqllog = "UPDATE loginfo SET logout_time = '$logout_time' WHERE login_time = '$login_time'";

                if ($conn->query($sqllog) === TRUE) {
                    session_unset();
                    header('Location: login');
                } else {
                    echo "Error: " . $sqllog . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sqlshift . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No active shift found.<br>";
    }
}
?>
