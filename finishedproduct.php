<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Finished Product Report - Selleasep</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="js/production.js"></script>

    <script>
       function convertAndSetDate() {
    // Get the value of the date input
    var selectedDate = document.getElementById('duedate').value;

    // Check if a valid date is selected
    if (selectedDate) {
        // Convert the selected date to the desired format (YYYY-MM-DD)
        var formattedDate = convertDateFormat(selectedDate);

        // Set the formatted date back to the input field
        document.getElementById('duedate').value = formattedDate;
    }
}
   </script>



</head>


<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Finished Product</h3>
                        <button class="btn btn-primary" type="button" style="font-size: 14px;font-weight: bold; padding: 10px; Text-Transform: uppercase; color: white" data-bs-toggle="modal" data-bs-target="#add_category_modal" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Package Standard</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Finished Product Informations</p>
                            <!-- <button class="btn btn-secondary" style="font-size: 15px; font-weight: bold;" id="generateFinishedStockedRecord">Transfer Report</button> -->
                            <!--<button class="btn btn-success" style="font-size: 15px; font-weight: bold;" id="pickeditButton">Editing Report</button>-->
                            <!--<button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" id="pickdeleteButton">Deleting Report</button>-->
                           
                        </div>
                        
                        <input type="text" id="datepickerTransfer" style="display: none;"> 
                         <input type="text" id="datepickeredit" style="display: none;"> 
                         <input type="text" id="datepickerdelete" style="display: none;"> 
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" id="searchInventory"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 10px;">FINISHED</th>
                                            <th style="font-size: 10px;">EXPECTED</th>
                                            <th style="font-size: 10px;">PRODUCED BY</th>
                                            <th style="font-size: 10px;">PRODUCED</th>
                                            <th style="font-size: 10px;">APPROVED BY</th>
                                            <th style="font-size: 10px;">STATUS</th>
                                            <th style="font-size: 10px;">PRODUCED TIME</th>
                                            <th style="font-size: 10px;">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inve_table">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="font-size: 10px;">EXPECTED</th>
                                            <th style="font-size: 10px;">PRODUCED BY</th>
                                            <th style="font-size: 10px;">PRODUCED</th>
                                            <th style="font-size: 10px;">APPROVED BY</th>
                                            <th style="font-size: 10px;">STATUS</th>
                                            <th style="font-size: 10px;">PRODUCED TIME</th>
                                            <th style="font-size: 10px;">ACTIONS</th>
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
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASP 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="add_product_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Product.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Name</label>
                        <input class="form-control" type="text">
                        
                        <label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="approvemodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:black;">APPROVE OR REJECT THIS PRODUCTION</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#9a75c7;">Here&nbsp;you can approve by adding the real quantity or reject this production by click on reject.</p>
                    <form>
                        <form>
                        <label class="form-label" style="margin-top: 12px;">Real produced quantity</label>
                        <input class="form-control" type="number" id="real_qty">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">CANCEL</button>
                    <button class="btn btn-danger" style="margin-left:6rem;margin-right:5.5rem;" type="button" id="rejectproduction">REJECT</button>
                <button class="btn btn-success" type="button" id="ApproveProduction">APPROVE</button>
            </div>
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
    <div class="modal fade" role="dialog" tabindex="-1" id="rejectedmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">Impossible!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;" > This Production is Rejected.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="alreadytransferred">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">Impossible!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;" >This Production is already transferred.!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="asktorejectmodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">REJECT THIS PRODUCTION</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you want to reject this Production??? </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="rejectcompletly"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Reject Production</button></div>
            </div>
        </div>
    </div>

    TransferAll


    <div class="modal fade" role="dialog" tabindex="-1" id="TransferAll">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">TRANSFER ALL FINISHED PRODUCT</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here you can transfer in stock quantity which is less or equal of the produced product</p>
                    <form class="row">
                    
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Select Store</label>
                        <select class="form-control" id="StoreSelect" style="width: 100%;">
                            
                           
                        </select>
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" style="margin-top: 12px;">Select Product</label>
                     <select class="form-control" id="ProductSelect" style="width: 100%;">
                            
                           
                        </select>
                    </div>
        
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Type Packed items</label>
                        <input class="form-control" type="number" id="transf_qty" style="width: 100%;">
                            
                           
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Transfer Date</label>
                         <input class="form-control" type="date" id="duedate" onchange="convertAndSetDate()">
                    </div>
                </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="transferInStock">TRANSFER</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="PackingAndTransfer">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">PACK & TRANSFER FINSHED PRODUCT</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here you can pack  and transfer in stock quantity which is less or equal of the produced product</p>
                    <form class="row">
                    
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Select Store</label>
                        <select class="form-control" id="StoreSelected" style="width: 100%;">
                            
                           
                        </select>
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" style="margin-top: 12px;">Select Product</label>
                     <select class="form-control" id="ProductSelectpack" style="width: 100%;">
                            
                           
                        </select>
                    </div>
        
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Type Quantity</label>
                        <input class="form-control" type="number" id="pack_qty" style="width: 100%;">
                            
                           
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="margin-top: 12px;">Done Date</label>
                         <input class="form-control" type="date" id="packdate" onchange="convertAndSetDate()">
                    </div>
                </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-success" type="button" id="PacktransferInStock">PACK & TRANSFER</button></div>
            </div>
        </div>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="add_category_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase;">Add Package Standard</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Package Standard.</p>
                    <label class="form-label" style="margin-top: 12px;">Select Product</label>
                    <select class="form-control" id="ProductstandSelect" style="width: 100%;">
                            
                           
                        </select>
                    <label class="form-label" style="margin-top: 12px;">Set Package Number</label>
                    <input class="form-control" type="number" id="Packingnumber">

    </br>
    <button class="btn btn-primary" type="submit" id="savePackage">Save Package</button>
               


<hr>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Product Name</th>
                                            <th style="font-size: 12px;">Package N0</th>
                                            <th style="font-size: 12px;">Register Date</th>
                                            <th style="font-size: 12px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pack_table">

                                    </tbody>
                                </table>
                            </div>
                        

                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>



    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>