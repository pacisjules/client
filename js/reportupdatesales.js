$(document).ready(function() {

    View_DayRecord();




    $('#reportDate').on('change', function() {
        var selectedDate = $(this).val();
        console.log(selectedDate);

    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/sales/getsdailysalesupdatesptpick.php?date=${selectedDate}&spt=${spt}`,
           "dataSrc": function(json) {
                if (json.data && Array.isArray(json.data)) {
                    // Populate sumtotal at the bottom
                    $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
                    $('#sum_paid').html(`${Intl.NumberFormat('en-US').format(json.sumpaid)} Rwf`);
                    $('#sum_balance').html(`${Intl.NumberFormat('en-US').format(json.sumbalance)} Rwf`);
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
                "data": "customer_name",
                "render": function(data, type, row, meta) {
                    return `<p style="text-transform:uppercase; font-weight: bold;">${row.customer_name}</p>`;
                }
            },
            { "data": "customer_phone" },
            { "data": "total_amount" },
            { "data": "totpaid" },
            { "data": "balance",
            "render": function(data, type, row, meta) {
                var total_amount = row.total_amount;
                var totpaid = row.totpaid;
                var balance = total_amount - totpaid;
                return balance;
            }

             },
            { "data": "doneby" },  // Ensure 'doneby' is part of the response
            { 
                "data": "created_time",
                "render": function(data, type, row, meta) {
                    // Format the date from '2025-02-10 00:00:00' to 'February, 10 . 2025'
                    var date = new Date(row.created_time);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var formattedDate = date.toLocaleDateString('en-US', options);
                    var [month, day, year] = formattedDate.split(' ');
                    return `${month}, ${day} . ${year}`;
                }
            },
            {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex flex-row justify-content-start align-items-center">
                        <a class="btn btn-primary" type="button" href="paymentbysession.php?session_id=${row.sess_id}" ><i class="fas fa-money" style="font-size:20px; color: white; margin-top:3px;"></i>Payments</a>
                      <a class="btn btn-dark" type="button" href="viewdetailsales.php?session_id=${row.sess_id}" ><i class="fas fa-list" style="font-size:20px; color: white; margin-top:3px;"></i></a>
                     
                    </td>
    
                    `;
                }
            }
          
        ],
        "order": [[0, 'desc']],
        "searching": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print Table',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ],
        "initComplete": function(settings, json) {
            // Job title filter (check if needed for your use case)
            var jobTitles = [];
            json.data.forEach(function(employee) {
                if (!jobTitles.includes(employee.customer_name)) {
                    jobTitles.push(employee.customer_name);
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
        table.column(1).search(selectedJobTitle).draw();
    });



    });




    $('#fetchReportBtn').on('click', function() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

       
     
    var spt = localStorage.getItem("SptID");


    $('#employeeTable').DataTable({
        "destroy": true, // Allow reinitialization of the table
        "ajax": {
            "url": `functions/sales/getsdailyupdatedsalesfromto.php?from=${fromDate}&to=${toDate}&spt=${spt}`,
            "dataSrc": function(json) {
                if (json.data && Array.isArray(json.data)) {
                    // Populate sumtotal at the bottom
                    $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
                    $('#sum_paid').html(`${Intl.NumberFormat('en-US').format(json.sumpaid)} Rwf`);
                    $('#sum_balance').html(`${Intl.NumberFormat('en-US').format(json.sumbalance)} Rwf`);
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
                "data": "customer_name",
                "render": function(data, type, row, meta) {
                    return `<p style="text-transform:uppercase; font-weight: bold;">${row.customer_name}</p>`;
                }
            },
            { "data": "customer_phone" },
            { "data": "total_amount" },
            { "data": "totpaid" },
            { "data": "balance",
                "render": function(data, type, row, meta) {
                    var total_amount = row.total_amount;
                    var totpaid = row.totpaid;
                    var balance = total_amount - totpaid;
                    return balance;
                }
    
            },
            { "data": "doneby" },  // Ensure 'doneby' is part of the response
            { 
                "data": "created_time",
                "render": function(data, type, row, meta) {
                    // Format the date from '2025-02-10 00:00:00' to 'February, 10 . 2025'
                    var date = new Date(row.created_time);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var formattedDate = date.toLocaleDateString('en-US', options);
                    var [month, day, year] = formattedDate.split(' ');
                    return `${month}, ${day} . ${year}`;
                }
            },
            {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                        <td class="d-flex flex-row justify-content-start align-items-center">
                       <a class="btn btn-primary" type="button" href="paymentbysession.php?session_id=${row.sess_id}" ><i class="fas fa-money" style="font-size:20px; color: white; margin-top:3px;"></i>Payments</a>
                        <a class="btn btn-dark" type="button" href="viewdetailsales.php?session_id=${row.sess_id}" ><i class="fas fa-list" style="font-size:20px; color: white; margin-top:3px;"></i></a>
                     
                    </td>
    
                    `;
                }
            }
          
        ],
        "order": [[0, 'desc']],
        "searching": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print Table',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ],
        "initComplete": function(settings, json) {
            // Job title filter (check if needed for your use case)
            var jobTitles = [];
            json.data.forEach(function(employee) {
                if (!jobTitles.includes(employee.customer_name)) {
                    jobTitles.push(employee.customer_name);
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
        table.column(1).search(selectedJobTitle).draw();
    });

    });


    
});




function View_DayRecord() {
    var spt = localStorage.getItem("SptID");

    console.log('test', spt);

    var table = $('#employeeTable').DataTable({
        destroy: true,  // Allow reinitializing the table
        "ajax": {
            "url": `functions/sales/getsdaillupdatesalesreport.php?spt=${spt}`,
            "dataSrc": function(json) {
                if (json.data && Array.isArray(json.data)) {
                    // Populate sumtotal at the bottom
                    $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.sumtotal)} Rwf`);
                    $('#sum_paid').html(`${Intl.NumberFormat('en-US').format(json.sumpaid)} Rwf`);
                    $('#sum_balance').html(`${Intl.NumberFormat('en-US').format(json.sumbalance)} Rwf`);
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
                "data": "customer_name",
                "render": function(data, type, row, meta) {
                    return `<p style="text-transform:uppercase; font-weight: bold;">${row.customer_name}</p>`;
                }
            },
            { "data": "customer_phone" },
            { "data": "total_amount" },
            { "data": "totpaid" },
            { "data": "balance",
                "render": function(data, type, row, meta) {
                    var total_amount = row.total_amount;
                    var totpaid = row.totpaid;
                    var balance = total_amount - totpaid;
                    return balance;
                }
    
            },
            { "data": "doneby" },  // Ensure 'doneby' is part of the response
            { 
                "data": "created_time",
                "render": function(data, type, row, meta) {
                    // Format the date from '2025-02-10 00:00:00' to 'February, 10 . 2025'
                    var date = new Date(row.created_time);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var formattedDate = date.toLocaleDateString('en-US', options);
                    var [month, day, year] = formattedDate.split(' ');
                    return `${month}, ${day} . ${year}`;
                }
            },
            {
                "data": null, // Add action column
                "render": function(data, type, row, meta) {
                    // Return HTML for action buttons
                    return `
                       <td class="d-flex justify-content-start align-items-center">
                            <a class="btn btn-primary me-2" type="button" href="paymentbysession.php?session_id=${row.sess_id}">
                                <i class="fas fa-money" style="font-size:20px; color: white;"></i>
                            </a>
                            <a class="btn btn-dark" type="button" href="viewdetailsales.php?session_id=${row.sess_id}">
                                <i class="fas fa-list" style="font-size:20px; color: white;"></i>
                            </a>
                        </td>

    
                    `;
                }
            }
          
        ],
        "order": [[0, 'desc']],
        "searching": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print Table',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ],
        "initComplete": function(settings, json) {
            // Job title filter (check if needed for your use case)
            var jobTitles = [];
            json.data.forEach(function(employee) {
                if (!jobTitles.includes(employee.customer_name)) {
                    jobTitles.push(employee.customer_name);
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
        table.column(1).search(selectedJobTitle).draw();
    });



}





