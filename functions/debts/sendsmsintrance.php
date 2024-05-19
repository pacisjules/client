
<?php
require_once '../connection.php';
require_once '../debtssystemhistory.php';
require_once '../vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $amount = $_POST["amount"];
    $status = 1;
    $descriptions = $_POST['descriptions'];
    $spt = $_POST['spt'];
    $user_id = $_POST['user_id'];
    
   
    
    // Retrieve the POST data
    $qty = $POST['qty'];
    $amount = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $sales_point_id = $_POST['sales_point_id'];
    
    // Check if the entered amount is greater than the total debt
    $sql_total_debt = "SELECT SUM(amount - amount_paid) as total_debt FROM debts WHERE customer_id = $id AND status = 1";
    $total_debt_result = $conn->query($sql_total_debt);
    $total_debt_row = $total_debt_result->fetch_assoc();
    $total_debt = $total_debt_row['total_debt'];
    $balance = $total_debt - $amount;
    
$sql_query_sms = "SELECT DT.id, DT.amount, DT.amount_paid, DT.customer_id,CT.customer_id,CT.names, CT.phone, CT.address, SPT.report_to_phone, SPT.report_to_email, SPT.senderid FROM debts DT, customer CT, salespoint SPT WHERE CT.customer_id=DT.customer_id AND SPT.sales_point_id=DT.sales_point_id AND DT.customer_id =?";
    $stmt = $conn->prepare($sql_query_sms);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $sql_result_sms = $stmt->get_result();   
    
// Add a new entry to the debt history
if ($sql_result_sms->num_rows > 0) {
$amount_row = $sql_result_sms->fetch_assoc();
$payed_money=$_POST["amount"];
$client_names=$amount_row['names'];
$message='Mukiliya wacu, murakoze kwishyura ideni rya '. number_format($payed_money) .' RWF. Hasigaye ' . number_format($balance) . ' RWF, Murakoze!';
$message_toboss=$client_names. ' yishyuye ideni rya '. number_format($payed_money) .' RWF. Hasigaye ' . number_format($balance) . ' RWF, Murakoze!';
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
        }
    }
?>