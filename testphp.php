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
        <label for="jobTitleFilter">Filter by Branch:</label>
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select>
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Sales point</th>
                    <th>Shift</th>
                    <th>Start</th>
                    <th>Income</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        var table = $('#employeeTable').DataTable({
            "ajax": `fetch_data.php?company=${localStorage.getItem("CoID")}`,
            "columns": [
                { "data": "num" },
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "sales_point" },
                { "data": "shift_name" },
                {
                    "data": "start",
                    "render": function(data, type, row, meta) {
                        // Add 2 hours to created_time
                        let createdTime = new Date(data);
                        createdTime.setHours(createdTime.getHours() + 2);
                        return createdTime.toLocaleString();
            }
        },
                { 
                    "data": "income_number",
                    "render": function (data, type, row, meta) {
                        return Intl.NumberFormat('en-US').format(data);
                    }
                },
                {
                    "data": "shift_status",
                    "render": function(data, type, row, meta) {
                        if (data == 1) {
                            return `<a href="currentshift?start=${row.start}&spt=${row.spt}" ><span class="badge text-bg-success"><span style="color: white; font-weight: bold; font-size: 12px">Working</span></span></a>`;
                        } else {
                            return `<span>LIVE</span>`;
                        }
                    }
                }
            ],
            "initComplete": function(settings, json) {
                var jobTitles = [];
                json.data.forEach(function(employee) {
                    if (!jobTitles.includes(employee.sales_point)) {
                        jobTitles.push(employee.sales_point);
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
