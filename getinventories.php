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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
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
                    <th>NAME</th>
                    <th>TOTAL ITEMS</th>
                    <th>ALERT QTY</th>
                    <th>ACTION</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function() {
    
    var company_ID = localStorage.getItem('CoID');  
    var sales_point_id = localStorage.getItem("SptID");

    
    var table = $('#employeeTable').DataTable({
    "ajax": {
        "url": `functions/inventory/getproductsandinventoryspt.php?company=${company_ID}&spt=${sales_point_id}`,
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
        { "data": "name",
            "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.name}</p>`;
            }
         },
        { "data": "quantity" },
        { "data": "alert_quantity" },
        
        {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                    <div class="d-flex">

                       <button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditInventory('${row.product_id}', '${row.quantity}', '${row.alert_quantity}', '${row.name}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                       
                       <button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteInventory('${row.product_id}', '${row.name}')"><i class="fa fa-trash"></i></button>

                       <a class="nav-link active" href="purchaseshophistory.php?product_id=' .$row['product_id']. '">  <button style="background-color: #077317; color: #fff; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;margin-left:10px;font-weight:bold;font-size:10pt;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
                        </svg>&nbsp;P.HISTORY</button>
                       </a>

                    </div>
                            
 
                    `;
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
                        columns: [0, 1, 2,3]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                    exportOptions: {
                        columns: [0, 1, 2,3]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'print',
                    text: '<i class="fas fa-print"></i> Print table',
                    exportOptions: {
                        columns: [0, 1, 2, 3]  // Specify the columns you want to export
                    }
                },
     
            ],
    "initComplete": function(settings, json) {
        var jobTitles = [];
        json.data.forEach(function(employee) {
            if (!jobTitles.includes(employee.name)) {
                jobTitles.push(employee.name);
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
