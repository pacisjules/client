<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Transaction - Selleasep</title>
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
    <script src="js/transaction.js"></script>


    <style>

        /* width */
::-webkit-scrollbar {
    width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #ffe6b8;
    color: #78080069
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #c86b00;
    border-radius: 6px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: orange;
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
                    <div class="d-flex flex-row justify-content-between align-items-center" style="box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);-webkit-box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);-moz-box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);border-radius: 5px;padding: 10px;">
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Transaction Records</h3>
                        <!-- <button class="btn btn-primary" type="button" style="font-size: 19px;font-weight: bold;" data-bs-target="#add_new_departement" data-bs-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add New Department</button> -->
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center" style="box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);-webkit-box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);-moz-box-shadow: -4px 11px 46px 3px rgba(99,101,148,0.75);border-radius: 5px;padding: 10px; margin-top: 20px;">
                    <div class="row">
            <!-- Single Date Picker -->
            <div class="col-md-4">
                <label for="reportDate" style="margin-left: 1rem;">Select Date:</label>
                <input type="date" id="reportDate" class="form-control" style="width: 220px;margin-left: 1rem;">
            </div>

            <!-- From/To Date Range Pickers with Inline Fetch Button -->
            <div class="col-md-4">
                <label for="fromDate" style="margin-left: 3rem;">From:</label>
                <input type="date" id="fromDate" class="form-control" style="width: 150px;margin-left: 3rem;">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div style="">
                    <label for="toDate" >To:</label>
                    <input type="date" id="toDate" class="form-control" style="width: 150px; ">
                </div>
                <div class="ms-2">
                    <button id="fetchReportBtn" class="btn btn-primary" style="width: 150px; ">Fetch Report</button>
                </div>
            </div>
        </div>
                    </div>
                    
                    <div style="display: flex;flex-wrap: wrap;justify-content: space-between;padding: 10px;margin-top:20px;" id="storeboxes">
                        
                   </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="add_new_departement">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Department</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Department.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Department Name</label><input class="form-control" type="text" id="department_name" required>
                    <label class="form-label" style="margin-top: 12px;">Chef Department</label><input class="form-control" type="text" id="chefDepartment" required>
                    <label class="form-label" style="margin-top: 12px;">Chef Tel</label><input class="form-control" type="text" id="cheftel" required>
                    
                </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="AddNewDepartment">Create Department</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="edit_product_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:black;">Transfer Quantity In Stock</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;">Here&nbsp;are for transfering The produced quantity of <span id="finishedPro"></span>.</p>
                    <form>
                        <p style="color:black;">Are you sure to transfer this quantity: <span id=quantity></span> ??</p>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="transferInStock">Transfer</button></div>
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
                    <p>Are sure you need to delete this Inventory of <span id="product_name"></span> </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeInventory"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove Inventory</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal_inventory">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit Inventory</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Edit inventory of <span id="product_name"></span></p>
                    <form><label class="form-label" style="margin-top: 10px;">Quantity</label><input class="form-control" type="number" id="quantity"><label class="form-label" style="margin-top: 10px;">Alert Quantity</label><input class="form-control" type="number" id="alert_quantity"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditInventory">Edit Inventory</button></div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>