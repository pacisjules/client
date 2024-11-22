<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css">
    
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
        <!-- <label for="jobTitleFilter">Filter by Product:</label> 
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select> -->
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 12px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>PRODUCT</th>
                    <th>QTY</th>
                    <th>BY</th>
                    <th>FROM</th>
                    <th>TIME</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function() {
    
    var company = localStorage.getItem('CoID');  
    var spt = localStorage.getItem("SptID");
    var userid=localStorage.getItem("UserID");
    
    var table = $('#employeeTable').DataTable({
    "ajax": {
        "url": `functions/purchase/getsenttransfer.php?supervisor=${userid}`,
        "dataSrc": function(json) {
            // Check if the JSON response contains the expected data structure
            if (json.data && Array.isArray(json.data)) {
                return json.data;
            } else {
                console.error("Unexpected response format:", json);
                return [];
            }
        }
    },
    "columns": [
        { "data": "num" },
        { "data": "product_name",
            "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.product_name}</p>`;
            }
         },
        { "data": "quantity" },
        { "data": "requested_name",
            "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.requested_name}</p>`;
            }
         },
        { "data": "from_location",
            "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.from_location}</p>`;
            }
         },
        { "data": "created_at",
            "render": function(data, type, row, meta) {
                let date = new Date(data);
                return `<p style="text-transform:uppercase; font-weight: bold;">${date.toLocaleString('default', { month: 'long' })} ${date.getDate()}, ${date.getFullYear()}</p>`;
            }
         },
        { "data": "request_status",
            "render": function(data, type, row, meta) {
                if (row.request_status === "1") {
                    return `<p style="text-transform:uppercase; font-weight: bold; color: red;">PENDING</p>`;
                } else if (row.request_status === "2") {
                    return `<p style="text-transform:uppercase; font-weight: bold; color: green;">APPROVED</p>`;
                } else if (row.request_status === "3") {
                    return `<p style="text-transform:uppercase; font-weight: bold; color: orange;">REJECTED</p>`;
                }
                return null;
            }
         },
         
        
        
         {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    
                    if(row.request_status === "1"){
                        return `
                          <td class="d-flex justify-content-start align-items-center flex-wrap">
                           
                            <button class="btn btn-primary" type="button" style="width: 120.6875px; font-size:11px;" data-bs-target="#purchaseSalespoint_modal" data-bs-toggle="modal" onclick="getrequestinfo('${row.pid}', '${row.quantity}', '${row.product_name}', '${row.product_id}', '${row.sales_point_id}')">
                                &nbsp; <span style="font-weight:bold;">APPROVE</span>
                            </button>

                            <button class="btn btn-primary" type="button" style="background: rgb(223,139,78);font-weight: bold;border-color: rgb(255,255,255);width: 120.6875px; font-size:11px;" data-bs-target="#purchase_modal" data-bs-toggle="modal" onclick="getrequestid('${row.pid}')">
                                &nbsp; REJECT
                            </button>
                        </td>
                        `;
                    }
                    else if(row.request_status === "2"){
                        return `
                          <td class="d-flex justify-content-start align-items-center flex-wrap">
                           <p>No Action</p>
                        </td>
                        `;
                    }else{
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex justify-content-start align-items-center flex-wrap">
                           
                            <button class="btn btn-danger" type="button" style="width: 241.375px; font-size:11px;" data-bs-target="#purchaseSalespoint_modal" data-bs-toggle="modal" onclick="getrequestinfo('${row.pid}', '${row.quantity}', '${row.product_name}', '${row.product_id}', '${row.sales_point_id}')">
                                &nbsp; <span style="font-weight:bold;">RECOVER & APPROVE</span>
                            </button>
                        </td>
                    `;}
                }
            }

    ],
    
    "order": [[0, 'desc']],
    "searching": true,
    "dom": 'Bfrtip',  // Add this line to include buttons
        "buttons": [
            {
                extend:'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                exportOptions: {
                    columns: [0, 1, 2, 4]  // Specify the columns you want to export
                }
            },

            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                exportOptions: {
                    columns: [0, 1, 2, 4]  // Specify the columns you want to export
                }
            },

            {
                extend:'print',
                text: '<i class="fas fa-print"></i> Print table',
                exportOptions: {
                    columns: [0, 1, 2, 4]  // Specify the columns you want to export
                }
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
