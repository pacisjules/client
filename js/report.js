$(document).ready(function() {

    View_DayRecord();

    $('#reportDate').on('change', function() {
        var selectedDate = $(this).val();
        console.log(selectedDate);


    var company = localStorage.getItem('CoID');  
    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/report/dailysalesreportpick.php?date=${selectedDate}&company=${company}&spt=${spt}`,
            "dataSrc": function(json) {
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
            { "data": "Product_Name",
                "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.Product_Name}</p>`;
            }
             },
            { "data": "QTYsale" },
            { "data": "productsale" },
            { "data": "productPROFIT" },
            { "data": "productPurchase" },
            { "data": "QTYPurchase" },
        ],
        "order": [[0, 'desc']],
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
                if (!jobTitles.includes(employee.Product_Name)) {
                    jobTitles.push(employee.Product_Name);
                }
            });
            jobTitles.sort();
            $('#jobTitleFilter').html('<option selected value="">All</option>');
            jobTitles.forEach(function(title) {
                $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
            });
            $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
            $('#sum_benefit').html(`${Intl.NumberFormat('en-US').format(json.sumbenefit)} Rwf`);
            $('#sum_purchase').html(`${Intl.NumberFormat('en-US').format(json.sumtotal_purchase)} Rwf`);
        },
    });

    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        $('#employeeTable').DataTable().column(1).search(selectedJobTitle).draw();
    });



    });




    $('#fetchReportBtn').on('click', function() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

       
        var company = localStorage.getItem('CoID');  
    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/report/monthlysalesreport.php?from=${fromDate}&to=${toDate}&company=${company}&spt=${spt}`,
            "dataSrc": function(json) {
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
            { "data": "Product_Name",
                "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.Product_Name}</p>`;
            }
             },
            { "data": "QTYsale" },
            { "data": "productsale" },
            { "data": "productPROFIT" },
            { "data": "productPurchase" },
            { "data": "QTYPurchase" },
        ],
        "order": [[0, 'desc']],
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
                if (!jobTitles.includes(employee.Product_Name)) {
                    jobTitles.push(employee.Product_Name);
                }
            });
            jobTitles.sort();
            $('#jobTitleFilter').html('<option selected value="">All</option>');
            jobTitles.forEach(function(title) {
                $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
            });
            $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
            $('#sum_benefit').html(`${Intl.NumberFormat('en-US').format(json.sumbenefit)} Rwf`);
            $('#sum_purchase').html(`${Intl.NumberFormat('en-US').format(json.sumtotal_purchase)} Rwf`);
        },
    });

    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        $('#employeeTable').DataTable().column(1).search(selectedJobTitle).draw();
    });


    });


    
});




function View_DayRecord() {

    
    var company = localStorage.getItem('CoID');  
    var spt = localStorage.getItem("SptID");

    
    var table = $('#employeeTable').DataTable({
    "ajax": {
        "url": `functions/report/dailysalesreport.php?company=${company}&spt=${spt}`,
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
        { "data": "Product_Name",
                "render": function(data, type, row, meta) {
                return `<p style="text-transform:uppercase; font-weight: bold;">${row.Product_Name}</p>`;
            }
             },

        { "data": "QTYsale" },
        { "data": "productsale" },
        { "data": "productPROFIT" },
        { "data": "productPurchase" },
        { "data": "QTYPurchase" },
        
    ],
    
    "order": [[0, 'desc']],
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
            if (!jobTitles.includes(employee.Product_Name)) {
                jobTitles.push(employee.Product_Name);
            }
        });
        jobTitles.sort();
        jobTitles.forEach(function(title) {
            $('#jobTitleFilter').append('<option value="' + title + '">' + title + '</option>');
        });
        $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
        $('#sum_benefit').html(`${Intl.NumberFormat('en-US').format(json.sumbenefit)} Rwf`);
        $('#sum_purchase').html(`${Intl.NumberFormat('en-US').format(json.sumtotal_purchase)} Rwf`);
        
    },
});



    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        table.column(1).search(selectedJobTitle).draw();
    });

}



