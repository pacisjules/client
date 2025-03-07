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
                    <th>IMAGE</th>
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>BENEFIT</th>
                    <th>QTY</th>
                    <th>ACTION</th>
                    
                  
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function() {
    
    var company = localStorage.getItem('CoID');  
    var spt = localStorage.getItem("SptID");

    
    var table = $('#employeeTable').DataTable({
    "ajax": {
        "url": `functions/product/getallproductsbysptdynamic.php?company=${company}&spt=${spt}`,
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
        { 
    "data": "image",
    "render": function(data, type, row, meta) {
        // Check if 'eid' exists for the image
        let imageUrl;
        if (row.eid) {
            imageUrl = row.eimage; // If 'eid' exists, use the external image
        } else if (row.image) {
            imageUrl = `uploads/${row.image}`; // Otherwise, use the local uploaded image
        } else {
            imageUrl = 'uploads/noimage.jpg'; // Default image if none exist
        }

        return `<img src="${imageUrl}" alt="Product Image" width="50" height="50">`;
       }
     },
        { "data": "name",
            "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.name}</p>`;
            }
         },
        { "data": "price" },
        { "data": "benefit" },
        { "data": "invquantity" },
        {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex justify-content-start align-items-center flex-wrap">
                            <button class="btn btn-success" type="button" data-bs-target="#edit_product_modal" data-bs-toggle="modal" onclick="setUpdates('${row.name}', '${row.price}', '${row.benefit}', '${row.description}', '${row.pid}')">
                                <i class="fa fa-edit" style="color: rgb(255,255,255);"></i>
                            </button>
                            <button class="btn btn-danger" type="button"  data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="RemoveProductID('${row.pid}')">
                                <i class="fa fa-trash"></i>
                            </button>
                            
                      <a href="updateimageblog.php?pid=${row.pid}&name=${row.name}">   <button class="btn btn-primary" type="button" style="background: #ebdbff;font-weight: bold;border-color: rgb(255,255,255);width: 120.6875px; font-size:11px;" >
                                    <svg width="20px" height="20px" viewBox="0 0 1024 1024" class="icon" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M736.68 435.86a173.773 173.773 0 0 1 172.042 172.038c0.578 44.907-18.093 87.822-48.461 119.698-32.761 34.387-76.991 51.744-123.581 52.343-68.202 0.876-68.284 106.718 0 105.841 152.654-1.964 275.918-125.229 277.883-277.883 1.964-152.664-128.188-275.956-277.883-277.879-68.284-0.878-68.202 104.965 0 105.842zM285.262 779.307A173.773 173.773 0 0 1 113.22 607.266c-0.577-44.909 18.09-87.823 48.461-119.705 32.759-34.386 76.988-51.737 123.58-52.337 68.2-0.877 68.284-106.721 0-105.842C132.605 331.344 9.341 454.607 7.379 607.266 5.417 759.929 135.565 883.225 285.262 885.148c68.284 0.876 68.2-104.965 0-105.841z" fill="#4A5699"/>
                                        <path d="M339.68 384.204a173.762 173.762 0 0 1 172.037-172.038c44.908-0.577 87.822 18.092 119.698 48.462 34.388 32.759 51.743 76.985 52.343 123.576 0.877 68.199 106.72 68.284 105.843 0-1.964-152.653-125.231-275.917-277.884-277.879-152.664-1.962-275.954 128.182-277.878 277.879-0.88 68.284 104.964 68.199 105.841 0z" fill="#C45FA0"/>
                                        <path d="M545.039 473.078c16.542 16.542 16.542 43.356 0 59.896l-122.89 122.895c-16.542 16.538-43.357 16.538-59.896 0-16.542-16.546-16.542-43.362 0-59.899l122.892-122.892c16.538-16.542 43.356-16.542 59.894 0z" fill="#DAE3E3"/>
                                        <path d="M874.665 182.506c0 28.832-23.376 52.208-52.208 52.208-28.835 0-52.209-23.376-52.209-52.208s23.374-52.208 52.209-52.208c28.832 0 52.208 23.376 52.208 52.208zM429.287 419.957c0 47.987-38.924 86.913-86.913 86.913s-86.913-38.926-86.913-86.913 38.924-86.913 86.913-86.913 86.913 38.926 86.913 86.913zM729.434 568.839l-132.602-132.605c-13.659-13.659-35.773-13.659-49.433 0l-199.603 199.603c-13.659 13.659-13.659 35.773 0 49.433l132.605 132.603c13.659 13.659 35.773 13.659 49.433 0l199.603-199.603c13.656-13.659 13.656-35.773 0-49.431z" fill="#4A5699"/>
                                    </svg>&nbsp; <span style="color:black;font-weight:bold;">IMAGE</span>
                                </button></a>
                        </td>
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
