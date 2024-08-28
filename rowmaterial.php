<?php
include('getuser.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Row Material - SellEASEP</title>
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

    <script src="js/Rowmaterial.js"></script>
    
    
    

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
        
        #cardshow {
            opacity: 0;
            animation: fadeInAnimation 3s ease-in-out forwards;
        }

        /* Keyframes for the fade-in animation */
        @keyframes fadeInAnimation {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Row Material</h3><button class="btn btn-primary" type="button" style="font-size: 19px;font-weight: bold;" data-bs-target="#add_rawmaterial_modal" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add New Row Material</button>
                    </div>
                    <div class="card shadow" id="cardshow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center" >
                            <p class="text-primary m-0 fw-bold">Row Material Information</p>
                            
                            <!-- <button class="btn btn-secondary" style="font-size: 15px; font-weight: bold;" id="pickDateButton">Adding Report</button>-->
                            <!--<button class="btn btn-success" style="font-size: 15px; font-weight: bold;" id="pickeditButton">Editing Report</button>-->
                            <!--<button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" id="pickdeleteButton">Deleting Report</button>-->
                            <!--<button class="btn btn-info" style="font-size: 15px; font-weight: bold;" id="generateproductReport">Product Report</button>   -->
                           
                            
                            
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search now..." id="searcRowMaterialtNow"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Row Material Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Type</th>
                                            <th>Status</th>
                                            <th style="font-size: 11px;">Register Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spt_table">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Row Material Name</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Unit Type</strong></td>
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
                    <div class="text-center my-auto copyright"><span><?php include('copyright.php'); ?></span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="add_rawmaterial_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Row Material</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Row Material<.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text" id="name">
                        <label class="form-label" style="margin-top: 12px;">Unit Type</label>
                        <select class="form-control" id="unitytype">
                            <option value="PIECE">PIECE</option>
                            <option value="KG">KG</option>
                            <option value="LITRE">LITRE</option>
                            <option value="METRE">METRE</option>
                            <option value="TONNE">TONNE</option>
                        </select>
                        
                    </form>

                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit" id="saverawmaterial">Save</button></div>
            </div>
        </div>
    </div>




    <div class="modal fade" role="dialog" tabindex="-1" id="edit_rowmaterial_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Row material</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Row material.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Row material Name</label><input class="form-control" type="text" id="editrowname">
                        <label class="form-label" style="margin-top: 12px;">Unity Type</label><input class="form-control"  type="text" id="editunity">
                        
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="updaterowmaterial">Save</button></div>
            </div>
        </div>
    </div>
    
    <!--  <div class="modal fade" role="dialog" tabindex="-1" id="purchasemodal">-->
    <!--    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">-->
    <!--        <div class="modal-content">-->
    <!--            <div class="modal-header">-->
    <!--                <h4 class="modal-title">Purchase</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
    <!--            </div>-->
    <!--            <div class="modal-body">-->
    <!--                <p>Here&nbsp;are for Purchasing Row material.</p>-->
    <!--                <form>-->
    <!--                    <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Supplier:&nbsp;</label>-->-->
    <!--                   <select class="form-control" id="supplierSelect"></select>-->
    <!--                    <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity:&nbsp;</label>-->
    <!--                    <input class="form-control" type="number" id="qty">-->
    <!--                    <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price Per Unity:&nbsp;</label>-->
    <!--                    <input class="form-control" type="number" id="priceunity">-->
                        
    <!--                </form>-->
    <!--            </div>-->
    <!--            <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="purchaserowmaterial">Save</button></div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="delete-modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Row Material</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this Row Material</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeRow_Material"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
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
                    <form><label class="form-label" style="margin-top: 10px;">Quantity</label><input class="form-control" type="number" id="Inve_Quantity"><label class="form-label" style="margin-top: 10px;">Alert Quantity</label><input class="form-control" type="number" id="Inve_Alert"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="create_inventory">Create</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="purchasemodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Purchase Now</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here are for purchasing row material now.</p>
                    
                    <form>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Supplier:&nbsp;</label>
                        <select class="form-control" id="supplierSelect"></select>
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Box/carton:&nbsp;</label>
                        <input class="form-control" type="number" id="box" min="1">
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity/box:&nbsp;</label>
                        <input class="form-control" type="number" id="qty" min="1">
                        <label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price Per Unit:&nbsp;</label>
                        <input class="form-control" type="number" id="priceunity" min="1">
                    </form>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button> 
                <button class="btn btn-primary" type="button" id="purchaserowmaterial">Save</button>
                </div>
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
</body>

</html>