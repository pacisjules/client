<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dynamic DataTable with PHP and MySQL</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="js/report.js"></script>


    <!-- Buttons extension JS -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <style>
        /* Custom hover effect for the Fetch Report button */
        #fetchReportBtn {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #fetchReportBtn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

    
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
            <!-- <div class="col-md-4">
                <label for="jobTitleFilter" style="margin-left: 1rem;">Filter by Product:</label>
                <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width: 220px; margin-left: 1rem;">
                    <option selected value="">All</option>
                </select>
            </div> -->
            <div class="col-md-4 text-left" style="margin-left: 1rem;">
                <span style="font-size: 20px;">TOTAL SALES:</span>
                <span class="badge text-bg-primary" style="font-size: 17px;" id="sum_total"></span>
            </div>
            <div class="col-md-4 text-left" style="margin-left: 1.2rem;">
                <span style="font-size: 20px;">GROSS PROFIT:</span>
                <span class="badge text-bg-success" style="font-size: 17px;" id="sum_benefit"></span>
            </div>
            <div class="col-md-4 text-left" style="margin-left: 1.2rem;">
                <span style="font-size: 20px;">PURCHASE TOTAL:</span>
                <span class="badge text-bg-success" style="font-size: 17px;" id="sum_purchase"></span>
            </div>
        </div>
        <br/>

     <!-- Date Inputs: Select Date and From/To Date Range -->
     <div class="row">
            <!-- Single Date Picker -->
            <div class="col-md-4">
                <label for="reportDate" style="margin-left: 1rem;">Select Date:</label>
                <input type="date" id="reportDate" class="form-control" style="width: 220px;margin-left: 1rem;">
            </div>

            <!-- From/To Date Range Pickers with Inline Fetch Button -->
            <div class="col-md-4">
                <label for="fromDate" style="margin-left: 3rem;">From:</label>
                <input type="date" id="fromDate" class="form-control" style="width: 220px;margin-left: 3rem;">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div>
                    <label for="toDate" style="margin-left: -7rem;">To:</label>
                    <input type="date" id="toDate" class="form-control" style="width: 220px; margin-left: -7rem;">
                </div>
                <div class="ms-2">
                    <button id="fetchReportBtn" class="btn btn-primary" style="width: 220px; margin-left: 1.5rem">Fetch Report</button>
                </div>
            </div>
        </div>


        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 15px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>PRODUCT</th>
                    <th>SOLD QTY</th>
                    <th>TOTAL AMOUNT </th>
                    <th>TOTAL BENEFIT</th>
                    <th>TOTAL PURCHASE </th>
                    <th>PURCHASE QTY</th>
                      
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
