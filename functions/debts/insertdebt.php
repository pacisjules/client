<?php
// Include the database connection file
require_once '../connection.php';
require_once '../vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    // Retrieve the POST data
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['qty'];
    $amount_due = $_POST['amount'];
    $amount_paid = $_POST['amount_paid'];
    $due_date = $_POST['due_date'];
    $descriptions = $_POST['descriptions'];
    $sales_point_id = $_POST['sales_point_id'];
    
    // Insert the user data into the database
    $sql = "INSERT INTO debts (customer_id, product_id, amount, amount_paid, due_date, qty, descriptions,sales_point_id, status) 
    VALUES 
    ('$customer_id', '$product_id', '$amount_due','$amount_paid','$due_date','$quantity','$descriptions','$sales_point_id', 1)";

    if ($conn->query($sql) === TRUE) {
      // Return a success message
      header('HTTP/1.1 201 Created');
      echo "Debt created successfully.";


      $sql_query = "SELECT DT.id, DT.amount, DT.amount_paid,sum(DT.amount) as sum_amount, sum(DT.amount_paid) as sum_amount_paid, CT.names, CT.phone, CT.address, SPT.report_to_phone, SPT.report_to_email, SPT.senderid FROM debts DT, customer CT, salespoint SPT WHERE CT.customer_id=DT.customer_id AND SPT.sales_point_id=DT.sales_point_id AND DT.customer_id =? AND DT.status = 1";
      $stmt = $conn->prepare($sql_query);
      $stmt->bind_param("s", $customer_id);
      $stmt->execute();
      $sql_result = $stmt->get_result();
      $amount_row = $sql_result->fetch_assoc();
      $due_money=$amount_row['sum_amount'];
      $paid_money=$amount_row['sum_amount_paid'];
      $balance = $due_money - $paid_money;
      $insert_money = $amount_due - $amount_paid;
      $client_names=$amount_row['names'];
      $message='Mukiliya wacu,  Ideni ryawe ryiyongeyeho '. number_format($insert_money) .' RWF. yose hamwe ni  '. number_format($balance) .' RWF, Murakoze! ';
      $message_toboss=$client_names. ' Ideni rye ryiyongeyeho '. number_format($insert_money) .' RWF. yose hamwe ni '. number_format($balance) .' RWF, Murakoze! ';
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
      // Return an error message if the insert failed
      header('HTTP/1.1 500 Internal Server Error');
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}