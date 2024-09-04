<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dynamic DataTable with PHP and MySQL</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

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
        <label for="jobTitleFilter">Filter by Product:</label> <span style="font-size: 20px;margin-left:12rem;"> Total Sales Closing:</span><span class="badge text-bg-primary" style="margin-left:1rem;font-size:20px;"  id="sum_total"></span>
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select>
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 15px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Open</th>
                    <th>Entry</th>
                    <th>Total</th>
                    <th>Sold</th>
                    <th>Unit price</th>
                    <th>Total Amount</th>
                    <th>Closing qty</th>
                  
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function() {
    var shift_id = getParameterByName('shift_id'); 
    var from = getParameterByName('from'); 
    var to = getParameterByName('to');  
    var spt = localStorage.getItem("SptID");

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    var table = $('#employeeTable').DataTable({
    "ajax": `functions/purchase/getalldaycombinationReportSHIFT.php?startdate=${from}&enddate=${to}&spt=${spt}`,
    "columns": [
        { "data": "num" },
        { "data": "product_name" },
        { "data": "open" },
        { "data": "entry" },
        { "data": "total"},
        { "data": "sold" },
        { "data": function(data) { 
            var unitPrice = parseFloat(data.unit_price) || 0;
            return `<span class="badge text-bg-primary">${Intl.NumberFormat('en-US').format(unitPrice)} Rwf</span>`; 
        }},
        { "data": function(data) { 
            var total_amount = parseFloat(data.total_amount) || 0;
            return `<span class="badge text-bg-primary">${Intl.NumberFormat('en-US').format(total_amount)} Rwf</span>`; 
        }},
        { "data": "closing" },
    ],
    "order": [[1, 'asc']],
    "searching": true,
    "dom": 'Bfrtip',  // Add this line to include buttons
        "buttons": [
            {
                extend:'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
            },

            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
            },

            {
                extend:'print',
                text: '<i class="fas fa-print"></i> Print table',
            },
 
        ],

    "initComplete": function(settings, json) {
        var jobTitles = [];
        json.data.forEach(function(employee) {
            if (!jobTitles.includes(employee.product_name)) {
                jobTitles.push(employee.product_name);
            }
        });
        jobTitles.sort();
        jobTitles.forEach(function(title) {
            $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
        });
        $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.total)} Rwf`);
    },
});



    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        table.column(1).search(selectedJobTitle).draw();
    });
});
</script>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
