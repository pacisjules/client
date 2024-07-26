<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dynamic DataTable with PHP and MySQL</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div>
        <label for="jobTitleFilter">Filter by Product:</label> <span class="badge text-bg-primary" style="font-size: 14px;" id="sum_total"></span>
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
            { "data": function(data) { return data.closing_stock - data.sold_stock; } },
            { "data": "entry_stock" },
            { "data": function(data) { return ((parseFloat(data.closing_stock - data.sold_stock) + parseFloat(data.entry_stock))); } },
            { "data": "sold_stock" },
            { "data": function(data) { return `<span class="badge text-bg-primary">${Intl.NumberFormat('en-US').format(data.unit_price)} Rwf </span>`; } },
            { "data": function(data) { return `<span class="badge text-bg-primary">${Intl.NumberFormat('en-US').format(data.sold_stock * data.unit_price)} Rwf </span>`; } },
            { "data": "closing_stock" },
        ],
        "order": [[1, 'asc']],
        "searching": true,
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
                $('#sum_total').html(`${Intl.NumberFormat('en-US').format(json.total)} Rwf `);
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
</body>
</html>
