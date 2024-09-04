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
        <!-- <label for="jobTitleFilter">Filter by Branch:</label>
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select> -->
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Full name</th>
                    <th>Phone number</th>
                    <th>Address</th>
                    <th>Balance (Rwf)</th>
                    <th>Due_date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        
        var table = $('#employeeTable').DataTable({
            "ajax": `functions/debts/getalldebtscompanyspt.php?spt=${localStorage.getItem("SptID")}`,
            "columns": [
                { "data": "num" },
                { "data": "names",
                 "render": function(data, type, row, meta) {
                    return `<p style="font-size: 15px; font-weight: bold; text-transform: uppercase;">${row.names}</p>`
                 }
                 },
                { "data": "phone" },
                { "data": "address" },
                { "data": "Amount",
                 "render": function(data, type, row, meta) {
                    if(row.Amount > 0){
                        return `<span class="badge text-bg-danger"  style="color: white; width: 100%; padding: 5px; font-size: 15px">${Intl.NumberFormat('en-US').format(data)}</span>`;
                    }else{
                        return `<span class="badge text-bg-success"  style="color: white; width: 100%; padding: 5px; font-size: 15px">${Intl.NumberFormat('en-US').format(data)}</span>`;
                    }
                    
                 },
                },
                { "data": "due_date" },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        
                        return `<a class="nav-link active" href="debtdetails?customer_id=${row.customer_id}"><button class="btn btn-dark"  rounded-circle"  type="button"><i class="fas fa-list" style="font-size:20px; color: white; margin-top:3px;"></i></button></a>`;
            }
        },
               
            ],
            "order": [[4, 'desc']],
            "searching": true,
            "dom": 'Bfrtip',  // Add this line to include buttons
        "buttons": [
            {
                extend:'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                exportOptions: {
                    columns: [0, 1, 2, 4,5]  // Specify the columns you want to export
                }
            },

            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                exportOptions: {
                    columns: [0, 1, 2, 4,5]  // Specify the columns you want to export
                }
            },

            {
                extend:'print',
                text: '<i class="fas fa-print"></i> Print table',
                exportOptions: {
                    columns: [0, 1, 2, 4,5]  // Specify the columns you want to export
                }
            },
 
        ],

            "initComplete": function(settings, json) {
                var jobTitles = [];
                json.data.forEach(function(employee) {
                    if (!jobTitles.includes(employee.names)) {
                        jobTitles.push(employee.names);
                    }
                });
                jobTitles.sort();
                jobTitles.forEach(function(title) {
                    $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
                });
            }
        });

        $('#jobTitleFilter').on('change', function() {
            var selectedJobTitle = $(this).val();
            table.column(3).search(selectedJobTitle).draw();
        });
    });
    </script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
