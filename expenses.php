<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Daily Expenses - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/expenses.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
            
                
                <h3 class="text-dark mb-4 fw-bold" style="font-weight: 900;font-size: 22px; text-transform: uppercase;" >Expenses</h3>
                <div style="display: flex;flex-direction: row; justify-content: space-between;" >
               <div style="flex-direction:row;display: flex; margin-bottom:10px;">     
                    <button  class="btn btn-primary" style="margin-right:10px;" data-bs-target="#expensesmodal" data-bs-toggle="modal">Add Expenses Type</button>
                    <button  class="btn btn-primary" data-bs-target="#addexpensesmodal" data-bs-toggle="modal">Add Expenses</button>
               </div>

<!-- <div style="flex-direction:row; margin-bottom:10px;">
<a href="weeklyexpenses.php" class="btn btn-info ">Weekly</a>
        <a href="monthlyexpenses.php" class="btn btn-warning ">Monthly</a>
        <a href="yearlyexpenses.php" class="btn btn-danger ">Yearly</a>
                    </div> -->
              </div>      
                    
                    <div class="card shadow">
                        <div class="card-header py-3" style="display:flex;justify-content:space-between;">
                            <p class=" m-0 fw-bold" style="color:rgb(0,26,53);"> Daily Expenses Records</p>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <?php include('getallexpenses.php'); ?>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="expensesmodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Add Expenses Type</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here You can Add Expenses Type.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text" id="named">
                    <label class="form-label" style="margin-top: 12px;">Description</label><input class="form-control" type="text" id="decsri">
                </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="addnewtype">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addexpensesmodal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: bold; Text-transform: uppercase; font-size: 15px">Add New Expenses</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Here You can Add New Expenses.</p>
                <form>
                    <label class="form-label" style="margin-top: 12px;">Name</label>
                    <input class="form-control" type="text" id="expname">
                    <label class="form-label" style="margin-top: 12px;">Description</label>
                    <input class="form-control" type="text" id="descriexp">
                    <label class="form-label" style="margin-top: 12px;">Depend On</label>
                    <input class="form-control" type="text" id="dependon">
                    <label class="form-label" style="margin-top: 12px;">Select Expenses Type</label>
                    <select class="form-control" id="expenseTypeSelect"></select>
                    <label class="form-label" style="margin-top: 12px;">Amount</label>
                    <input class="form-control" type="number" id="amountnum">
                    <label class="form-label" style="margin-top: 12px;">Payment Method</label>
                    <select class="form-control" id="payment">
                
                <option value="EQUITY">EQUITY</option>
                <option value="ZIGAMA">ZIGAMA</option>
                <option value="MOMO">MOMO</option>
                <option value="CASH">CASH</option>
                <option value="POS">POS</option>
            </select>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="expensesBtn">Add</button>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" role="dialog" tabindex="-1" id="edit_expe_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Expenses Data</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Here You can Edit Expenses Data.</p>
                <form>
                    <label class="form-label" style="margin-top: 12px;">Name</label>
                    <input class="form-control" type="text" id="dexpname">
                    <label class="form-label" style="margin-top: 12px;">Description</label>
                    <input class="form-control" type="text" id="edescriexp">
                    <label class="form-label" style="margin-top: 12px;">Select Expenses Type</label>
                    <select class="form-control" id="expenseTypeedit"></select>
                    <label class="form-label" style="margin-top: 12px;">Amount</label>
                    <input class="form-control" type="number" id="amountedit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="editexpensesBtn">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="delete_expe_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remove Expenses Data</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove Expenses Data.</p>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" type="button" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>