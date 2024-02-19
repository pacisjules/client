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
    <script src="js/resetpassword.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Profile</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" id="companyLogo" width="160" height="160">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Welcome</button></div>
                                </div>
                            </div>
                            
                            <!--<div class="card shadow mb-4">-->
                            <!--    <div class="card-header py-3">-->
                            <!--        <h6 class="text-primary fw-bold m-0">Projects</h6>-->
                            <!--    </div>-->
                            <!--    <div class="card-body">-->
                            <!--        <h4 class="small fw-bold">Server migration<span class="float-end">20%</span></h4>-->
                            <!--        <div class="progress progress-sm mb-3">-->
                            <!--            <div class="progress-bar bg-danger" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="visually-hidden">20%</span></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small fw-bold">Sales tracking<span class="float-end">40%</span></h4>-->
                            <!--        <div class="progress progress-sm mb-3">-->
                            <!--            <div class="progress-bar bg-warning" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"><span class="visually-hidden">40%</span></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small fw-bold">Customer Database<span class="float-end">60%</span></h4>-->
                            <!--        <div class="progress progress-sm mb-3">-->
                            <!--            <div class="progress-bar bg-primary" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="visually-hidden">60%</span></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small fw-bold">Payout Details<span class="float-end">80%</span></h4>-->
                            <!--        <div class="progress progress-sm mb-3">-->
                            <!--            <div class="progress-bar bg-info" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="visually-hidden">80%</span></div>-->
                            <!--        </div>-->
                            <!--        <h4 class="small fw-bold">Account setup<span class="float-end">Complete!</span></h4>-->
                            <!--        <div class="progress progress-sm mb-3">-->
                            <!--            <div class="progress-bar bg-success" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="visually-hidden">100%</span></div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <div class="col-lg-8">
                            <div class="row mb-3 d-none">
                                <div class="col">
                                    <div class="card text-white bg-primary shadow">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <p class="m-0">Peformance</p>
                                                    <p class="m-0"><strong>65.2%</strong></p>
                                                </div>
                                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                            </div>
                                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-white bg-success shadow">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <p class="m-0">Peformance</p>
                                                    <p class="m-0"><strong>65.2%</strong></p>
                                                </div>
                                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                            </div>
                                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">User Information</p>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username" style="color:rgb(0,26,53);"><strong>Username</strong></label><br/>
                                                        <label><span id="username">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="username" placeholder="user.name" name="username">-->
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="email" style="color:rgb(0,26,53);"><strong>Email Address</strong></label><br/>
                                                        <label ><span id="email">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="email" id="email" placeholder="user@example.com" name="email">-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="first_name" style="color:rgb(0,26,53);"><strong>Full Name</strong></label><br/>
                                                        <label><span id="full_name">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="first_name" placeholder="John" name="first_name">-->
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="last_name" style="color:rgb(0,26,53);"><strong>User Type :</strong></label><br/>
                                                        <label><span id="usertype">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="last_name" placeholder="Doe" name="last_name">-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="first_name" style="color:rgb(0,26,53);"><strong>Phone Number</strong></label><br/>
                                                        <label ><span id="phone">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="phone" name="first_name">-->
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="last_name" style="color:rgb(0,26,53);"><strong>Company Name</strong></label><br/>
                                                        <label ><span id="company">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="company"  name="last_name">-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Edit User Information</button></div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Address Information</p>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-3"><label class="form-label" for="address" style="color:rgb(0,26,53);"><strong>Address</strong></label><br/>
                                                        <label ><span id="address">
                                                            
                                                        </span></label>
                                                <!--<input class="form-control" type="text" id="address" placeholder="Sunset Blvd, 38" name="address">-->
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="city" style="color:rgb(0,26,53);"><strong>City</strong></label><br/>
                                                        <label ><span id="city">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="city" placeholder="Los Angeles" name="city">-->
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="country" style="color:rgb(0,26,53);"><strong>Country</strong></label><br/>
                                                        <label ><span id="country">
                                                            
                                                        </span></label>
                                                        <!--<input class="form-control" type="text" id="country" placeholder="USA" name="country">-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Edit Address Information</button></div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Edit Password</p>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                            <div class="text-center"><a class="small" href="reset_password.php" style=" border-radius:10px; font-size:1rem; padding:15px;text-decoration:none; background-color:#3469ad; color: white; align-item:center; text-item:center;">Reset Password</a></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="card shadow mb-5">-->
                    <!--    <div class="card-header py-3">-->
                    <!--        <p class="text-primary m-0 fw-bold">Forum Settings</p>-->
                    <!--    </div>-->
                    <!--    <div class="card-body">-->
                    <!--        <div class="row">-->
                    <!--            <div class="col-md-6">-->
                    <!--                <form>-->
                    <!--                    <div class="mb-3"><label class="form-label" for="signature"><strong>Signature</strong><br></label><textarea class="form-control" id="signature" rows="4" name="signature"></textarea></div>-->
                    <!--                    <div class="mb-3">-->
                    <!--                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1"><strong>Notify me about new replies</strong></label></div>-->
                    <!--                    </div>-->
                    <!--                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>-->
                    <!--                </form>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © SellEASEP 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
        const c_logo = localStorage.getItem("company_logo");
        const imgElement = document.getElementById("companyLogo");

         // Set the src attribute of the image
         imgElement.src = c_logo;
        
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>