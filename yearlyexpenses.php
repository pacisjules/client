<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Yearly Expenses - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/expenses.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid"  >
                <h3 class="text-dark mb-4 fw-bold" >Expenses</h3>
                <div style="display: flex;flex-direction: row; justify-content: space-between;" >
               <div style="flex-direction:row;display: flex; margin-bottom:10px;">     
                    <button  class="btn btn-primary" style="margin-right:10px;" data-bs-target="#expensesmodal" data-bs-toggle="modal">Add Expenses Type</button>
                    <button  class="btn btn-primary" data-bs-target="#addexpensesmodal" data-bs-toggle="modal">Add Expenses</button>
               </div>

<div style="flex-direction:row; margin-bottom:10px;">
<a href="expenses.php" class="btn btn-info ">Daily</a>
        <a href="weeklyexpenses.php" class="btn btn-warning ">Weekly</a>
        <a href="monthlyexpenses.php" class="btn btn-danger ">Monthly</a>
                    </div>
              </div> 
                    <!-- <h3 class="text-dark mb-4 fw-bold" >Expenses</h3>
                    <div style="flex-direction:row;">
                    <button style="background: rgb(0,26,53); color:white;border-radius:5px;  margin-bottom:10px;"><a href="expenses.php" style="background: rgb(0,26,53); color:white; text-decoration:none;"><span>View Daily Expenses<span></a></button>
                    <button style="background: rgb(0,26,53); color:white;border-radius:5px;  margin-left:1.8rem; margin-bottom:10px;"><a href="weeklyexpenses.php" style="background: rgb(0,26,53); color:white; text-decoration:none;"><span>View Weekly Expenses<span></a></button>
                    <button style="background: rgb(0,26,53); color:white;border-radius:5px;  margin-left:1.8rem; margin-bottom:10px;"><a href="monthlyexpenses.php" style="background: rgb(0,26,53); color:white; text-decoration:none;"><span>View Monthly Expenses<span></a></button>
                       
                    </div> -->
                    
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class=" m-0 fw-bold" style="color:rgb(0,26,53);"> Yearly Expenses Records</p>
                            
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                                <option value="10" selected="">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp;</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Expense Type</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="yearexpenses">
                                        
                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Description</strong></td>
                                            <td><strong>Amount</strong></td>
                                            <td><strong>Expense Type</strong></td>
                                            <td><strong>Date</strong></td>
                                            <td><strong>Action</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <?php include('copyright.php'); ?>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>