<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>POS - SellEASEP</title>
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


    <script>
        function showAmadenis() {
            console.log("Changes");

            var ch = $("#flexSwitchCheckChecked");
            if (ch.is(':checked')) {
                // $('#amadenis').fadeIn(2000);
                localStorage.setItem("is_paid", "Not Paid");
            } else {
                // $('#amadenis').hide();
                localStorage.setItem("is_paid", "Paid");
            }
        }
        
        function showNegotiablePrice() {
            console.log("Changes");

            var ch = $("#flexSwitchPriceChecked");
            if (ch.is(':checked')) {
                $('#NegotiablePrice').fadeIn(2000);
                // localStorage.setItem("is_paid", "Not Paid");
            } else {
                $('#NegotiablePrice').hide();
                // localStorage.setItem("is_paid", "Paid");
            }
        }


        // Function to set today's date as the default value
  function setTodayDate() {
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
    var year = today.getFullYear();

    // Format the date as YYYY-MM-DD
    var todayDate = year + '-' + month + '-' + day;

    // Set the input's default value to today's date
    document.getElementById('duedate').value = todayDate;

    // Convert and set the formatted date when the page loads
    convertAndSetDate();
  }

  // Function to convert date format (if needed) and set it
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

  // Function to convert date format to YYYY-MM-DD
  function convertDateFormat(dateString) {
    var date = new Date(dateString);
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0'); // January is 0
    var year = date.getFullYear();

    // Return the date in the desired format (YYYY-MM-DD)
    return year + '-' + month + '-' + day;
  }

  // Call the function to set today's date on page load
  window.onload = setTodayDate;



    </script>


    <style>
        body {
            font-size: 10pt;
        }

        .hover-effect:hover {
            /* Define the styles for the hover state */
            background-color: lightgray;
            color: blue;
        }

        /* CSS to change color when switch is ON */
        #flexSwitchCheckChecked:checked+.form-check-label {
            color: red;
            font-weight: bold;
            padding: 5;
        }
        
        #flexSwitchPriceChecked:checked+.form-check-label {
            color: green;
            font-weight: bold;
            padding: 5;
        }
        
        #tablet{
            width:100%;
            min-height:100vh;
            height:100vh;
            position:fixed;
            z-index:999;
            background-color:red;
            display:none;
        }
        
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="styles/mystyle.css"> -->

</head>

<body id="page-top">
<div id="tablet" >
<div class="top">
    <div>
        <h1 style="margin-top:8pt;">Selleasep POS</h1>
        <p style="font-size:10pt; margin-top:-10pt;">Please use View menu then Reload when no data found</p>
    </div>
    <div>
        <div class="searcher">
            <input type="text" oninput="setSearch(this.value)" placeholder="Search products......." >
            <img src="styles/icons/search.png" alt="" srcset="">
        </div>
    </div>
    <div class="infos">
        <div class="btns">
            <img src="styles/icons/refresh.png" alt="" srcset="" onclick="setOldCart()">
            <!-- <img src="styles/icons/refresh.png" alt="" srcset="" onclick="refreshPage()"> -->
        </div>
        <div class="btns">
            <img id="wifi_status" src="styles/icons/wifiOn.png" alt="" srcset="">
        </div>
        <div class="rightExit" id="Exit">
            <img src="styles/icons/switch.png" alt="" srcset="">
        </div>
    </div>
</div>

<div class="down">
    <div class='LeftSide'>
       <div class="clbtns">
       <a href="index.php"><img src="styles/icons/home.png" alt="" srcset="">
        <p>Home</p></a>
       </div>
       <div class="clbtns">
       <a href="product.php"><img src="styles/icons/features.png" alt="" srcset="">
        <p>Products</p></a>
       </div>
       <div class="clbtns">
       <a href="sales.php"><img src="styles/icons/direct-marketing.png" alt="" srcset="">
        <p>Sales</p></a>
       </div> 
    </div>
    <div class='MiddleSide'>
        <div class="category">
        <ul id="categorylist">
            <!-- <li>All</li>

            <li>Soft Drinks</li>
            <li>Juice Drinks</li>
            <li>Snacks Food</li>
            <li>Cooked Food</li> -->
        </ul>
        </div>
        <div class="products" id="productslist">
        </div>
    </div>
    <div class='RightSide'>
        <div class="bodyTable">
            <div class="Title"><span id="items_number">0</span> Item(s) Listed in basket, <span id="holds_number">0 Hold</span> <span id="unhold" onclick="holded_carts()">UNHOLD</span></div>
<div>     
<table>
<thead>
<tr>
<th>Item</th>
<th>Price</th>
<th>Total</th>
<th>Actions</th>
</tr>
</thead>
<tbody id="cartItemTableTablet">

</tbody>
</table></div>   
        </div>
        <div class="payment">
            <div class="calc">
                
            <h2>Payable Amount</h2>
            <h3 id="subtotal">0 Rwf</h3>
        
        </div>
            <div class="calc">
            <h2>Tax</h2>
            <h3>0 Rwf</h3>
            </div>
            <div class="calc">
            <h2>Payable Amount</h2>
            <h3 id="subtotalPayable">0 Rwf</h3>
            </div>

            <div class="calcBtns">
                <button id="holdp_sell_tablet" onclick="hold_tablet_sales()">Hold Order</button>
                <button id="savep_sell_tablet" onclick="proceed_tablet_sales()">Proceed</button>
            </div>
        </div>
    </div>
</div>
</div>

    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Sales Panel</h3>
                    </div>
                    <div class="d-flex">
                        
                        <div class="card shadow" style="width: 60%;">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Make Cart</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-nowrap">

                                
                                    </div>
                                  
                                </div>
                                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                    <table class="table my-0" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>Product name</th>
                                                <th>Price</th>
                                                <th>Paid</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartItemTable">


                                        </tbody>
                                        <tfoot>
                                            <tr style="background: #efefef;">
                                                <td><strong></strong></td>
                                                <td><strong></strong></td>
                                                <td><strong></strong></td>
                                                <td><strong>G.Total</strong></td>
                                                <td id="totalAmount"><strong>

                                                    </strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <label class="form-label" style="margin-top: 12px;">Right Sales Date</label>
<input class="form-control" type="date" style="width:90%;" id="duedate" onchange="convertAndSetDate()" />

<br />

                                
                                 <div class="input-group mb-3" id="amadenis" style="transition: ease-in-out 0.2s; flex-direction:column;">
                                           <label>Search Customer</label><br /><input class="form-control" style="width:90%;" type="text" placeholder="Search Customer ....." id="searchCustomerNow">


                                            <div style="background: #ededed;box-shadow: -2px 8px 12px 0px rgba(133,135,150,0.45);padding: 6px;padding-left: 13px;width:90%;" id="getsearchCustomer">
            
                                            </div>
                                            <br />
                                            <div style="flex-direction:row;color:black;">
                                            <label>Customer Names : </label> <span id="getnames"></span> , Tel: <span id="getphone"></span>  , Address: <span id="getaddress"></span></div><br />
                                           <!--<div style="flex-direction:row;"> <label>Phone Number :</label> <span id="getphone"></span></div>-->
                                           <!--<div style="flex-direction:row;">  <label>Address : </label> <span id="getaddress"></span> </div> <br />  -->
                                           <div style="display:flex;flex-direction:row; justify-content:space-between;">
    <button class="btn btn-primary" type="button" data-bs-target="#add_customer_modal" data-bs-toggle="modal" style="margin-right:10px;height:40px;">CLIENT</button>
    <div id="paymentMethodsContainer">
        <!-- Initial Payment Method -->
        <div class="payment-method-group" style="display:flex;flex-direction:row;">
            <select class="form-control payment-method" name="PaymentMethod[]" style="margin-right: 10px;">
                <option value="" disabled selected>Select payment method</option>
                <option value="EQUITY">EQUITY</option>
                <option value="ZIGAMA">ZIGAMA</option>
                <option value="MOMO">MOMO</option>
                <option value="CASH">CASH</option>
                <option value="POS">POS</option>
            </select>
            <input type="number" class="form-control payment-amount" name="PaymentAmount[]" placeholder="Amount" style="margin-top: -6px; margin-right: 10px;" />
            <button class="btn btn-danger delete-payment-method" type="button" style="height:40px;">Delete</button>
        </div>
    </div>
    <!-- Button to add another payment method (initially hidden) -->
    <button id="addToLocalStorageButton" class="btn btn-primary" type="button" style="display:none;margin-left:10px;height:40px;">ADD</button>
    <button id="addPaymentMethodButton" class="btn btn-success" type="button" style="margin-left:10px;height:40px;">NEW</button>
</div>





                                            
                                        </div>


                                <div class="form-check form-switch" id="chow ">
                                    <div style="display:flex;flex-direction:row; justify-content:space-between;">
                                        <div>
                                    <!-- <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" onchange="showAmadenis()">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Approve Debts</label> -->
    </div>
    

    </div>

                                    <!--<br />-->
                                    <!--<form>-->

                                    <!--    <br />-->

                                    <!--    <div class="input-group mb-3" id="amadenis" style="display: none; transition: ease-in-out 0.2s; flex-direction:column;">-->
                                    <!--       <label>Search Customer</label><br /><input class="form-control" style="width:90%;" type="text" placeholder="Search Customer ....." id="searchCustomerNow">-->


                                    <!--        <div style="background: #ededed;box-shadow: -2px 8px 12px 0px rgba(133,135,150,0.45);padding: 6px;padding-left: 13px;width:90%;" id="getsearchCustomer">-->
            
                                    <!--        </div>-->
                                    <!--        <br />-->
                                    <!--        <div style="flex-direction:row;">-->
                                    <!--        <label>Customer Names : </label> <span id="getnames"></span></div>-->
                                    <!--       <div style="flex-direction:row;"> <label>Phone Number :</label> <span id="getphone"></span></div>-->
                                    <!--       <div style="flex-direction:row;">  <label>Address : </label> <span id="getaddress"></span> </div> <br />  -->
                                    <!--       <div style="flex-direction:row;">  <button class="btn btn-primary" type="button"  data-bs-target="#add_customer_modal" data-bs-toggle="modal">Add New Customer</button> </div> -->
                                            
                                    <!--    </div>-->
                                        


                                    <!--</form>-->
                                </div>
                                
                                
                                <div class="d-flex justify-content-start" style="margin-top: 2rem;"><button class="btn btn-dark" type="button" id="savep_sell" style="font-weight: bold;font-family: Nunito, sans-serif;font-size: 20px;margin-bottom: 15px;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cart-plus-fill">
                                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"></path>
                                        </svg>&nbsp; &nbsp;SALE NOW</button>
                                </div>
                                
                            </div>
                        </div>
                    <div style="margin-left: 31px;width: 40%;">


                            <form><label class="form-label">SEARCH PRODUCT</label><input class="form-control" type="text" placeholder="Search Product ....." id="searcProductNow">


                                <div style="background: #ededed;box-shadow: -2px 8px 12px 0px rgba(133,135,150,0.45);padding: 6px;padding-left: 13px;" id="getseach">

                                </div>





                                <label class="form-label" style="margin-top: 28px; color:black;">PRODUCT: <span id="gettedProduct" style="font-weight:bold; color:blue;"></span> &nbsp;&nbsp;</label><label class="form-label" style="padding-top: 0px;margin-top: 14px;font-weight: bold;color:black;">PURCHASED : <span id="gettedPrice" style="font-weight:bold; color:green;"></span> Quantity: <span id="gettedCQuantity" style="font-weight:bold; color:red;"></span></label><input class="form-control" type="number" id="Sales_qty" placeholder="Enter quantity ..." style="margin-top: -6px;">
                                
                                <br />
                                <label class="form-label" style="margin-top: 28px; color:black;">PRICE: </label>
                                <input class="form-control" type="number" id="NegoPrice" placeholder="Enter selling price ..." style="margin-top: -6px;">
                                <label class="form-label" style="margin-top: 28px; color:black;">PAID AMOUNT: </label>
                                <input class="form-control" type="number" id="paidamount" placeholder="Enter amount paid ..." style="margin-top: -6px;">

                                <!-- <div class="form-check form-switch" id="chow ">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchPriceChecked" onchange="showNegotiablePrice()">
                                    <label class="form-check-label" for="flexSwitchPriceChecked">Add Negotiable Price</label>
                                        <br />
                                         <br />
                                        <div class="input-group mb-3" id="NegotiablePrice" style="display: none; transition: ease-in-out 0.2s; flex-direction:column;">
                                         <input class="form-control" style="width:90%;" type="number"  id="NegoPrice"></div>

                                </div> -->
                                <label class="form-label" style="margin-top: 28px;"> <span id="calc_result"></span> &nbsp;&nbsp;</label>




                                <button class="btn btn-primary" type="button" style="width: 100%;margin-top: 10px;font-weight: bold;" id="addCart"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cart-plus">
                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"></path>
                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                                    </svg>&nbsp;Add Cart</button><button class="btn btn-danger openModal" type="button" data-bs-target="#clear-modal" data-bs-toggle="modal" style="width: 100%;margin-top: 10px;font-weight: bold;"><i class="icon ion-android-cancel"></i>&nbsp; Cancel</button>
                                    
                                    
                            </form>
                        </div>
                    </div>
                    
                    <div class="card shadow" style="margin-top: 20px;">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Current Sales Informations</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length-1" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                                <option value="10" selected="">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp;</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter-1"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price(RWF)</th>
                                            <th>Qty</th>
                                            <th>Total Amount(RWF)</th>
                                            <th>Benefit</th>
                                            <th>Status</th>
                                            <th style="font-size: 11px;">Sold Time</th>

                                        </tr>
                                    </thead>

                                    <tbody id="lastsells_table">
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Price</strong></td>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>Total Amount</strong></td>
                                            <td><strong>Benefit</strong></td>
                                            <td><strong>Status</strong></td>
                                            <td><strong style="font-size: 11px;">Sold Time</strong></td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                            
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info-1" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
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
    
    
    <!--Add customer on selling desk-->
    
    <div class="modal fade" role="dialog" tabindex="-1" id="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Customer</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Customer.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Full Names</label>
                        <input class="form-control" type="text" id="names">
                        <label class="form-label" style="margin-top: 12px;">Phone Number</label>
                        <input class="form-control" type="text" id="phone">
                        <label class="form-label" style="margin-top: 12px;">Address</label>
                        <input class="form-control" type="text" id="address">
                        
                        </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="addcustomer">Save</button></div>
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
    
    
    <div class="modal fade" role="dialog" tabindex="-1" id="sale_product_now">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new Product.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Name</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Price</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Benefit</label><input class="form-control" type="text"><label class="form-label" style="margin-top: 12px;">Description</label><textarea class="form-control"></textarea></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="edit_cart_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit This Sale</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp;are for Edit Sale.</p>
                    <form><label class="form-label" style="margin-top: 12px;">Quantity</label><input class="form-control" type="number"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="editCart">Edit</button></div>
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
                    <p>Are sure you need to delete this product? </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeItem"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Delete</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="clear-modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove Product</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you want to remove all product in cart?</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="clearItemBtn"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="sale-modal-after">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Sale</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to sell this products</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="confirmSale"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Apply Now</button></div>
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
                    <p>If you want to disable or enable product&nbsp; Amata click OK</p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button">Disable</button></div>
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
                    <form><label class="form-label" style="margin-top: 10px;">Quantity</label><input class="form-control" type="number"><label class="form-label" style="margin-top: 10px;">Alert Quantity</label><input class="form-control" type="number"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button">Create</button></div>
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
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Name:&nbsp;</label><label class="form-label" style="margin-top: 10px;">HP Adapter&nbsp;</label><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Price:&nbsp;&nbsp;</label><label class="form-label" style="margin-top: 10px;">25,000</label></form>
                    <form><label class="form-label text-primary" style="margin-top: 10px;font-weight: bold;">Quantity:&nbsp;</label><input class="form-control" type="number"><label class="form-label" style="margin-top: 10px;">Result information.....</label></form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button">Create</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="finishModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Report</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Sales done you can share data or print receipt
                    </p>

                    <p>
                        code: <span id="sessionid"></span>
                    </p>

                    <button id="shareReceipt" type="button" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                            <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                        </svg> Share</button>

                        <button type="button" id="printRec" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
</svg> Print </button>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="holdermodal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Holded carts</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Customer id</th>
                                <th>Total&Item</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="holdercarts">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>



    <script src="js/sellPanel.js"></script>
    <script src="js/Mytablet.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>