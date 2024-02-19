<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Store Details - SellEASEP</title>
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
    <script src="js/multistore.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                     <div>
                     
                       <a class="nav-link active" href="multistore.php">  <button  type="button" style="font-size: 15px;font-weight: bold; background-color:#040536; border-radius:10px; color:white; margin-bottom:10px;"><i class="fas fa-arrow-left"></i>
                     &nbsp;Back</button></a> 
                     
                     <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 20px;">Store Name =  <span id="storename"></span></h3>
                     <p class="text-dark mb-4" style="color:black"> Managed by = <span id="storekeeper"></span></p>
                     <p class="text-dark mb-4" style="color:black"> Phone Contact = <span id="storephone"></span></p>
                   </div>
                         
                        
                   <div>
                       <!--<h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Row Material Stock Details of <span id="customer_name"></span></h3>-->
                      
                   </div> 
                   
                   
                     
                     
                     
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Store Details Information</p>
                            <button class="btn btn-warning" style="font-size: 15px; font-weight: bold;"  id="pickDateButton">Transfer Report</button>
                            <!--<div>-->
                            <!--    <button style="font-weight: bold;background-color:#040536; color:white; border-radius:10px;" data-bs-target="#payfull_modal" data-bs-toggle="modal">Pay In Full</button>-->
                            <!--    <button style="font-weight: bold;background-color:#040536; color:white; margin-left:2rem; border-radius:10px;" data-bs-target="#paytranche_modal" data-bs-toggle="modal">Pay In Installments</button>-->
                            <!--</div>-->
                            
                        </div>
                        
                        <input type="text" id="datepicker" style="display: none;"> 
                        
                        
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" id="searchCustomer"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Product Names</th>
                                            <th>Quantity</th>
                                            <th>Purchase date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="stockdetail_table">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Product Names</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Purchase Date</strong></td>
                                            <td><strong>Actions</strong></td>
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
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    
    
    
   
    
      <div class="modal fade" role="dialog" tabindex="-1" id="edit_sales_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Purchase</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Purchase.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Quantity</label><input class="form-control" type="text" id="editquantity"></form>
                     <form><label class="form-label" style="margin-top: 12px;">Price per Unity</label><input class="form-control" type="text" id="editprice"></form>
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
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="transfer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Transfer Stock</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Transfer Product.</p>
                    <form>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Sales Point:&nbsp;</label>
                        <select class="form-control" id="salespointSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity:&nbsp;</label>
                        <input class="form-control" type="number" id="qty" min="1">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="submit" id="transferBtn">Transfer</button></div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="payfull_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pay In full all debts of <span id="custn"></span></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can pay all debts.</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="payalldebt">Finish</button></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="paytranche_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pay debts of <span id="custne"></span> in Installments</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; you can pay debts in Installments.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Enter Amount</label>
                        <input class="form-control" type="number" id="amountpaid">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="paytranchedebt">Finish</button></div>
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
                    <p style="color:black;" > You are successfully Transfering ittt.!!</p>
                    
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