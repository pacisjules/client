<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Assets - SELLEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">

    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/asset.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="text-dark mb-4" style="font-weight: 900;font-size: 22px; text-transform: uppercase;">Asset Manager</h3>
                        <button class="btn btn-primary" type="button" style="font-size: 19px;font-weight: bold;" data-bs-target="#add_customer_modal" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add New Asset</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Asset Information</p>
                            
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" id="searchCustomer"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Assets Category</th>
                                            <th>Assets Name</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th >Register Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cust_table">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Assets Category</strong></td>
                                            <td><strong>Assets Name</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Status</strong></td>
                                            <td><strong >Register Date</strong></td>
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
                    <?php include('copyright.php'); ?>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Add New Asset</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Asset.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Asset Category</label>
                        <select class="form-control" id="categorySelect"></select>
                        <label class="form-label" style="margin-top: 12px;">Asset Name</label>
                        <input class="form-control" type="text" id="names">
                        <label class="form-label" style="margin-top: 12px;">Asset Quantity</label>
                        <input class="form-control" type="number" min="1" id="qty">
                        <label class="form-label" style="margin-top: 12px;">Asset Status</label>
                        <select class="form-control" id="StatusSelect">
                            <option value="Active" style="color: green;">Active</option>
                            <option value="Inactive" style="color: gray;">Inactive</option>
                            <option value="Under Maintenance" style="color: orange;">Under Maintenance</option>
                            <option value="Disposed" style="color: red;">Disposed</option>
                            <option value="In Repair" style="color: yellow;">In Repair</option>
                            <option value="Lost or Stolen" style="color: purple;">Lost or Stolen</option>
                            <option value="Reserved" style="color: blue;">Reserved</option>
                            <option value="Damaged" style="color: brown;">Damaged</option>
                        </select>
                                                
                        
                        </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="addasset">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="edit_product_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Asset</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Asset.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Asset Name</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Asset Quantity</label><input class="form-control" type="number">
                     
                    
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="delete-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Remove This Asset</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete the Asset <span id="delnames"></span> </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeAsset"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove Asset</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal_inventory">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Edit Asset information</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <form>
                        <label class="form-label" style="margin-top: 10px;">Asset Names</label>
                        <input class="form-control" type="text" id="editnames"> <!-- Use type="text" for text input -->
                        <label class="form-label" style="margin-top: 10px;">Asset Quantity</label>
                        <input class="form-control" type="text" id="editqty"> <!-- Use type="text" for text input -->
                       <label class="form-label" style="margin-top: 12px;">Asset Status</label>
                        <select class="form-control" id="Statusedit">
                            <option value="Active" style="color: green;">Active</option>
                            <option value="Inactive" style="color: gray;">Inactive</option>
                            <option value="Under Maintenance" style="color: orange;">Under Maintenance</option>
                            <option value="Disposed" style="color: red;">Disposed</option>
                            <option value="In Repair" style="color: yellow;">In Repair</option>
                            <option value="Lost or Stolen" style="color: purple;">Lost or Stolen</option>
                            <option value="Reserved" style="color: blue;">Reserved</option>
                            <option value="Damaged" style="color: brown;">Damaged</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditAsset">Edit Customer</button></div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>