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
        <label for="jobTitleFilter">Filter by Product:</label> <span style="font-size: 20px;margin-left:12rem;">CLOSED TOTAL:</span><span class="badge text-bg-primary" style="margin-left:1rem;font-size:20px;"  id="sum_total"></span>
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select>
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 15px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>PRODUCT</th>
                    <th>QTY</th>
                    <th>UNIT PRICE</th>
                    <th>TOTAL</th>
                    <th>SOLD BY</th>
                    <th>SALES POINT</th>
                    <th>STATUS</th>
                    <th>SOLD TIME</th>
                  
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function() {
    var from = getParameterByName('from'); 
    var to = getParameterByName('to'); 
    var company = localStorage.getItem('CoID');  
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
    "ajax": {
        "url": `functions/sales/getallShiftclosedSales.php?from=${from}&to=${to}&company=${company}&spt=${spt}`,
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
        { "data": "Product_Name" },
        { "data": "quantity" },
        { "data": "sales_price" },
        { "data": "total_amount" },
        { "data": "location" },
        { "data": "fullname" },
        {
            "data": "paid_status",
            "render": function(data, type, row, meta) {
                if (data === "Paid") {
                    return `<span class="badge text-bg-success"><span style="color: white; font-weight: bold; font-size: 12px">Paid</span></span>`;
                } else {
                    return `<span class="badge text-bg-danger"><span style="color: white; font-weight: bold; font-size: 12px">Not Paid</span></span>`;
                }
            }
        },
        { "data": "created_time" }
    ],
    "order": [[1, 'asc']],
    "searching": true,
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
