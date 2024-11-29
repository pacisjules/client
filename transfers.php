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

        $(document).ready(function () {
            $("#product_info_result").hide();
            $("#search_result").hide();
            $("#transferBtn").hide();
        });

        function getrequestid(id){
                localStorage.setItem("idrequi",id);
            }


        function rejectRequest(){
            var id = localStorage.getItem("idrequi");
            $.ajax({
                type: "POST",
                url: "functions/purchase/rejectrequest.php", // Update this with the actual path to your PHP script
                data: {
                    id: id, // Corrected variable name to match the PHP script
                },
                success: function (response) {
                    console.log("response:", response);
                    $("#rejectModal").modal('hide');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }




        function getrequestinfo(id, qty, product_name, product_id, sales_point_id){
                localStorage.setItem("idrequi",id);
                localStorage.setItem("requiqty", qty);
                localStorage.setItem("requiproduct_name", product_name);
                localStorage.setItem("idproductTrans", product_id);
                localStorage.setItem("sptTransfer", sales_point_id);
                
                $("#pro_name").html(product_name);
                $("#pro_qty").html(qty);
            }


        function searchthisProduct(e){
            $("#product_info_result").hide();
            $("#search_result").show();

            if(e.length>2){
                var key = e;
            var spt= localStorage.getItem("SptID");
            // console.log(key);

            $.ajax({
                type: "POST",
                url: "functions/purchase/searchproductfortransfer.php",
                data: {
                    key: key,
                    spt:spt
                },
                success: function (response) {
                    // console.log("response:", response);
                    $("#search_result").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
            }else{
                $("#product_info_result").hide();
                $("#search_result").hide();
                return;
            }
        }


        function calculation(val, qty){
            
            if(val>qty){
                $("#transferBtn").hide();
                $("#calc_result").html('It is more than the current quantity');
                return;
            }else{
                $("#transferBtn").show();
                $("#calc_result").html('');
            }            
        }


        function setProduct(id, name, qty){
            console.log(id, name, qty);
            $("#product_info_result").show();
            $("#search_result").hide();
            $("#req_search").val("");
            $("#product_info_result").html("<p>Product: "+name+" <br>Current Quantity: "+qty+"</p><div class='input-group mb-3'><span class='input-group-text' id='basic-addon1'>Transfer Quantity</span><input class='form-control' type='number' value='' oninput='calculation(this.value, "+qty+")' id='req_qty_trans'  placeholder=''></div><span style='color: red;' id='calc_result'></span>");
            localStorage.setItem("idfrom",id);
            localStorage.setItem("qtyfrom",qty);
        }


        function transferProduct(){
            var producIdfrom = localStorage.getItem("idfrom");
            var productIdtrans = localStorage.getItem("idproductTrans");

            var qty = localStorage.getItem("qtyfrom");
            var qty_trans = $("#req_qty_trans").val();

            var sptFrom = localStorage.getItem("SptID");
            var sptTransfer = localStorage.getItem("sptTransfer");
            var requestID= localStorage.getItem("idrequi");
            

            // console.log(id, qty, qty_trans, spt);
            $.ajax({
                type: "POST",
                url: "functions/purchase/transferproduct.php",
                data: {
                    productFrom: producIdfrom,
                    productTo: productIdtrans,
                    qtyFrom: qty,
                    qty_trans: qty_trans,
                    sptFrom: sptFrom,
                    sptTransfer: sptTransfer,
                    requestID: requestID,
                    
                },
                success: function (response) {
                    // console.log("response:", response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
                })
        }



    </script>

    <style>
        /* CSS to change color when switch is ON */
        #flexSwitchCheckChecked:checked+.form-check-label {
            background-color: red;
            color: white;
            padding: 5;
        }

        .getter{
            color: black;
            padding: 5px;
            border-radius: 5px;
            font-size:11pt;
            text-decoration: none;
            margin-right: 10px;
            transition: ease-in-out 0.2s;

        }

        .getter:hover{
            background-color: black;
            color: white;
            text-decoration: underline;
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
                        <h3 class="text-dark mb-4" style="font-weight: 900;font-size: 22px; text-transform: uppercase;">REQUESTED TRANSFERS</h3>
                        <div class="d-flex flex-row justify-content-between align-items-center gap-3">
                        </div>
                        
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">TRANSFER Information</p>
                            
                             <!-- <button class="btn btn-secondary" style="font-size: 15px; font-weight: bold;" id="pickDateButton">Adding Report</button>
                            <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" id="pickeditButton">Editing Report</button>
                            <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" id="pickdeleteButton">Deleting Report</button>
                            <button class="btn btn-info" style="font-size: 15px; font-weight: bold;" id="generateproductReport">Product Report</button>    -->
                           
                            
                            
                        </div>
                        
                        <input type="text" id="datepicker" style="display: none;"> 
                         <input type="text" id="datepickeredit" style="display: none;"> 
                         <input type="text" id="datepickerdelete" style="display: none;"> 
                        
                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-md-6 text-nowrap">
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
                            </div> -->
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <?php include('gettransfers.php'); ?>
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



    <div class="modal fade" role="dialog" tabindex="-1" id="add_product_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Add New Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Product.</p>
                    <p id="save_message" style="color: red;"></p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label>
                    <input class="form-control" type="text" id="name">
                    <label class="form-label" style="margin-top: 12px;">Category:&nbsp;</label>
                    <select class="form-control" id="categorySelect"></select>

                    <label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="number" id="price">
                    <label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="number" id="benefit">
                    <label class="form-label" style="margin-top: 12px;">Barcode</label><input class="form-control" type="text" id="barcode">
                    
                    <div class="form-check" style="margin-top: 12px;">
                        <input class="form-check-input" type="checkbox" value="" id="ExpCheck">
                        <label class="form-check-label" for="ExpCheck">
                            Allow expiration task on this product.
                        </label>
                        <div id="time_addons_div">
                        <p style="margin-top: 15px; font-size: 13px;">User only hours for product expiration</p>
                        <input class="form-control" type="number" id="time_addons" style="margin-top: -15px;">
                        <p style="margin-top: 10px; color: green; font-size: 13px;">Period: <span id="time_period"> 2 days and 1 hour</span></p>
                        </div>
                    </div>


                    <label class="form-label" style="margin-top: 12px;">Description</label>
                    <textarea class="form-control" id="description"></textarea></form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="saveproduct">Save</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="add_category_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Add New category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Reject product request</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Reject Product.</p>
                    <p>Are you sure you want to Reject this product?</p>
                    <p><i class="fa fa-circle" style="color: green;"></i> Press Yes to Reject , <i class="fa fa-circle" style="color: red;"></i> Press No to Cancel</p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="rejectBtn" onclick="rejectRequest()">Yes</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
      <div class="modal fade" role="dialog" tabindex="-1" id="purchaseSalespoint_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Transfer product with inventory</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Search in your inventory this product.</p>
                    <p>Type the same product as <span id="pro_name">...</span> and <span id="pro_qty">..</span> as quantity</p>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Search here</span>
                        <input class="form-control" type="text" value="" id="req_search" oninput="searchthisProduct(this.value)"  placeholder="Search product">
                    </div>
                    <br/>
                    <div id="search_result">
                            
                    </div>

                    <div id="product_info_result">
                            
                    </div>

                        
                   
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit" onclick="transferProduct()" id="transferBtn">Transfer product</button></div>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="newerrormodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:red;">Error!!!!</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;" >This product is already added in system</p>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#add_product_modal">Ok</button></div>
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
                    <h4 class="modal-title" style="color:green; font-weight: bold; Text-transform: uppercase; font-size: 15px">Upload image</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
<center>
                <label for="image-input" class="btn btn-primary">
                    <i class="bi bi-image"></i> Select Image
                </label>
                <input type="file" id="image-input" style="display: none;">
<br>
<!-- <img  scr="default.jpg" id="preview" alt="Preview"> -->
<img src="default.jpg" id="preview" alt="Image Preview" width="150px" height="150px">
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
                <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Edit this Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Product.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text" id="Up_name"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="number" id="Up_price"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="number" id="Up_benefit">
                    
                    <div class="form-check" style="margin-top: 12px;">
                        <input class="form-check-input" type="checkbox" value="" id="ExpCheck2">
                        <label class="form-check-label" for="ExpCheck2">
                            Allow expiration task on this product.
                        </label>
                        <div id="time_addons_div2">
                        <p style="margin-top: 15px; font-size: 13px;">User only hours for product expiration</p>
                        <input class="form-control" type="number" id="time_addons2" style="margin-top: -15px;">
                        <p style="margin-top: 10px; color: green; font-size: 13px;">Period: <span id="time_period2"> 2 days and 1 hour</span></p>
                        </div>
                    </div>

                    
                    <label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control" id="Up_desc"></textarea></form>
                
                
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="updateproduct">Update</button></div>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Remove Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Remove Category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Categorize Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Give Product Inventory</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Sale Now</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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