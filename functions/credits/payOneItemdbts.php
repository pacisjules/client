<?php
// Include the database connection file
require_once '../connection.php';
// require_once '../vendor/autoload.php';
// use GuzzleHttp\Client;
// $client = new Client();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];



    // Retrieve the POST data
    $qty = $_POST['qty'];
    $amount = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $sales_point_id = $_POST['sales_point_id'];
    
    // $sql_query = "SELECT DT.id, DT.amount, DT.amount_paid, DT.customer_id,CT.customer_id,CT.names, CT.phone, CT.address, SPT.report_to_phone, SPT.report_to_email, SPT.senderid FROM debts DT, customer CT, salespoint SPT WHERE CT.customer_id=DT.customer_id AND SPT.sales_point_id=DT.sales_point_id AND DT.id =?";
    // $stmt = $conn->prepare($sql_query);
    // $stmt->bind_param("s", $id);
    // $stmt->execute();
    // $sql_result = $stmt->get_result();
    
    
    
    // Update the debt data into the database
    $sql = "UPDATE credits SET 

    amount='$amount', 
    amount_paid='$amount', 
    status=2,
    sales_point_id='$sales_point_id'

    WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Return a success message
        header('HTTP/1.1 201 Created');
        echo "credit payed successfully.";
    }
        
     else {
        // Return an error message if the insert failed
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    
    
// if ($sql_result->num_rows > 0) {
    
//     while ($amount_row = $sql_result->fetch_assoc()) {
//     $sess_id=$amount_row['customer_id'];
//     $sqltot = "SELECT CST.names as person_names,
//                   SUM(DB.amount) as total_debtcust,
//                   SUM(DB.amount_paid) as total_paidcust
// FROM debts DB, 
//      customer CST 
//      WHERE 
//      DB.customer_id='$sess_id' 
//      AND DB.sales_point_id=$sales_point_id 
//      AND CST.customer_id='$sess_id' 
//      ";
        
// $sumResult = $conn->query($sqltot);
// $sumRow = $sumResult->fetch_assoc();
// $names = $sumRow['person_names'];
// $total_debtcust = $sumRow['total_debtcust'];
// $total_paidcust = $sumRow['total_paidcust'];
// $total_balance = $total_debtcust - $total_paidcust;



// $payed_money=$amount;
// $client_names=$amount_row['names'];
// $message='Mukiliya wacu, murakoze kwishyura ideni rya '. number_format($payed_money) .' RWF. Hasigaye ' . number_format($total_balance) . ' RWF, Murakoze!';
// $message_toboss=$client_names. ' yishyuye ideni rya '. number_format($payed_money) .' RWF. Hasigaye ' . number_format($total_balance) . ' RWF, Murakoze!';
// $phone_number='+25'.$amount_row['phone'];
// $boosphone_number='+25'.$amount_row['report_to_phone'];
// $sender_id=$amount_row['senderid'];
                
// // Send SMS
//             try {
            
//             $response = $client->post('https://api.pindo.io/v1/sms/', [
//                 'headers' => [
//                     'Authorization' => 'Bearer eyJhbGciOiJub25lIn0.eyJpZCI6InVzZXJfMDFISDc2Rkg0VjMzR1hNUjA0OThZNEc0SkoiLCJyZXZva2VkX3Rva2VuX2NvdW50IjowfQ.',
//                     'Content-Type' => 'application/json',
//                 ],
//             'json' => [
//                 'to' => $phone_number,
//                 'text' => $message,
//                 'sender' => $sender_id, 
//             ],
//     ]);
    
//      echo $response->getBody();

//  $response2 = $client->post('https://api.pindo.io/v1/sms/', [
//                 'headers' => [
//                     'Authorization' => 'Bearer eyJhbGciOiJub25lIn0.eyJpZCI6InVzZXJfMDFISDc2Rkg0VjMzR1hNUjA0OThZNEc0SkoiLCJyZXZva2VkX3Rva2VuX2NvdW50IjowfQ.',
//                     'Content-Type' => 'application/json',
//                 ],
//             'json' => [
//                 'to' => $boosphone_number,
//                 'text' => $message_toboss,
//                 'sender' => $sender_id, 
//             ],
//     ]);
    
    
//     echo $response2->getBody();
                
//             } catch (Exception $ex) {
//                 echo $ex->getMessage();
//             }
//         }
// }

}