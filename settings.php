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
                                                        <div class="mb-3"><label class="text-primary fw-bold" for="email" style="font-size: 18px; font-weight:700;" >All user Permissions</label><br/>
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

                    <div class="row mb-1">
                        
                        <div class="col-lg-12">
                            
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">My users</p>
                                        </div>
                                        
                                        
                                        <div class="card-body">
                                            
                                                <div class="row">
                                                    <div class="col" >
                                                        <div class="mb-3">
                                                        <div class="mb-3">
                                                    </div>

                                                        <div class="mb-3"></div>
                                               
                                                    </div>



                                                    <div class="col" >
                                                        <div class="mb-3"><label class="text-primary fw-bold" for="email" style="font-size: 18px; font-weight:700;" >All users</label><br/>
                                                        <table class="table table-striped">
                                                        <thead>
                                                                <tr>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Names</th>
                                                                <th scope="col">Username</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col">Phone</th>
                                                                <th scope="col">User category</th>
                                                                <th scope="col">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="users_table">
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
  <div id="myToastcatedelete" class="toast text-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Category has been Deleted !
    </div>
  </div>
</div>

<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToastcateedit" class="toast text-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Category has been Updated !
    </div>
  </div>
</div>





<div class="modal fade" role="dialog" tabindex="-1" id="modal_category">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit Category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <form>

                        <label class="form-label" style="margin-top: 10px;">Category Name</label>
                        <input class="form-control" type="text" id="category_name"> 
                        <label class="form-label" style="margin-top: 10px;">Category Status</label>
                        <input class="form-control" type="number" id="statuscategory"> 

                        

                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditCategory">Edit Category</button></div>
            </div>
        </div>
    </div>


 <div class="modal fade" role="dialog" tabindex="-1" id="categorydelete-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove This category</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this category </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeCategory"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove category</button></div>
            </div>
        </div>
    </div>








<div class="modal fade" role="dialog" tabindex="-1" id="modal_permission">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit Permission</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <form>

                        <label class="form-label" style="margin-top: 10px;">Permission Name</label>
                        <input class="form-control" type="text" id="namepermi"> 

                        <label class="form-label" style="margin-top: 10px;">User Category</label>
                        <select class="form-control" id="cat_id"></select>
                        <label class="form-label" style="margin-top: 10px;">Page Name</label>
                        <select class="form-control" id="page_id"></select>

                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditPermission">Edit Permission</button></div>
            </div>
        </div>
    </div>


  <div class="modal fade" role="dialog" tabindex="-1" id="permissiondelete-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove This Permission</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete this Permission </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removePermission"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove Permission</button></div>
            </div>
        </div>
    </div>





<div class="modal fade" role="dialog" tabindex="-1" id="modal_user">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Edit User</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <form>
                        <label class="form-label" style="margin-top: 10px;">First name</label>
                        <input class="form-control" type="text" id="first_name">

                        <label class="form-label" style="margin-top: 10px;">Last name</label>
                        <input class="form-control" type="text" id="last_name">

                        <label class="form-label" style="margin-top: 10px;">Username</label>
                        <input class="form-control" type="text" id="username">

                        <label class="form-label" style="margin-top: 10px;">Email</label>
                        <input class="form-control" type="text" id="email"> 

                        <label class="form-label" style="margin-top: 10px;">Phone</label>
                        <input class="form-control" type="text" id="phone"> 

                        <label class="form-label" style="margin-top: 10px;">Category</label>
                        <select class="form-control" id="user_category"></select>
                        <label class="form-label" style="margin-top: 10px;">User Shift</label>
                        <select class="form-control" id="user_shift"></select>

                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button" id="EditUser">Edit User</button></div>
            </div>
        </div>
    </div>



    <div class="modal fade" role="dialog" tabindex="-1" id="user-delete-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Remove This User</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are sure you need to delete the user <span id="delnames"></span> </p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="button" id="removeCustomer"><i class="fa fa-trash" style="padding-right: 0px;margin-right: 11px;"></i>Remove Customer</button></div>
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





<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToastPermdelete" class="toast text-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Permission has been Deleted!!!
    </div>
  </div>
</div>

<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToastPermedit" class="toast text-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Permission has been Updated!!!
    </div>
  </div>
</div>




</body>

</html>