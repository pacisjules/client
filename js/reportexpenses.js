$(document).ready(function() {

    View_DayRecord();

    $('#reportDate').on('change', function() {
        var selectedDate = $(this).val();
        console.log(selectedDate);

    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/expenses/getsdailyexpensessptpick.php?date=${selectedDate}&spt=${spt}`,
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
            { "data": "name",
                    "render": function(data, type, row, meta) {
                    return `<p style="text-transform:uppercase; font-weight: bold;">${row.name}</p>`;
                }
                 },
    
            { "data": "description" },
            { "data": "amount" },
            { "data": "dependon" },
            { "data": "salespoint" },
            { "data": "expense_name" },
            { "data": "payment" },
            { "data": "doneby" },
            { "data": "created_date" },
            {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex flex-row justify-content-start align-items-center">
                      <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                      <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-trash"></i></button>
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
                        columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                    exportOptions: {
                        columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'print',
                    text: '<i class="fas fa-print"></i> Print table',
                    exportOptions: {
                        columns: [0, 1, 2, 3,4, 5, 6, 7, 8,9]  // Specify the columns you want to export
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
            $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
            
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

       
     
    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/expenses/getsdailyexpensessptfromto?from=${fromDate}&to=${toDate}&spt=${spt}`,
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
            { "data": "name",
                    "render": function(data, type, row, meta) {
                    return `<p style="text-transform:uppercase; font-weight: bold;">${row.name}</p>`;
                }
                 },
    
            { "data": "description" },
            { "data": "amount" },
            { "data": "dependon" },
            { "data": "salespoint" },
            { "data": "expense_name" },
            { "data": "payment" },
            { "data": "doneby" },
            { "data": "created_date" },
            {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex flex-row justify-content-start align-items-center">
                      <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                      <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-trash"></i></button>
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
                        columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                    exportOptions: {
                        columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                    }
                },
    
                {
                    extend:'print',
                    text: '<i class="fas fa-print"></i> Print table',
                    exportOptions: {
                        columns: [0, 1, 2, 3,4, 5, 6, 7, 8,9]  // Specify the columns you want to export
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
            $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
        },
    });

    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        $('#employeeTable').DataTable().column(1).search(selectedJobTitle).draw();
    });


    });


    
});




function View_DayRecord() {
    

     
    var spt = localStorage.getItem("SptID");

    
    var table = $('#employeeTable').DataTable({
    "ajax": {
        "url": `functions/expenses/getsdailyexpensesspt.php?spt=${spt}`,
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

        { "data": "description" },
        { "data": "amount" },
        { "data": "dependon" },
        { "data": "salespoint" },
        { "data": "expense_name" },
        { "data": "payment" },
        { "data": "doneby" },
        { "data": "created_date" },
        {
            "data": null, // Add action column
            "render": function(data, type, row, meta) {
                // Return HTML for action buttons
                return `
                    <td class="d-flex flex-row justify-content-start align-items-center">
                  <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                  <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${row.id}><i class="fa fa-trash"></i></button>
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
                    columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                }
            },

            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to Pdf',
                exportOptions: {
                    columns: [0, 1, 2,3, 4, 5, 6, 7, 8,9]  // Specify the columns you want to export
                }
            },

            {
                extend:'print',
                text: '<i class="fas fa-print"></i> Print table',
                exportOptions: {
                    columns: [0, 1, 2, 3,4, 5, 6, 7, 8,9]  // Specify the columns you want to export
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
        $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
        
        
    },
});



    $('#jobTitleFilter').on('change', function() {
        var selectedJobTitle = $(this).val();
        table.column(1).search(selectedJobTitle).draw();
    });

}



