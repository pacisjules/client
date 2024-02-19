<?php
include('getuser.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
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
                    <h3 class="text-dark mb-4">Settings</h3>
                    
                    <div class="row mb-1">
                        
                        <div class="col-lg-12">
                            
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">User management</p>
                                        </div>
                                        
                                        
                                        <div class="card-body">
                                            
                                                <div class="row">
                                                    <div class="col" >
                                                    
                                                        <h3 class="text-primary fw-bold" style="font-size: 18px; font-weight:700;">Add new user category</h3>
                                                        <div class="mb-3"><label class="form-label" for="category" style="color:rgb(0,26,53);"><strong>Category</strong></label><br/>
                                                        <input class="form-control"  type="text" id="category" placeholder="Enter user category name" name="category">
                                                        </div>

                                                        <div class="mb-3"><button class="btn btn-primary btn-sm" id="addCategory">Add Category</button></div>
                                                    
                                                    </div>
                                                </div>

                                                <div class="row">
                    <div class="col">
                    <div class="mb-3"><label class="text-primary fw-bold" for="email" style="font-size: 18px; font-weight:700;" >All user categories</label><br/>
                                                        <table class="table table-striped">
                                                        <thead>
                                                                <tr>
                                                                
                                                                <th scope="col">Category</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            
                                                            
                                                            
                                                            <tbody id="category_tbl">
                                                               
                                                            </tbody>


                                                            </table>
                                                        </div>
                    </div>
                                                </div>
                                        </div>
                                    </div>



                                    
                                    
                                    
                                  
                                   
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-1">
                        
                        <div class="col-lg-12">
                            
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">User permissions</p>
                                        </div>
                                        
                                        
                                        <div class="card-body">
                                            
                                                <div class="row">
                                                    <div class="col" >
                                                   
                                                        <h3 class="text-primary fw-bold" style="font-size: 18px; font-weight:700;">Add new permission</h3>
                                                        <div class="mb-3"><label class="form-label" for="username" style="color:rgb(0,26,53);"><strong>Permission name</strong></label><br/>
                                                        <input class="form-control"  type="text" id="permission" placeholder="Enter user permission name" name="category">
                                                        
                                                        <div class="mb-3"><label class="form-label" for="username" style="color:rgb(0,26,53);"><strong>Select category</strong></label><br/>
                                                        <select class="form-control" id="categories">
                                                          

                                                        </select>

                                                        <div class="mb-3"><label class="form-label" for="username" style="color:rgb(0,26,53);"><strong>Select page</strong></label><br/>
                                                        <select class="form-control" id="pages">
                                                        
                                                        </select>
                                                    
                                                    </div>

                                                        <div class="mb-3"><button class="btn btn-primary btn-sm" id="AddPermission">Set user permission</button></div>
                                               
                                                    </div>



                                                    <div class="col" >
                                                        <div class="mb-3"><label class="text-primary fw-bold" for="email" style="font-size: 18px; font-weight:700;" >All user categories</label><br/>
                                                        <table class="table table-striped">
                                                        <thead>
                                                                <tr>
                                                                
                                                                <th scope="col">Permission</th>
                                                                <th scope="col">category</th>
                                                                <th scope="col">Page</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="permission_table">
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>



                                    
                                    
                                    
                                  
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP <span id="year_now"></span></span></div>
                </div>
            </footer>

        
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
        const c_logo = localStorage.getItem("company_logo");
        const imgElement = document.getElementById("companyLogo");
        var currentYear = new Date().getFullYear();
        document.getElementById('year_now').textContent = currentYear;


         // Set the src attribute of the image
         imgElement.src = c_logo;
        
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>



        <!-- Bootstrap Toast Container -->
<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToast" class="toast text-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Category has been saved !
    </div>
  </div>
</div>


<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToastPerm" class="toast text-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Permission has been added !
    </div>
  </div>
</div>
</body>

</html>