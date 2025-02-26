<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dynamic DataTable with PHP and MySQL</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="js/paymentsession.js"></script>
    <!-- <script src="js/sales.js"></script> -->
    <!-- Buttons extension JS -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>








<style>
/* Style all DataTable buttons */
    .dt-button {
        background-color: #4CAF50; /* Green background */
        color: white; /* White text */
        border: none; /* Remove borders */
        padding: 10px 20px; /* Add padding */
        cursor: pointer; /* Pointer cursor on hover */
        margin-right: 5px; /* Space between buttons */
        border-radius: 5px; /* Rounded corners */
    }

    /* Style buttons on hover */
    .dt-button:hover {
        background-color: black;
         /* Darker green on hover */
    }

    /* Customize specific buttons by type */
    .buttons-excel {
        background-color: green; /* Blue background */
    }

    .buttons-pdf {
        background-color: #dc3545; /* Red background */
    }

    .buttons-print {
        background-color: blue; /* Red background */
    }

    /* Adjust button text size */
    .dt-button {
        font-size: 14px; /* Font size */
        font-weight: bold; /* Bold font */
    }


</style>

</head>
<body>
    <div>
    <div class="row">
            <div class="col-md-4">
            <a class="nav-link active" href="salesgrouped">  <button  type="button" style="font-size: 15px;font-weight: bold; background-color:#040536; border-radius:10px; color:white; margin-bottom:30px;"><i class="fas fa-arrow-left"></i>
            &nbsp;Back</button></a> 
            </div>
            <div class="col-md-4 text-left" style="margin-left: 1rem;">
                <span style="font-size: 20px;">TOTAL AMOUNT:</span>
                <span class="badge text-bg-primary" style="font-size: 17px;" id="sum_total"></span>
            </div>
        </div>
        <br/>

     <!-- Date Inputs: Select Date and From/To Date Range -->
     

        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
        </table>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
