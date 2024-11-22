<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Activate Shift - SellEASEP</title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
</head>
<body>
    <center>
        <h1 class="text-dark mb-0" style="font-weight: bold; margin-top:10rem;">Shift Activation Panel</h1>
        <h2 class="text-dark mb-0" style="font-weight: bold; margin-top:1rem;">Welcome, <span id="user_names"></span></h2>
        <br/>
        <div style="width: 30rem; height: 10rem; font-weight: bold; border: 1px solid green; padding: 2rem; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
        <p>Shift: <span id="shiftname"></span></p>
        <!-- <p>Period: <span id="period"></span></p> -->
        <p>Start on  <span id="shiftstart" class="badge bg-primary"></span> End on  <span id="shiftend" class="badge bg-success"></span></p>
        </div>
        <button class="btn btn-success"  style="font-weight: bold; margin-top:3rem; color:white;" data-bs-target="#add_customer_modal" data-bs-toggle="modal" >Activate Shift</button>

        <a class="btn btn-danger" href="logout.php"  style="font-weight: bold; margin-top:3rem; color:white;">Cancel</a>
    </center>

    <div class="modal fade" role="dialog" tabindex="-1" id="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-exclamation-triangle" style="color: orangered;"></i> Warning</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to activate this shift?</p>
                    <p><i class="fa fa-circle" style="color: green;"></i> Press Yes to Activate , <i class="fa fa-circle" style="color: red;"></i> Press No to Cancel</p>
                    
                </div>
                <div class="modal-footer"> 
                <form action="activate_shift.php" method="POST">    
                <button class="btn btn-success"  type="submit" style="color:white; " id="activateShiftButton">YES</button> 
                </form>
                    
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">NO</button></div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('user_names').textContent = localStorage.getItem("Names");
            document.getElementById('shiftname').textContent = localStorage.getItem("shift_name");
            // document.getElementById('period').textContent = localStorage.getItem("shift_type");
            document.getElementById('shiftstart').textContent = localStorage.getItem("shiftstart");
            document.getElementById('shiftend').textContent = localStorage.getItem("shiftend");
        });
    </script>





</body>
</html>
