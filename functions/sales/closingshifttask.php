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


        
           

                    $sqlgetreport = "SELECT DISTINCT
                products.id AS product_id,
                products.name AS product_name,
                (SELECT COALESCE(SUM(purchase.quantity), 0) AS entry FROM purchase WHERE purchase.product_id=products.id  AND purchase.purchase_date >= '$start%' AND purchase.purchase_date <='$end%' AND purchase.spt_id=$spt) AS entry_stock,
                (SELECT COALESCE(SUM(sales.quantity), 0) AS sold FROM sales WHERE sales.product_id=products.id AND sales.created_time >=  '$start%' AND sales.created_time <= '$end%' AND sales.sales_point_id=$spt) AS sold_stock,
                products.price AS unit_price,
                inventory.quantity AS closing_stock,
                sales.created_time
            FROM
                products
            JOIN
                inventory ON products.id = inventory.product_id
            JOIN
                sales ON products.id = sales.product_id
            LEFT JOIN
                purchase ON products.id = purchase.product_id
            WHERE 
                products.sales_point_id=$spt
                
            GROUP BY
                products.id,inventory.product_id, sales.product_id";

            $resultreport = $conn->query($sqlgetreport);

            $data = array();



            while ($row = $resultreport->fetch_assoc()) {
                $openingStock = 0;
                $totalStock = 0;
                $soldStock = $row['sold_stock'];
                $unit_price = $row['unit_price'];
                $totalprice = $unit_price * $soldStock;
                $closing_stock = $row['closing_stock'];
                $entry_stock = $row['entry_stock'];
                $prod_id = $row['product_id'];
                $prod_name = $row['product_name'];
                
                // Calculate opening and total stock
                if ($row['entry_stock'] === 0) {
                    $openingStock = $soldStock + $closing_stock;  
                    $totalStock = $soldStock + $closing_stock;
                } else {
                    $openingStock = ($soldStock + $closing_stock) - $entry_stock; 
                    $totalStock = $openingStock + $entry_stock;
                }

                // Corrected SQL insert query
                $sqlinsert = "INSERT INTO shiftreport (`product_id`, `product_name`, `open`, `entry`, `total`, `sold`, `unit_price`, `total_amount`, `closing`, `spt`, `startshift`, `endshift`,`shiftsession`)
                            VALUES ('$prod_id', '$prod_name', '$openingStock', '$entry_stock', '$totalStock', '$soldStock', '$unit_price', '$totalprice', '$closing_stock', '$spt', '$start', '$end','$shift_id')";
                
                // Execute the insert query
                if ($conn->query($sqlinsert) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sqlinsert . "<br>" . $conn->error;
                }
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
