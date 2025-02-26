<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dynamic DataTable with PHP and MySQL</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="js/reportupdatesales.js"></script>
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
            <div class="col-md-4 text-left" style="margin-left: 1rem;">
                <span style="font-size: 20px;">TOTAL PAID:</span>
                <span class="badge text-bg-primary" style="font-size: 17px;" id="sum_paid"></span>
            </div>
            <div class="col-md-4 text-left" style="margin-left: 1rem;">
                <span style="font-size: 20px;">TOTAL BALANCE:</span>
                <span class="badge text-bg-primary" style="font-size: 17px;" id="sum_balance"></span>
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
                <input type="date" id="fromDate" class="form-control" style="width: 150px;margin-left: 3rem;">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div>
                    <label for="toDate" style="margin-left: -7rem;">To:</label>
                    <input type="date" id="toDate" class="form-control" style="width: 150px; margin-left: -7rem;">
                </div>
                <div class="ms-2">
                    <button id="fetchReportBtn" class="btn btn-primary" style="width: 150px; margin-left: 1.5rem">Fetch Report</button>
                </div>
            </div>
        </div>


        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Client Name</th>
                    <th>Phone Number</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                    <th>Done By</th>
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
