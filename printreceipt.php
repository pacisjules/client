<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - SellEASP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/sellPanel.js"></script>

    <script>
        $("#printnowrec").click(function() {
            $("#printnowrec").hide();
            $("#closereceipt").hide();
            // Hide elements with class "hide-on-print" before printing
            var hideElements = document.querySelectorAll('.hide-on-print');
            for (var i = 0; i < hideElements.length; i++) {
                hideElements[i].style.display = 'none';
            }

            // Trigger the print dialog
            window.print();

            // Restore visibility of hidden elements after printing
            for (var i = 0; i < hideElements.length; i++) {
                hideElements[i].style.display = 'block';
            }

            $("#printnowrec").show();
            $("#closereceipt").show();

        });
    </script>


    <style>
        body {
            font-size: 10pt;
        }

        .hover-effect:hover {
            /* Define the styles for the hover state */
            background-color: lightgray;
            color: blue;
        }

        /* CSS to change color when switch is ON */
        #flexSwitchCheckChecked:checked+.form-check-label {
            background-color: red;
            color: white;
            padding: 5;
        }
    </style>

</head>

<body>

    <button id="printnowrec" onclick=" window.print();">Print</button>
    <button id="closereceipt">Close</button>
    <center>
        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
            <table class="table my-0" id="dataTable" border=2>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price(RWF)</th>
                        <th>Qty</th>
                        <th>Total Amount(RWF)</th>
                        <th>Benefit</th>
                        <th>Status</th>
                        <th style="font-size: 11px;">Date</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    require_once './functions/connection.php';
                    //header('Content-Type: application/json');


                    //Get all sales by date
                    $sessValue = $_GET['id'];

                    $sql = "
SELECT DISTINCT
    SL.sales_id,
    PD.name AS Product_Name,
    SP.manager_name,
    SP.phone_number,
    SP.location,
    PD.benefit,
    SL.product_id,
    SL.quantity,
    SL.sales_price,
    SL.total_amount,
    SUM(SL.total_amount) as total,
    SL.total_benefit,
    SL.paid_status,
    SL.created_time,
    SL.sales_type,
    INV.alert_quantity,
    INV.quantity AS remain_stock
FROM
    sales SL
JOIN products PD ON
    SL.product_id = PD.id
JOIN salespoint SP ON
    SL.sales_point_id = SP.sales_point_id
JOIN inventory INV ON
    SL.product_id = INV.product_id
WHERE
    SL.sess_id = '$sessValue'
GROUP BY
    SL.sales_id
ORDER BY
    SL.created_time
DESC
 ";


                    $result = $conn->query($sql);


                    // Convert the results to an array of objects
                    $comp = array();
                    $value = "";
                    $result = mysqli_query($conn, $sql);


                    $num = 0;
                    while ($row = $result->fetch_assoc()) {
                        $myid = $row['sales_id'];
                        $num += 1;

                        $created_time = new DateTime($row['created_time']);
                        $sell_time = $created_time->format('Y-m-d H:i:s');


                        $sts = "";
                        $endis = "";
                        $icon = "";
                        $msg = "";

                        if ($row['paid_status'] == "Paid") {
                            $sts = "Active";
                            $endis = "btn btn-success";
                            $icon = "fa fa-check-square text-white";
                            $msg = "Paid";
                        } else {
                            $sts = "Not Active";
                            $endis = "btn btn-danger";
                            $icon = "bi bi-x-circle";
                            $msg = "Debt";
                        }


                        $timestamp = $sell_time;
                        $currentTimestamp = time(); // Get the current timestamp

                        // Convert the given timestamp and the current timestamp to UNIX timestamps
                        $timestampUnix = strtotime($timestamp);
                        $currentTimestampUnix = strtotime('now');

                        // Calculate the difference in seconds
                        $diffSeconds = $currentTimestampUnix - $timestampUnix;

                        // Convert seconds to hours and minutes
                        $hours = floor($diffSeconds / 3600);
                        $minutes = floor(($diffSeconds % 3600) / 60);

                        // Build the relative time string
                        if ($hours > 0) {
                            $relativeTime = $hours . ' hour';
                            if ($hours > 1) {
                                $relativeTime .= 's';
                            }
                            if ($minutes > 0) {
                                $relativeTime .= ' ' . $minutes . ' min';
                                if ($minutes > 1) {
                                    $relativeTime .= 's';
                                }
                            }
                            $relativeTime .= ' ago';
                        } elseif ($minutes > 0) {
                            $relativeTime = $minutes . ' min';
                            if ($minutes > 1) {
                                $relativeTime .= 's';
                            }
                            $relativeTime .= ' ago';
                        } else {
                            $relativeTime = 'Just now';
                        }

                        //echo $relativeTime; // Output: "1 hour ago" or "2 hours 30 minutes ago"


                        $dates = $row['created_time'];

                        $timestamp = strtotime($dates);
                        $formattedDate = date("l, F j, Y", $timestamp);

                        $value .= '

        <tr>

        <td style="font-size: 14px;">' . $num . '. ' . $row['Product_Name'] . '</td>
        <td style="font-size: 14px;">' . number_format($row['sales_price']) . '</td>
        <td style="font-size: 14px;">' . $row['quantity'] . '</td>
        <td style="font-size: 14px;">' . number_format($row['total_amount']) . '</td>
        <td style="font-size: 14px;">' . number_format($row['benefit']) . '</td>
        <td style="font-size: 14px;">'.$row['paid_status'].'</td>
        <td style="font-size: 14px;">' . $formattedDate . '</td>
    
        </tr>

        ';
                    }

                    // Convert data to JSON
                    $jsonData = $value;

                    // Set the response header to indicate JSON content
                    //header('Content-Type: application/json');

                    // Send the JSON response
                    echo $jsonData;
                    ?>
                </tbody>
                <tfoot>
                     <?php
                    // Include the database connection file
                    require_once './functions/connection.php';
                    //header('Content-Type: application/json');


                    //Get all sales by date
                    $sessValue = $_GET['id'];

                    $sqlsum = "
SELECT 
SUM(total_amount) as total
FROM sales
WHERE sess_id = '$sessValue';

";


                    $result = $conn->query($sqlsum);


                    // Convert the results to an array of objects
                    $comp = array();
                    $value = "";
                    $result = mysqli_query($conn, $sqlsum);


                    $num = 0;
                    while ($row = $result->fetch_assoc()) {
                        $myid = $row['sales_id'];
                        $num += 1;


                        $values .= '

        <tr>

        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;"></td>
        <td style="font-size: 14px;">Total Amount</td>
        <td style="font-size: 14px;">' . $row['total'] . 'Frw </td>
    
        </tr>

        ';
                    }

                    // Convert data to JSON
                    $jsonData = $values;

                    // Set the response header to indicate JSON content
                    //header('Content-Type: application/json');

                    // Send the JSON response
                    echo $jsonData;
                    ?>
                </tfoot>
            </table>
        </div>
    </center>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>