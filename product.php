<?php
include('getuser.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Products - SellEASEP</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css">
    <style>
       #preview-container {
    max-width: 100%;
    max-height: 400px;
    overflow: hidden;
  }
  #preview {
    display: block;
    margin: auto;
    max-width: 100%;
    max-height: 400px;
  }
  #cropped-preview {
    display: none;
    max-width: 100%;
    max-height: 400px;
  }
    </style>
    
    
    
    <script src="js/Products.js"></script>

    <script>
        function showAmadeni() {
            console.log("Changes");

            var ch = $("#flexSwitchCheckChecked");

            if (ch.is(':checked')) {
                $('#amadeni').fadeIn(2000);
                localStorage.setItem("is_paid","Not Paid");
            } else {
                $('#amadeni').hide();
                localStorage.setItem("is_paid", "Paid");
            }
        }
    </script>

    <style>
        /* CSS to change color when switch is ON */
        #flexSwitchCheckChecked:checked+.form-check-label {
            background-color: red;
            color: white;
            padding: 5;
        }
    </style>


</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Products</h3>
                        <div class="d-flex flex-row justify-content-between align-items-center gap-3">
                        <button class="btn btn-success" type="button" style="font-size: 14px;font-weight: bold; padding: 10px; Text-Transform: uppercase; color: white" data-bs-toggle="modal" data-bs-target="#add_category_modal" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add New category</button>
                        <button class="btn btn-primary" type="button" style="font-size: 14px;font-weight: bold; padding: 10px; Text-Transform: uppercase;" data-bs-toggle="modal" data-bs-target="#add_product_modal" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add New Product</button></div>
                        
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Product Information</p>
                            
                             <button class="btn btn-secondary" style="font-size: 15px; font-weight: bold;" id="pickDateButton">Adding Report</button>
                            <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" id="pickeditButton">Editing Report</button>
                            <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" id="pickdeleteButton">Deleting Report</button>
                            <button class="btn btn-info" style="font-size: 15px; font-weight: bold;" id="generateproductReport">Product Report</button>   
                           
                            
                            
                        </div>
                        
                        <input type="text" id="datepicker" style="display: none;"> 
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search now..." id="searcProductNow"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Name</th>
                                            <th style="font-size: 12px;">Price</th>
                                            <th style="font-size: 12px;">Benefit</th>
                                            <th style="font-size: 12px;">Quantity</th>
                                            <th style="font-size: 12px;">Status</th>
                                            <th style="font-size: 12px;">Register Date</th>
                                            <th style="font-size: 12px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spt_table">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Price</strong></td>
                                            <td><strong>Benefit</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Status</strong></td>
                                            <td><strong style="font-size: 11px;">Register Date</strong></td>
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
                    <form><label class="form-label" style="margin-top: 12px;">Name</label>
                    <input class="form-control" type="text" id="name">
                    <label class="form-label" style="margin-top: 12px;">Category:&nbsp;</label>
                    <select class="form-control" id="categorySelect"></select>

                    <label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="number" id="price">
                    <label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="number" id="benefit">
                    <label class="form-label" style="margin-top: 12px;">Description</label>
                    <textarea class="form-control" id="description"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit" id="saveproduct">Save</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="add_category_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase;">Add New category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new category.</p>
                    <label class="form-label" style="margin-top: 12px;">Name</label>
                    <input class="form-control" type="text" id="categoryname">

    </br>
    <button class="btn btn-primary" type="submit" id="savecategory">Save category</button>
               


<hr>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Name</th>
                                            <th style="font-size: 12px;">Register Date</th>
                                            <th style="font-size: 12px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ct_table">

                                    </tbody>
                                </table>
                            </div>
                        

                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

  <div class="modal fade" role="dialog" tabindex="-1" id="purchase_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Purchase product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Purchase Product.</p>
                    <form>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Store Name:&nbsp;</label>
                        <select class="form-control" id="storerSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Supplier:&nbsp;</label>
                        <select class="form-control" id="supplierSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Unit type:&nbsp;</label>
                        <select class="form-control" id="unitSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Container:&nbsp;</label>
                        <input class="form-control" type="number" id="containernum" min="1">
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity/Container:&nbsp;</label>
                        <input class="form-control" type="number" id="qty" min="1">
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price Per Unit:&nbsp;</label>
                        <input class="form-control" type="number" id="priceunity" min="1">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit" id="purchaseBtn">Save</button></div>
            </div>
        </div>
    </div>
    
      <div class="modal fade" role="dialog" tabindex="-1" id="purchaseSalespoint_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Purchase product </h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Purchase Product in the Selected Sales Point.</p>
                    <form>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Sales Point:&nbsp;</label>
                        <select class="form-control" id="salespointSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Supplier:&nbsp;</label>
                        <select class="form-control" id="supplieSelect"></select>

                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Purchased Quantity:&nbsp;</label>
                        <input class="form-control" type="number" id="qtii" min="1">
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">item Price:&nbsp;</label>
                        <input class="form-control" type="number" id="priceunitii" min="1">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit" id="SalesPointpurchaseBtn">Save</button></div>
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
                    <p style="color:black;" > You are successfully Purchase ittt.!!</p>
                    
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
                    <p style="color:black;" > Something went wrong in purchaseing this product. Ask IT Expert To solve it!!</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Ok</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="image_modal" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" style="color:green;">Upload image</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
<center>
                <input type="file" id="image-input">
<br>
<img  scr="uploads/default.jpg" id="preview" alt="Preview">
<br>
<canvas id="cropped-preview"></canvas>
<button id="upload-button" class="btn btn-primary" type="button" data-bs-dismiss="modal">Upload</button>
                    </center>
                </div>
                <div class="modal-footer"></div>
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
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text" id="Up_name"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="number" id="Up_price"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="number" id="Up_benefit"><label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control" id="Up_desc"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="updateproduct">Save</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="edit_category_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Category.</p>
                    <label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text" id="cat_name">
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="updatecategory">Update</button></div>
            </div>
        </div>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="delete-modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this product</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeProduct"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="delete-modal-category">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this category</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeCategory"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="disable-product">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Categorize Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>If you want to disable or enable product&nbsp; click OK</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="" type="button" id="disableorenable" style="color: white;">Disable</button></div>
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
                    <form><label class="form-label" style="margin-top: 10px;">Quantity</label><input class="form-control" type="number" id="Inve_Quantity">
                    <!--<label class="form-label" style="margin-top: 10px;">Alert Quantity</label><input class="form-control" type="number" id="Inve_Alert">-->
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="create_inventory">Create</button></div>
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
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Name:&nbsp;</label><label class="form-label" style="margin-top: 10px;"><span id="product_name"></span>&nbsp;</label><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price:&nbsp;&nbsp;</label><label class="form-label" style="margin-top: 10px;"><span id="product_price"></span></label></form>
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity:&nbsp;</label><label class="form-label" style="margin-top: 10px;">Current Stock: <span id="current_quantity"></span></label><input class="form-control" type="number" id="Sale_qty"><label class="form-label" style="margin-top: 10px;"><span id="calc_result"></span></label></form>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" onchange="showAmadeni()">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Check If is Debt</label>
                        <br />
                        <form>

                            <br />

                            <div class="input-group mb-3" id="amadeni" style="display: none; transition: ease-in-out 0.2s;">
                                <input type="text" class="form-control" placeholder="Customer names" aria-label="Username" id="customer_name">
                                <span class="input-group-text"><i class="bi bi-telephone-forward"></i></span>
                                <input type="tel" class="form-control" placeholder="Phone" aria-label="Server" id="customer_phone">
                            </div>


                        </form>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-primary" type="button" id="save_sell" style="display: none;">Sell</button></div>
            </div>
        </div>



        





        <!-- Bootstrap Toast Container -->
        <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
            <!-- Bootstrap Toast -->
            <div id="myToast" class="toast text-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <p id="diagMsg"></p>
                </div>
            </div>
        </div>

    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
    <script src="script.js"></script>
</body>

</html>