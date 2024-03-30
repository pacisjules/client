<?php
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];

    if (empty($user_id)) {
        echo "";
    }else{
        header("Location:/client/");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="js/login.js"></script>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10" style="margin-top: 40px;">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0" >
                        <div class="row" >
                            <div class="col-lg-6 d-none d-lg-flex" >
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/easter.jpg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4" style="font-weight: bold;font-size: 34.898px;">Welcome Back!</h4>
                                        <h4 class="text-dark mb-4" style="font-size: 17.898px;">SELLEASEP Software.</h4>
                                    </div>
                                    <form class="user">
                                        <div class="mb-3"><input class="form-control form-control-user" type="text"   placeholder="Enter username..." name="username" id="user"></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password"  placeholder="Password" name="password" id="pwd"></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label></div>
                                            </div>
                                        </div><button class="btn btn-primary d-block btn-user w-100" type="button" id="lgnbtn">Login</button>
                                    </form>
                                    <div class="text-center"><a class="small" href="reset_password.php" style="padding-top: 12px;margin-top: 3px;">Forgot Password?</a></div>
                                    <div class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Toast Container -->
<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
  <!-- Bootstrap Toast -->
  <div id="myToast" class="toast text-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
    <div class="toast-header">
      <strong class="me-auto">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    <i class="bi bi-exclamation-triangle-fill"></i> Incorrect Username or Password !
    </div>
  </div>
</div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>