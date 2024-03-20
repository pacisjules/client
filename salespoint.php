<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales Point Settings - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">

    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/settings.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="text-dark mb-4" style="font-weight: bold;font-size: 36px;">Sales Point Settings</h3>
                        
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Sales Point Information</p>
                            
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
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" id="searchsupplier"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Shop Name</th>
                                            <th>Manager Name</th>
                                            <th>Phone Number</th>
                                            <th>Company Name</th> 
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="salespoint_table">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Shop Name</strong></td>
                                            <td><strong>Manager Name</strong></td>
                                            <td><strong>Phone Number</strong></td>
                                            <td><strong>Company Name</strong></td>
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
    <div class="modal fade" role="dialog" tabindex="-1" id="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New supplier</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Here&nbsp; Add new supplier.</p>
                    <form>
                        <label class="form-label" style="margin-top: 12px;">Full Names</label>
                        <input class="form-control" type="text" id="names">
                        <label class="form-label" style="margin-top: 12px;">Phone Number</label>
                        <input class="form-control" type="text" id="phone" pattern="[0-9]{10}" title="Please enter a valid phone number (10 digits)" required>
                        
                        <label class="form-label" style="margin-top: 12px;">Address</label>
                        <input class="form-control" type="text" id="address">
                        <ul id="placeDetails"></ul>
                        </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="addsupplier">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="visitsalespoint_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:blue;font-weight:bold;">VISIT THIS SALES POINT</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color:black;font-weight:bold;font-size:15;">Are you sure to visit this Sales Point ????</p>
            
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="VisitSalesPointBtn">Confirm</button></div>
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
                    <p>Are sure you need to delete the supplier <span id="delnames"></span> </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removesupplier"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove supplier</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal_inventory">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit supplier</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="Editsupplier">Edit supplier</button></div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    
    <script>
    function displayPlaceDetails(place) {
        const placeDetailsList = document.getElementById('placeDetails');
        
        // Clear previous details
        placeDetailsList.innerHTML = '';

        // Display selected place details in the list
        const details = [
            `Name: ${place.description}`,
            `Place ID: ${place.place_id}`
            // Add more details as needed
        ];

        details.forEach(detail => {
            const listItem = document.createElement('li');
            listItem.textContent = detail;
            placeDetailsList.appendChild(listItem);
        });
    }

    function initAutocomplete() {
        const searchInput = document.getElementById('address');
        const placeDetailsList = document.getElementById('placeDetails');

        searchInput.addEventListener('input', async function () {
            const inputValue = searchInput.value;

            // Fetch predictions from the Places API Autocomplete service
            const response = await fetch(`https://maps.googleapis.com/maps/api/place/autocomplete/json?input=${inputValue}&key=AIzaSyCwX4fccYGWeaKMwKpASTrHFPs5FZ7kc7w`);
            const data = await response.json();

            // Display predictions in the console (for debugging purposes)
            console.log(data.predictions);

            // Display predictions in the list
            placeDetailsList.innerHTML = '';
            data.predictions.forEach(prediction => {
                const listItem = document.createElement('li');
                listItem.textContent = prediction.description;
                listItem.addEventListener('click', function () {
                    // When a prediction is clicked, fetch details using place_id
                    fetch(`https://maps.googleapis.com/maps/api/place/details/json?place_id=${prediction.place_id}&key=AIzaSyCwX4fccYGWeaKMwKpASTrHFPs5FZ7kc7w`)
                        .then(response => response.json())
                        .then(data => displayPlaceDetails(data.result));
                });
                placeDetailsList.appendChild(listItem);
            });
        });
    }

    initAutocomplete();
</script>

</body>

</html>