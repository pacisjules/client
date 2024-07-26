<?php
session_start();
require_once '../connection.php';
//require '../systemhistory.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the form data
    $username = $_POST['UName'];
    $password = $_POST['UPass'];
    
    //SetTime
    $date_time = date('Y-m-d H:i:s');
    $date_time_log = date('Y-m-d');
    
   

    
    // Check if the username or email exists in the database
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    // If there is a match, check the password
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        
        
        
        $ids=$row['id'];
        $id = $row['id'];
       $comp =  $row['company_ID'];
       $sal =  $row['salepoint_id'];
       $usercategory =  $row['user_category'];
       $usershift =  $row['shift_id'];
       $realshift = 0;
       if( $usershift>0){
        $realshift = $usershift;
       }else{
        $realshift = 0;
       }
        
        header('HTTP/1.1 201 Login Successful');
        //Get others users information
        $sqlGet = "SELECT * FROM employee WHERE user_id=$ids";
        $resultInfos = $conn->query($sqlGet);
        $rowInfos = $resultInfos->fetch_assoc();

        $sqlcomp = "SELECT * FROM company_information WHERE company_id=$comp";
        $resultComp = $conn->query($sqlcomp);
        $rowComp = $resultComp->fetch_assoc();


        $sqlcompany = "SELECT * FROM companies WHERE id=$comp";
        $resultCompany = $conn->query($sqlcompany);
        $rowCompany = $resultCompany->fetch_assoc();

        $sqlsa = "SELECT * FROM salespoint WHERE sales_point_id=$sal";
        $resultsa = $conn->query($sqlsa);
        $rowsa = $resultsa->fetch_assoc();

        $sqlscount = "SELECT COUNT(*) AS count FROM loginfo WHERE login_time LIKE '%$date_time_log%' and user_id=$id ";
        $resultscount = $conn->query($sqlscount);
        $logincounts = $resultscount->fetch_assoc();
        

        $sqlscountshift = "SELECT COUNT(*) AS countshift FROM shift_records WHERE user_id=$id AND shift_status=1";
        $resultscountshift = $conn->query($sqlscountshift);
        $shiftcounts = $resultscountshift->fetch_assoc();

        $sptcountshift = "SELECT COUNT(*) AS countsptshift FROM shift_records WHERE user_id=$id AND spt=$sal AND shift_status=1";
        $resultsptcountshift = $conn->query($sptcountshift);
        $sptshiftcounts = $resultsptcountshift->fetch_assoc();


        $sqlsshiftInfo = "
        SELECT
      
        st.names as shift_name,
        st.shiftstart,
        st.shiftend,
        CASE 
            WHEN TIME(st.shiftstart) >= '06:00:00' AND TIME(st.shiftstart) < '18:00:00' THEN 'Day'
            ELSE 'Night'
        END AS shift_type
from shift st, users us where us.shift_id=st.id AND us.id = $id
        ";

        $resultsshiftInfo = $conn->query($sqlsshiftInfo);
        $shiftshiftInfo = $resultsshiftInfo->fetch_assoc();

        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        
        $sqlscountshiftcurrent = "
         SELECT
    us.username,
    us.company_name,
    st.names AS shift_name,
    st.shiftstart,
    st.shiftend,
    COALESCE((SELECT shift_status FROM shift_records WHERE user_id = us.id), 3) AS shift_status,
    CASE 
        WHEN TIME(st.shiftstart) >= '06:00:00' AND TIME(st.shiftstart) < '18:00:00' THEN 'Day'
        ELSE 'Night'
    END AS shift_type,
    SUM(
        CASE
            WHEN TIME(st.shiftstart) >= '06:00:00' AND TIME(st.shiftstart) < '18:00:00' THEN
                CASE
                    WHEN DATE(src.start) = CURRENT_DATE THEN 1
                    ELSE 0
                END
            ELSE
                CASE
                    WHEN DATE(src.start) = CURRENT_DATE - INTERVAL 1 DAY THEN 1
                    ELSE 0
                END
        END
    ) AS countshift_current
FROM
    users us
JOIN
    shift st ON us.shift_id = st.id
LEFT JOIN
    shift_records src ON src.start > st.shiftstart AND src.end != '0000-00-00 00:00:00'
WHERE
    us.id = $id
GROUP BY
    us.username, us.company_name, st.names, st.shiftstart, st.shiftend, shift_type;


        ";

        $resultscountshiftcurrent = $conn->query($sqlscountshiftcurrent);
        $shiftcountscurrent = $resultscountshiftcurrent->fetch_assoc();


        $sqlog = "INSERT INTO `loginfo`(`user_id`,`login_time`, `sales_point_id`) 
        VALUES ('$id','$date_time','$sal') ";
        $resultlog = $conn->query($sqlog);

        //Set History
        //AddHistory($row['id'],"User Login",$rowInfos['sales_point_id'] );

        $taken_user_id=$row['id'];
        
        // SQL query
        $sql_in_shift = "
        SELECT record_id
        FROM shift_records
        WHERE user_id = $taken_user_id
        AND `end` = '0000-00-00 00:00:00'
        AND shift_status = 1
        ORDER BY record_id DESC
        LIMIT 1
        ";

        // Execute query
        $result_in_shift = $conn->query($sql_in_shift);

        if ($result_in_shift->num_rows > 0) {

        // Fetch the result row
        $row_in_shift = $result_in_shift->fetch_assoc();
        // Echo the record_id
        $_SESSION['shift_record_id'] = $row_in_shift['record_id'];
        } 


        if (isset($shiftcountscurrent['countshift_current'])&& !is_null($shiftcountscurrent['countshift_current'])) {
            $data = array(
                'id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email'],
                'company_name' => $row['company_name'],
                'company_ID'=>$row['company_ID'],
                'salepoint_id'=>$rowInfos['sales_point_id'],
                'phone'=>$rowInfos['phone'],
                'names'=>$rowInfos['first_name']." ".$rowInfos['last_name'],
                'salepoint_id'=>$rowInfos['sales_point_id'],
                'userType'=>$row['userType'],
                'user_category'=>$usercategory, 
                'usershift'=> $realshift,
                'Logged_on'=>$date_time,
                'countlogins'=>$logincounts['count'],
                'shiftcounts'=>$shiftcounts['countshift'],
                'sptshift'=>$sptshiftcounts['countsptshift'],
                'company_logo'=>$rowComp['logo'],
                'company_color'=>$rowComp['color'],
                'spt_name'=>$rowsa['location'],
                'phonemana'=>$rowsa['phone_number'],
                'phoneboss'=>$rowsa['report_to_phone'],
                'zone'=>$rowCompany['timezone_name'],
                
                'shiftstart'=>$shiftcountscurrent['shiftstart'],
                'shiftend'=>$shiftcountscurrent['shiftend'],
                'count_shifts'=>$shiftcountscurrent['countshift_current'],
                'shift_status'=>$shiftcountscurrent['shift_status'],
                'shift_name'=>$shiftcountscurrent['shift_name'],
                'shift_type'=>$shiftcountscurrent['shift_type'],
    
                'Message'=> 'Account passed'
            );
        }else{
            if($realshift == 0){
                $data = array(
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'company_name' => $row['company_name'],
                    'company_ID'=>$row['company_ID'],
                    'salepoint_id'=>$rowInfos['sales_point_id'],
                    'phone'=>$rowInfos['phone'],
                    'names'=>$rowInfos['first_name']." ".$rowInfos['last_name'],
                    'salepoint_id'=>$rowInfos['sales_point_id'],
                    'userType'=>$row['userType'],
                    'user_category'=>$usercategory, 
                    'usershift'=> $realshift,
                    'Logged_on'=>$date_time,
                    'countlogins'=>$logincounts['count'],
                    'shiftcounts'=>$shiftcounts['countshift'],
                    'company_logo'=>$rowComp['logo'],
                    'company_color'=>$rowComp['color'],
                    'spt_name'=>$rowsa['location'],
                    'phonemana'=>$rowsa['phone_number'],
                    'phoneboss'=>$rowsa['report_to_phone'],
                    'zone'=>$rowCompany['timezone_name'],

                    'Message'=> 'Account passed'
                );
            }else{
                $data = array(
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'company_name' => $row['company_name'],
                    'company_ID'=>$row['company_ID'],
                    'salepoint_id'=>$rowInfos['sales_point_id'],
                    'phone'=>$rowInfos['phone'],
                    'names'=>$rowInfos['first_name']." ".$rowInfos['last_name'],
                    'salepoint_id'=>$rowInfos['sales_point_id'],
                    'userType'=>$row['userType'],
                    'user_category'=>$usercategory, 
                    'usershift'=> $realshift,
                    'Logged_on'=>$date_time,
                    'countlogins'=>$logincounts['count'],
                    'shiftcounts'=>$shiftcounts['countshift'],
                    'sptshift'=>$sptshiftcounts['countsptshift'],
                    'company_logo'=>$rowComp['logo'],
                    'company_color'=>$rowComp['color'],
                    'spt_name'=>$rowsa['location'],
                    'phonemana'=>$rowsa['phone_number'],
                    'phoneboss'=>$rowsa['report_to_phone'],
                    'zone'=>$rowCompany['timezone_name'],
    
                    'shiftstart'=>$shiftshiftInfo['shiftstart'],
                    'shiftend'=>$shiftshiftInfo['shiftend'],
                    'shift_name'=>$shiftshiftInfo['shift_name'],
                    'shift_type'=>$shiftshiftInfo['shift_type'],
    
                    'Message'=> 'Account passed'
                );
            }
            
            
        }
        
        
        
        $json = json_encode($data);
        
        echo $json;
        
        $_SESSION['user_id'] = $id;
        $_SESSION['Logged_on'] = $date_time;
        $_SESSION['countlogins'] = $logincounts['count'];
        $_SESSION['mysalepoint'] = $rowInfos['sales_point_id'];
        $_SESSION['company_ID'] = $row['company_ID'];
        
        
        //exit();
    } else {

        // If the password is incorrect, show an error message
        header('HTTP/1.1 500 Internal Server Error');
        echo "Invalid password.";
    }
    } else {

    // If the username or email doesn't exist, show an error message
    header('HTTP/1.1 500 Internal Server Error');
    echo "User not found.";
    }
}

// Close the database connection
$conn->close();
?>