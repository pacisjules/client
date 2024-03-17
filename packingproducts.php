<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Packing Products - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">

    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/production.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        .package {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            display: inline-block;
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
                        <div>
                         <a class="nav-link active" href="finishedproduct.php">  <button  type="button" style="font-size: 15px;font-weight: bold; background-color:#040536; border-radius:10px; color:white; margin-bottom:30px;"><i class="fas fa-arrow-left"></i>
                     &nbsp;Back</button></a>   
                     <h1 class="text-dark mb-4" style="font-weight: bold;font-size: 30px;">Packing Products of <span id="product_name"></span></h1>
                        </div>
                    </div>

                    <div style="display: flex;flex-wrap: wrap;justify-content: space-between;padding: 10px;margin-top:20px;" id="storeboxes">
                   
                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Package</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
                     </div>
                        
                    </div>

                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Package</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
                     </div>
                        
                    </div>

                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Package</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
                     </div>
                        
                    </div>

                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Packaging</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
                     </div>
                        
                    </div>

                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Packaging</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
                     </div>
                        
                    </div>

                    <div style="border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 20px; margin-left: -8px; margin-left: -8px; width: calc(33.33% - 20px); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-webkit-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);-moz-box-shadow: -3px 0px 46px 2px rgba(99,101,148,0.75);">
                        <h4 style="text-align: center;color:rgb(0,26,53);">1 liter Packaging</h4>
                        <h5 style="text-align: center;color:rgb(0,26,53);">qty:10</h5>
                        <p style="text-align: center;color:rgb(0,26,53);font-size:12px;">Each package contains 1 liter of yogurt.</p>
                     <div style="display:flex; flex-direction: row;">
                       <button style="background-color: #071073; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-right:10px;">Packing</button>
                       <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;">Transfer</button>
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