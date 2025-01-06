<?php
// Include the database connection file
require_once '../connection.php';
require_once '../debtssystemhistory.php';
require_once '../vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sess_id = $_POST["sess_id"];

    // Retrieve the POST data
    $status = $_POST['status'];
    $descriptions = $_POST['descriptions'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];


    // Use prepared statements to prevent SQL injection
    $sql_query = "SELECT DT.id, DT.amount, DT.amount_paid,sum(DT.amount) as sum_amount, sum(DT.amount_paid) as sum_amount_paid, CT.names, CT.phone, CT.address, SPT.report_to_phone, SPT.report_to_email, SPT.senderid FROM debts DT, customer CT, salespoint SPT WHERE CT.customer_id=DT.customer_id AND SPT.sales_point_id=DT.sales_point_id AND DT.customer_id =? AND DT.status = 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("s", $sess_id);
    $stmt->execute();
    $sql_result = $stmt->get_result();

    // Check if there are any results
    if ($sql_result->num_rows > 0) {
            $amount_row = $sql_result->fetch_assoc();
            $current_id = $amount_row['id'];
            $current_amount = $amount_row['amount'];
            $current_amount_paid = $amount_row['amount_paid'];

            $balance = $current_amount - $current_amount_paid;
            $dt_paid = $current_amount_paid + $balance;

            // Update the debt data into the database
            $update_sql = "update debts set  amount_paid=amount, status=3 where customer_id=$sess_id";
            $update_stmt = $conn->query($update_sql);

            if ($update_stmt=== TRUE) {
                // Return a success message
                header('HTTP/1.1 201 Created');
                echo "Debt with ID $current_id paid successfully.";

                  // Update the sales data using the unique sales_id
                  $updateSalesSql = "UPDATE sales SET 
                  paid=total_amount 
                  WHERE customer_id='$sess_id'";

              if ($conn->query($updateSalesSql) === TRUE) {
                  echo "Debt and Sales Updated successfully.";
              } else {
                  header('HTTP/1.1 500 Internal Server Error');
                  echo "Error updating sales: " . $conn->error;
              }

                debtHistory($user_id, $sess_id,"Pay in full", $current_amount,0.00, $spt);
                
                $payed_money=$amount_row['sum_amount'];
                $client_names=$amount_row['names'];
                $message='Mukiliya wacu, murakoze kwishyura ideni rya '. number_format($payed_money) .' RWF. Hasigaye 0 RWF, Murakoze! ';
                $message_toboss=$client_names. ' yishyuye ideni rya '. number_format($payed_money) .' RWF. Hasigaye 0 RWF, Murakoze! ';
                $phone_number='+25'.$amount_row['phone'];
                $boosphone_number='+25'.$amount_row['report_to_phone'];
                $sender_id=$amount_row['senderid'];
                
                
                // Send SMS
            try {
            
            $response = $client->post('https://api.pindo.io/v1/sms/', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJub25lIn0.eyJpZCI6InVzZXJfMDFISDc2Rkg0VjMzR1hNUjA0OThZNEc0SkoiLCJyZXZva2VkX3Rva2VuX2NvdW50IjowfQ.',
                    'Content-Type' => 'application/json',
                ],
            'json' => [
                'to' => $phone_number,
                'text' => $message,
                'sender' => $sender_id, 
            ],
    ]);
    
     echo $response->getBody();

 $response2 = $client->post('https://api.pindo.io/v1/sms/', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJub25lIn0.eyJpZCI6InVzZXJfMDFISDc2Rkg0VjMzR1hNUjA0OThZNEc0SkoiLCJyZXZva2VkX3Rva2VuX2NvdW50IjowfQ.',
                    'Content-Type' => 'application/json',
                ],
            'json' => [
                'to' => $boosphone_number,
                'text' => $message_toboss,
                'sender' => $sender_id, 
            ],
    ]);
    
    
    echo $response2->getBody();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
                
                
                
                
            } else {
                // Return an error message if the update failed
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: " . $update_sql . "<br>" . $conn->error;
            }
        
    } else {
        header('HTTP/1.1 404 Not Found');
        echo "No debts found for the specified customer and status.";
    }

    // Close the statement
    $stmt->close();
    $update_stmt->close();
}
?>
