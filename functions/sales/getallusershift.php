<?php
// Include the database connection file
require_once '../connection.php';

//Set master path
header('Content-Type: application/json');

$spt = $_GET['spt'];


// Retrieve all users from the database
$sql = "SELECT * FROM close_checkout CC,users US, shift_records SR WHERE CC.spt=$spt AND CC.user_id=US.id AND CC.shiftrecord_id=SR.record_id
       ORDER BY CC.check_id DESC
       LIMIT 10
        ";


$value = "";
$result = mysqli_query($conn, $sql);
$num=0;


// Convert the results to an array of objects
$comp = array();


while ($row = $result->fetch_assoc()) {
    
    
    $sts="";
    $endis="";
    $icon="";

    if($row['shift_status']==1){
        $sts="Active";
        $color="green";
     
    }else{
        $sts="Closed";
        $color="red";
    }

    $num+=1;

    $value .= '
        <tr>
                                            <td style="font-size: 12px;">'.$num.'. ' . $row['username'] . '</td>
                                            <td style="font-size: 12px;">FRW ' . number_format($row['amount']) . '</td>
                                            <td style="font-size: 12px;">FRW ' . number_format($row['cashinhand']) . '</td>
                                            <td style="font-size: 12px;">FRW ' . number_format($row['mobilemoney']) . '</td>
                                            <td style="font-size: 12px;">FRW ' . number_format($row['bank']) . '</td>
                                            <td style="font-size: 12px;">' . $row['start'] . '</td>
                                            <td style="font-size: 12px;">' . $row['end'] . '</td>
                                            <td style="font-size: 14px;color:'.$color.';font-weight:bold;">' . $sts . '</td>
                                            
                                            
        ';
}

// Convert data to JSON
$jsonData = json_encode($value);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Send the JSON response
echo $jsonData;
