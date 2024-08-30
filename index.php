<?php
include('getuser.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/Dashboard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <div >   
                    <h3 class="text-dark mb-0" style="font-weight: 900;font-size: 18px; text-transform: uppercase;">Dashboard Your Sales Point management </h3>
                        
                        <div>
                        <span id="salespointlocation" class="badge bg-success rounded" style="color:white;font-weight:bold;font-size:15px; text-transform: uppercase; margin-bottom: 10px;"></span>
                        <span class="badge bg-danger rounded" style="color:white;font-weight:bold;font-size:15px; text-transform: uppercase; margin-bottom: 10px;" id="shiftnames"></span>
                        </div>
                    </div> 

                        <!-- <button class="btn btn-success" style="font-weight: bold;color:white;" type="button" id="activateShiftButton"><i class="fas fa-play"></i>&nbsp;Activate Shift</button> -->
                        <button class="btn btn-warning" style="font-weight: bold;color:black; text-transform: uppercase;" id="closeShiftButton" type="button" data-bs-target="#add_customer_modal" data-bs-toggle="modal"><i class="fas fa-times close-icon"></i>&nbsp;Cashier Shift Closing</button>
                       <a id="allshift_report" href="allshift_report"> <button class="btn btn-primary" style="font-weight: bold;color:white; text-transform: uppercase;" role="button" ><i class="fas fa-file-alt"></i>&nbsp;Shift Report</button></a>
                    </div>
                    

                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                    
                    <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2" id="getdaily">
                                            
                                        </div>
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                    </div>


                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily1">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2" id="getWeekly">
                                            
                                        </div>
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily2">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2" id="getYearly">
                                            
                                        </div>
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily5">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1"><span style="min-width: 43px;">Current Shift by: <span id="cashiernamepoint">...</span></span></div>
                                        
                                        <div class="col me-2" style="font-weight: bold" id="getcurrentcash">
                                            <p id="expectedCash"></p>
                                        </div>

                                       
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily7">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1"><span style="min-width: 43px;">Greetings</div>
                                        
                                        <div class="col me-2" style="font-weight: bold">
                                            <p>Welcome <span id="my_names"></span></p>
                                        </div>

                                        <div class="col-auto"><i class="fas fa-hand-peace fa-2x text-gray-300"></i></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily3">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                    <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="min-width: 43px;">Total Selling Stock</span></div>
                                        <div class="col me-2" style="font-weight: bold" id="getSellStock">
                                            
                                        </div>
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3 mb-4" style="width: 300px;" id="cardgetdaily4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                    <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="min-width: 43px;">Total Benefit Stock</span></div>
                                        <div class="col me-2" style="font-weight: bold" id="getBenefitStock">
                                            
                                        </div>
                                        <div class="col-auto"><i class="fas fa-cash-register fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>




                    <!-- <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Earnings Overview</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas data-bss-chart="{&quot;type&quot;:&quot;line&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;Earnings&quot;,&quot;fill&quot;:true,&quot;data&quot;:[&quot;0&quot;,&quot;10000&quot;,&quot;5000&quot;,&quot;15000&quot;,&quot;10000&quot;,&quot;20000&quot;,&quot;15000&quot;,&quot;25000&quot;],&quot;backgroundColor&quot;:&quot;rgba(78, 115, 223, 0.05)&quot;,&quot;borderColor&quot;:&quot;rgba(78, 115, 223, 1)&quot;}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;],&quot;drawOnChartArea&quot;:false},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}],&quot;yAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;]},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}]}}}"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Most Benefit Sales Products</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas data-bss-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Direct&quot;,&quot;Social&quot;,&quot;Referral&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;50&quot;,&quot;30&quot;,&quot;15&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}}"></canvas></div>
                                    <div class="text-center small mt-4" id="getMostBenefit">
                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary fw-bold m-0">Product In Alert Situation</h6>
                                </div>
                                <div class="card-body" id="inventoryAlert">
                                    
                                </div>
                            </div>
                        

                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-primary shadow">
                                        <div class="card-body">
                                            <p class="m-0">Primary</p>
                                            <p class="text-white-50 small m-0">#4e73df</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-success shadow">
                                        <div class="card-body">
                                            <p class="m-0">Success</p>
                                            <p class="text-white-50 small m-0">#1cc88a</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-info shadow">
                                        <div class="card-body">
                                            <p class="m-0">Info</p>
                                            <p class="text-white-50 small m-0">#36b9cc</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-warning shadow">
                                        <div class="card-body">
                                            <p class="m-0">Warning</p>
                                            <p class="text-white-50 small m-0">#f6c23e</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-danger shadow">
                                        <div class="card-body">
                                            <p class="m-0">Danger</p>
                                            <p class="text-white-50 small m-0">#e74a3b</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-secondary shadow">
                                        <div class="card-body">
                                            <p class="m-0">Secondary</p>
                                            <p class="text-white-50 small m-0">#858796</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->



<div class="row" id="cardgetdailyFinal">
                                
 <div class="card shadow p-2">
 <div  style="display: flex;flex-direction: row; justify-content:space-around; gap: 5px; flex-wrap: wrap;">
        <div>
        <div class="card-body">
        <p class="mb-2" style="text-transform: uppercase; font-weight: bold;">Most Benefit Sales Products today</p>
          <table id="employeeTable" class="display nowrap" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                <th>No</th>
                <th>Product</th>
                <th>Quantity</th>
                </tr>
            </thead>
        </table>  
        </div>
     
        </div>

        <div>
        <div class="card-body">
        <p class="mb-2" style="text-transform: uppercase; font-weight: bold;">Most Risk Sales Products today</p>
          <table id="employeeTables" class="display nowrap" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Risk 100%</th>
                </tr>
            </thead>
        </table>  
        </div>
        </div>
    </div>
    </div>
    </div>
    
        



    <script>
    $(document).ready(function() {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1;
        const date = currentDate.getDate();
        const formattedDate = `${year}-${month.toString().padStart(2, "0")}-${date.toString().padStart(2, "0")}`;

        // Retrieve values from localStorage
        var sales_point_id = localStorage.getItem("SptID");

        var table = $('#employeeTable').DataTable({
            "ajax": `functions/sales/mostbenefitproductday.php?date=${formattedDate}&spt=${sales_point_id}`,
            "columns": [
                { "data": "num" },
                { "data": "Product_name",
                 "render": function(data, type, row) {
                    return `<p style="font-weight: bold; text-transform: uppercase;">${data}</p>`;
                 }
                 },
                { "data": "Quantity" },
                
                
                
            ],
            "initComplete": function(settings, json) {
                var jobTitles = [];
                json.data.forEach(function(employee) {
                    if (!jobTitles.includes(employee.sales_point)) {
                        jobTitles.push(employee.sales_point);
                    }
                });
                jobTitles.sort();
                jobTitles.forEach(function(title) {
                    $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
                });
            }
        });



        var table_of_two = $('#employeeTables').DataTable({
            "ajax": `functions/inventory/getAlertproduct.php?spt=${sales_point_id}`,
            "columns": [
                { "data": "num" },
                { "data": "name",
                 "render": function(data, type, row) {
                    return `<p style="font-weight: bold; text-transform: uppercase;">${data}</p>`;
                 }
                 },
                { "data": "quantity" },
                { "data": "STATUS",
                 "render": function(data, type, row) {
                    if(row.STATUS == 'Danger-Risk'){
                        return `<span class="badge text-bg-danger text-white"  style="font-weight: bold; text-transform: uppercase; color:white; width: 100%; padding: 5px;">${row.STATUS}</span>`;
                    }
                    else if(row.STATUS == 'High-Risk'){
                        return `<span class="badge text-bg-warning"  style="font-weight: bold; text-transform: uppercase; color:white; width: 100%; padding: 5px;">${row.STATUS}</span>`;
                    }
                    else if(row.STATUS == 'Medium-Risk'){
                        return `<span class="badge text-bg-info text-white"  style="font-weight: bold; text-transform: uppercase; color:white;" width: 100%; padding: 5px;">${row.STATUS}</span>`;
                    }
                    else if(row.STATUS == 'Low-Risk'){
                        return `<span class="badge text-bg-primary text-white"  style="font-weight: bold; text-transform: uppercase; color:white; width: 100%; padding: 5px;">${row.STATUS}</span>`;
                    }
                    else{
                        return `<span class="badge text-bg-success text-white"  style="font-weight: bold; text-transform: uppercase; color:white; width: 100%; padding: 5px;">${row.STATUS}</span>`;
                    }
                    
                    
                 }
                }
            ],
            "initComplete": function(settings, json) {
                var jobTitles = [];
                json.data.forEach(function(employee) {
                    if (!jobTitles.includes(employee.sales_point)) {
                        jobTitles.push(employee.sales_point);
                    }
                });
                jobTitles.sort();
                jobTitles.forEach(function(title) {
                    $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
                });
            }
        });

       
    });
    </script>
                
                </div>
                <br/>
                <?php   
                $user_id=$_SESSION['user_id'];
                include('functions/connection.php');
                $query=mysqli_query($conn,"SELECT * FROM users WHERE id='{$user_id}'");
                $row=mysqli_fetch_array($query);
                $names= $row['userType'];

                if($names=='BOSS'){
                    return false;
                }
                else {
                    include('slider.php');
                }
                ?>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                <?php include('copyright.php'); ?>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">CASHIER SHIFT CLOSING BY <span id="cashiername" style="color:blue;font-weight:bold;"></span></p><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Close This Shift.</p>
                    <p>If you close this shift you will not be able to reopen it</p>
                    <p>If Yes press Close Shift else press Cancel</p>
                    <!-- <form>
                        <label class="form-label" style="margin-top: 12px;">Cash in hand</label>
                        <input class="form-control" type="number" default="0" id="cashinhand">
                        <label class="form-label" style="margin-top: 12px;">Mobile money</label>
                        <input class="form-control" type="number" default="0" id="mobilemoney">
                        <label class="form-label" style="margin-top: 12px;">Bank Card</label>
                        <input class="form-control" type="number" default="0" id="bank">
                        
                        </form> -->
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-warning" type="button" data-bs-target="#closingmodal" data-bs-toggle="modal">Close Shift</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="closingmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">CLOSING MY SHIFT DAY...<span id="cashiername" style="color:blue;font-weight:bold;"></span></p><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <center><h2 id="shift_message">CASHIER SHIFT CLOSING APPROVAL<span id="cashiername" style="color:blue;font-weight:bold;"></span></h2>
                <p id="no_shifts">If Yes press YES else NO to cancel</p></center>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal" id="no_shift">NO</button><button class="btn btn-success" type="button" id="closingcase"><span  style="color:white;font-weight:bold;">YES</span></button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="successmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Success!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black; font-size:20px; font-weight:bold;" > You are successfully Close Your Shift Case.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">ok</button></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="errormodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">Error!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;" > Something went wrong Check well.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="activatemodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">Ooopss!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;" > Your Shift is not yet closed, you can not activate another.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>




    
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>


</body>

</html>