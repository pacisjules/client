<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Export Excel - SellEASEP</title>
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
</head>

<body>
    <center>
        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
            <table class="table my-0" id="salesTable" border="2">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Sales Price</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Total Benefit</th>
                        <th>Paid Status</th>
                        <th>Created Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    require_once './functions/connection.php';
                    
                    // Add error reporting for debugging
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    // Get the date, company ID, and sales point ID from the query parameters
                    $date = $_GET['date'] ?? '';
                    $comID = $_GET['company'] ?? '';
                    $spt = $_GET['spt'] ?? '';

                    // Check if required parameters are set
                    if (empty($date) || empty($comID) || empty($spt)) {
                        die('Invalid parameters.');
                    }

                    // SQL query to fetch daily sales records
                    $sql = "
                        SELECT DISTINCT
                            SL.sales_id,
                            SL.sess_id,
                            PD.name AS Product_Name,
                            SP.manager_name,
                            SP.phone_number,
                            SP.location,
                            PD.benefit,
                            SL.product_id,
                            SL.quantity,
                            SL.sales_price,
                            SL.total_amount,
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
                            SL.created_time LIKE '$date%'
                            AND SP.company_ID = $comID
                            AND SL.sales_point_id = $spt
                        GROUP BY
                            SL.sales_id
                        ORDER BY
                            SL.created_time DESC";

                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if (!$result) {
                        die('Query failed: ' . $conn->error);
                    }

                    $num = 0;

                    while ($row = $result->fetch_assoc()) {
                        $num += 1;

                        echo '
                            <tr>
                                <td style="font-size: 14px;">' . $num . '. ' . $row['Product_Name'] . '</td>
                                <td style="font-size: 14px;">' . $row['sales_price'] . '</td>
                                <td style="font-size: 14px;">' . $row['quantity'] . '</td>
                                <td style="font-size: 14px;">' . $row['total_amount'] . '</td>
                                <td style="font-size: 14px;">' . $row['benefit'] . '</td>
                                <td style="font-size: 14px;">' . $row['paid_status'] . '</td>
                                <td style="font-size: 14px;">' . $row['created_time'] . '</td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function () {
                // Generate and export the Excel file immediately when the page loads
                exportTableToExcel('salesTable', 'sales_data');
            });

            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename ? filename + '.xls' : 'excel_data.xls';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    // Trigger the function
                    downloadLink.click();
                }
            }
        </script>

        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
        <script src="assets/js/theme.js"></script>
    </center>
</body>

</html>
