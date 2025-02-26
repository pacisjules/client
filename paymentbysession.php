<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>All Payment by Invoice  - SellEASEP</title>
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
    <script src="js/sales.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
            
                
                <h3 class="text-dark mb-4 fw-bold" style="font-weight: 900;font-size: 22px; text-transform: uppercase;" >All Payments</h3>
                <div style="display: flex;flex-direction: row; justify-content: space-between;" >
 

<!-- <div style="flex-direction:row; margin-bottom:10px;">
<a href="weeklyexpenses.php" class="btn btn-info ">Weekly</a>
        <a href="monthlyexpenses.php" class="btn btn-warning ">Monthly</a>
        <a href="yearlyexpenses.php" class="btn btn-danger ">Yearly</a>
                    </div> -->
              </div>      
                    
                    <div class="card shadow">
                        <div class="card-header py-3" style="display:flex;justify-content:space-between;">
                            <p class=" m-0 fw-bold" style="color:rgb(0,26,53);"> Customer Payments Invoices Sales Records</p>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <?php include('getallpaymentdetailbysessionid.php'); ?>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="delete_payment_modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Payment</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this Payment??</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="deleteBtnPayment"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="edit_payment_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit This Payment</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Here&nbsp;are for Edit Payment.</p>
                <form>
                    <label class="form-label" style="margin-top: 12px;">Payment Method</label>
                    <!-- Replacing the input with a select dropdown -->
                    <select class="form-control" id="editmethod">
                        <option value="EQUITY">EQUITY</option>
                        <option value="ZIGAMA">ZIGAMA</option>
                        <option value="MOMO">MOMO</option>
                        <option value="CASH">CASH</option>
                        <option value="POS">POS</option>
                    </select>
                    <label class="form-label" style="margin-top: 12px;">Amount</label>
                    <input class="form-control" type="number" id="editamount">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="editBtnPayment">Edit</button>
            </div>
        </div>
    </div>
</div>



    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>