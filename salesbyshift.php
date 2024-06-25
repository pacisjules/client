<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales Shift Report - SellEASEP</title>
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

    <script src="js/salesshift.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                
                
                <div class="container-fluid">
                <button  type="button" id="backtostock" style="font-size: 15px;font-weight: bold; background-color:#040536; border-radius:10px; color:white; margin-bottom:10px;"><i class="fas fa-arrow-left"></i>
                &nbsp;Back</button>
                    
                   <?php include('reportshift.php'); ?>
                    
                    <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center"  id="btnsalesType">
    
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
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Status</th>
                                            <th style="font-size: 14px; text-align:center">Store Manager</th>
                                            <th style="font-size: 14px; text-align:center">Manager</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            <th style="font-size: 14px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sells_table">
                                       
                                    </tbody>
                                    <tfoot id="totalam">
                                        
                                    </tfoot>
                                </table>
                                
                                <table class="table my-0" id="excelTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_table">
                                       
                                    </tbody>
                                    <tfoot id="totalexcel">
                                        
                                    </tfoot>
                                </table>
                                <table class="table my-0" id="excelWeekTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_week">
                                       
                                    </tbody>
                                    <tfoot id="totalweekexcel">
                                        
                                    </tfoot>
                                </table>
                                
                                 <table class="table my-0" id="excelMonthTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_month">
                                       
                                    </tbody>
                                    <tfoot id="totalmonthexcel">
                                        
                                    </tfoot>
                                </table>
                                
                                 <table class="table my-0" id="excelYearTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_year">
                                       
                                    </tbody>
                                    <tfoot id="totalyearexcel">
                                        
                                    </tfoot>
                                </table>
                                
                                <table class="table my-0" id="excelYesterdayTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_yesterday">
                                       
                                    </tbody>
                                    <tfoot id="totalyesterdayexcel">
                                        
                                    </tfoot>
                                </table>
                                
                                
                                 <table class="table my-0" id="excelPickedTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_picked">
                                       
                                    </tbody>
                                    <tfoot id="totalpickexcel">
                                        
                                    </tfoot>
                                </table>
                                
                                <table class="table my-0" id="excelfromtoTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Name</th>
                                            <th style="font-size: 14px;">Price</th>
                                            <th style="font-size: 14px;">Quantity</th>
                                            <th style="font-size: 14px;">Total amount</th>
                                            <th style="font-size: 14px;">Benefit</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Sold time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_fromto">
                                       
                                    </tbody>
                                    <tfoot id="totalfromtoexcel">
                                        
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
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>


    <!-- Modal for selecting the month -->

    <div class="modal fade" role="dialog" tabindex="-1" id="sale_product_now">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Product.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="user_report_now">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">List of users</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <table class="table my-0" id="excelPickedTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">User Name</th>
                                            <th style="font-size: 14px;">User Type</th>
                                            <th style="font-size: 14px;">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="user_info">
                                       
                                    </tbody>
                                </table>
                </div>
                
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="user_report_nowyest">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">List of users</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <table class="table my-0" id="excelPickedTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">User Name</th>
                                            <th style="font-size: 14px;">User Type</th>
                                            <th style="font-size: 14px;">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="user_infoyest">
                                       
                                    </tbody>
                                </table>
                </div>
                
            </div>
        </div>
    </div>


    
    <div class="modal fade" role="dialog" tabindex="-1" id="edit_sales_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This sale</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit sale.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Quantity</label><input class="form-control" type="text" id="editquantity"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="editBtnSales">Edit</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="delete_sales_modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this Sale??</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="deleteBtnSales"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="disable-product">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Categorize Sale Pay</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apply if this sale paid.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button">Not Paid</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="approvebtn">Approve</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmodalweek">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="approvebtnweek">Approve</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmodalyest">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="approvebtnyest">Approve</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="alreadyaproved">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">This sales is already approved by Store keeper!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmanagermodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="managerapprovebtn">Approve</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmanagermodalweek">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="managerapprovebtnweek">Approve</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="aprovalmanagermodalyest">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Are you sure to Approve this sales??</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can approve this sales.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="managerapprovebtnyest">Approve</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="alreadyaprovedbymanager">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">This sales is already approved by Manager!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="notallowedmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">You are not allowed to perform this task!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>





    <div class="modal fade" role="dialog" tabindex="-1" id="inventory">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Give Product Inventory</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Before you use product add new inventory</p>
                    <form><label class="form-label" style="margin-top: 10px;">Quantity</label><input class="form-control" type="number"><label class="form-label" style="margin-top: 10px;">Alert Quantity</label><input class="form-control" type="number"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button">Create</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="sell-now">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Sale Now</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here are for sell product now.</p>
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Name:&nbsp;</label><label class="form-label" style="margin-top: 10px;">HP Adapter&nbsp;</label><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price:&nbsp;&nbsp;</label><label class="form-label" style="margin-top: 10px;">25,000</label></form>
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity:&nbsp;</label><input class="form-control" type="number"><label class="form-label" style="margin-top: 10px;">Result information.....</label></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button">Create</button></div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>