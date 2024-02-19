<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Service Request - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <!-- Add these links to include Select2 library -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <script src="js/request.js"></script>
    

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <?php include('reportRequest.php'); ?>
                    
                    
                    
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center" id="btnrequestType">
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>


                            
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" id="searchDebt"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th><strong>Customer Name</strong></th>
                                            <td><strong>Phone</strong></td>
                                            <th><strong>Car Name</strong></th>
                                            <th><strong>Plaque</strong></th>
                                            <th><strong>Type</strong></th>
                                            <th><strong>Service</strong></th>
                                            <th><strong>Status</strong></th>
                                            <th><strong>Date</strong></th>
                                            <th><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody id="request_table">
                                        
                                    </tbody>
                                    <tfoot id="totalam">
                                        
                                    </tfoot>
                                </table>
                                <table class="table my-0" id="excelTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excel_table">
                                       
                                    </tbody>
                                </table>
                                <table class="table my-0" id="excelYestTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelyest_table">
                                       
                                    </tbody>
                                </table>
                                <table class="table my-0" id="excelPickTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelpick_table">
                                       
                                    </tbody>
                                </table>
                                 <table class="table my-0" id="excelWeekTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelweek_table">
                                       
                                    </tbody>
                                </table>
                                
                                <table class="table my-0" id="excelFromToTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelfromto_table">
                                       
                                    </tbody>
                                </table>
                                
                                 <table class="table my-0" id="excelMonthlyTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelmonth_table">
                                       
                                    </tbody>
                                </table>
                                
                                 <table class="table my-0" id="excelYearlyTable"  style="display: none;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 14px;">N/O</th>
                                            <th style="font-size: 14px;">Customer Name</th>
                                            <th style="font-size: 14px;">Phone</th>
                                            <th style="font-size: 14px;">Car Name</th>
                                            <th style="font-size: 14px;">Plaque</th>
                                            <th style="font-size: 14px;">Car Type</th>
                                            <th style="font-size: 14px;">Service</th>
                                            <th style="font-size: 14px; text-align:center">Status</th>
                                            <th style="font-size: 14px;">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="excelyear_table">
                                       
                                    </tbody>
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
   
   <div class="modal fade" role="dialog" tabindex="-1" id="add_newdebt_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Customer Names</label>
                         <select class="form-control" id="CustomerSelect" style="width: 100%;">
                           
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Car Name</label>
                        <input class="form-control" type="text" id="carname">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Plate Name</label>
                        <input class="form-control" type="text" id="plate">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Car Type</label>
                        <select class="form-control" id="cartypeSelect" style="width: 100%;">
                           <option value="" disabled selected>Select Service</option>  
                           <option value="Automatic">Automatic</option>
                           <option value="Manuel">Manuel</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">services Needed</label>
                        <select class="form-control" id="serviceSelect" style="width: 100%;">
                           <option value="" disabled selected>Select Service</option> 
                           <option value="Oil Changing">Oil Changing</option>
                           <option value="tire replacement">Tire replacement</option>
                        </select>
                    </div>
                    
                </form>
            </div>
             <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="InsertRequest">Save</button></div>
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
                    <p style="color:black;" > You are successfully Done ittt.!!</p>
                    
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
                    <p style="color:black;" > Something went wrong in paying debts in Installments.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="edit_product_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Product.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="delete-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove This Inventory</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete the Customer <span id="delnames"></span> </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeCustomer"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove Customer</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal_inventory">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit Customer</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <form>
                        <label class="form-label" style="margin-top: 10px;">Full Names</label>
                        <input class="form-control" type="text" id="editnames"> <!-- Use type="text" for text input -->
                        <label class="form-label" style="margin-top: 10px;">Phone Number</label>
                        <input class="form-control" type="text" id="editphone"> <!-- Use type="text" for text input -->
                        <label class="form-label" style="margin-top: 10px;">Address</label>
                        <input class="form-control" type="text" id="editaddress"> <!-- Use type="text" for text input -->
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditCustomer">Edit Customer</button></div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>