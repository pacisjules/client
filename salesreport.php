<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales Report - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <script src="js/sales.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
       
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content" style="background-color:red;">
                
                
                
                <!--<div class="container-fluid" style="width:100%; margin-top:50px; margin-bottom:50px;">-->
                    
                   
                    
                    <div class="card shadow">
                        
                    <div class="card-header py-3 d-flex justify-content-between align-items-center"  id="btnsalesType">
<!--                        <p class="text-primary m-0 fw-bold" style="font-size: 13px;"><span id="message"></span> Sales Records</p>-->
                
<!--                <div>-->
<!--                  <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-dollar-sign"></i>-->

<!--Paid Sales </button>-->
<!--                <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>-->

<!--Debts Sales </button>-->
<!--                 </div>-->
                
                <!--<div>-->
                <!--<button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white; margin-right:1rem;" onclick="fetchyesterdayMessagesalesReport('<?php echo $date; ?>','<?php echo $comID; ?>','<?php echo $spt; ?>')">-->
                <!--    <i class="fa fa-file-pdf"  style="margin-right:10px;"></i>PDF-->
                <!--</button>-->
                <!--<button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('dataTable', 'FromToSales_data')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Excel </button>-->
                <!--</div>-->
                    </div>

                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-md-6 text-nowrap">-->
                                <!--    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">-->
                                <!--                <option value="10" selected="">10</option>-->
                                <!--                <option value="25">25</option>-->
                                <!--                <option value="50">50</option>-->
                                <!--                <option value="100">100</option>-->
                                <!--            </select>&nbsp;</label></div>-->
                                <!--</div>-->
                                <div>
                                 <h4 style="color:black;">Total Amount: FRW <span id="totalSales"></span></h4>
                                <h4 style="color:black;">Benefit: FRW <span id="benefit"></span></h4>   
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                <table class="table my-0" id="dataTable" >
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
$servername = "localhost";
$username = "u774778522_sell_user_db";
$password = "Ishimuko@123";
$dbname = "u774778522_selleasep_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$date = $_GET['date'];
$comID = $_GET['company'];
$spt = $_GET['spt'];

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

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    
       $totalAmount += $row['total_amount'];
    $totalBenefit += $row['total_benefit'];
    
    echo "<tr>";
    echo "<td>" . $row['Product_Name'] . "</td>";
    echo "<td>" . $row['sales_price'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['total_amount'] . "</td>";
    echo "<td>" . $row['total_benefit'] . "</td>";
    echo "<td style='text-align:center'>" . $row['paid_status'] . "</td>";
    echo "<td>" . $row['created_time'] . "</td>";
    echo "</tr>";
}


mysqli_free_result($result);
mysqli_close($conn);
?>

                                    </tbody>
                                </table>
                                
                               
                        </div>
                    </div>
                <!--</div>-->
            </div>
            
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>

    
 $(document).ready(function () {
     
      var totalAmount = <?php echo $totalAmount; ?>;
        var totalBenefit = <?php echo $totalBenefit; ?>;
        
      
        
      var formattedTotalAmount = totalAmount.toLocaleString();
        var formattedTotalBenefit = totalBenefit.toLocaleString();

        // Update the HTML elements with the formatted values
        $("#totalSales").text(formattedTotalAmount);
        $("#benefit").text(formattedTotalBenefit);
        
     
     
        // Add keyup event listener to the search input
        $("#dataTable_filter input").on("keyup", function () {
            var searchTerm = $(this).val().toLowerCase();

            // Loop through each row in the table and hide/show based on the search term
            $("#dataTable tbody tr").each(function () {
                var text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(searchTerm));
            });
        });
    });
    
    
</script>
</body>

</html>