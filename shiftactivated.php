<?php
session_start();
?>
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
        <h1 class="text-dark mb-0" style="font-weight: bold; margin-top:10rem;">Shift Activated Successfully</h1>
        <h2 class="text-dark mb-0" style="font-weight: bold; margin-top:1rem;">For, <span id="user_names"></span></h2>
        <h2 class="text-dark mb-0" style="font-weight: bold; margin-top:1rem;">In, <span id="shiftname"></span></h2>
        <br/>
        
        <h2>Started on <span class="badge bg-primary"><?php echo $_SESSION['shift_record_started_time']; ?></span></h2>
        <!-- we need to work on differntiate sales point by adding they category -->
        
        <?php if ($_SESSION['mysalepoint'] == 24) { ?>
            <a href="resto.php" class="btn btn-success"  style="font-weight: bold; margin-top:3rem; color:white;">CONTINUE</a>
        <?php } else { ?>
            <a href="sales-panelfixed.php" class="btn btn-success"  style="font-weight: bold; margin-top:3rem; color:white;">CONTINUE</a>
        <?php } ?>
    </center>

 

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('user_names').textContent = localStorage.getItem("Names");
            document.getElementById('user_names').textContent = localStorage.getItem("Names");
            document.getElementById('shiftname').textContent = localStorage.getItem("shift_name");
            // document.getElementById('period').textContent = localStorage.getItem("shift_type");
            document.getElementById('shiftstart').textContent = localStorage.getItem("shiftstart");
            document.getElementById('shiftend').textContent = localStorage.getItem("shiftend");
        });
    </script>

</body>
</html>
