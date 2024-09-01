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
        <!-- <label for="jobTitleFilter">Filter by Branch:</label>
        <select id="jobTitleFilter" class="form-select" aria-label="Default select example" style="width:220px;">
            <option selected value="">All</option>
        </select> -->
        <br/>

        <table id="employeeTable" class="display" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PRODUCT</th>
                    <th>REMAIN QUANTITY</th>
                    <th>PURCHASE TIME</th>
                    <th>EXPIRED TIME</th>
                    <th>REMAINNING TIME</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        
        var table = $('#employeeTable').DataTable({
            "ajax": `functions/sales/getallexpirycompanyspt.php?spt=${localStorage.getItem("SptID")}`,
            "columns": [
                { "data": "num" },
                { "data": "name",
                 "render": function(data, type, row, meta) {
                    return `<p style="font-size: 15px; font-weight: bold; text-transform: uppercase;">${row.name}</p>`
                 }
                 },
                { "data": "quantity" },
                { "data": "created_at",
                 "render": function(data, type, row, meta) {
                    let created_at = row.created_at;
                    let date = new Date(created_at);
                    let options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
                    let formattedDate = date.toLocaleString('en-US', options);
                    return `<span style=" width: 100%; padding: 5px; font-size: 15px">${formattedDate}</span>`
                 }
                 },

                 { "data": "due_date",
                 "render": function(data, type, row, meta) {
                    let due_date = row.due_date;
                    let date = new Date(due_date);
                    let options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
                    let formattedDate = date.toLocaleString('en-US', options);
                    return `<span style=" width: 100%; padding: 5px; font-size: 15px">${formattedDate}</span>`
                 }
                 },
             
                
                { "data": null,
                 "render": function(data, type, row, meta) {
                    // Calculate remain time
                    let due_date = new Date(row.due_date);
                    let now = new Date();
                    let diff = due_date.getTime() - now.getTime();
                    let remain_day = Math.floor(diff / (1000 * 60 * 60 * 24));
                    let remain_hour = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let remain_time = remain_day + " days " + remain_hour + " hour(s)";

                    let date = new Date(due_date);
                    let options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
                    let formattedDate = date.toLocaleString('en-US', options);

                    if (remain_day == 1) {
                       
                        return `<span class="badge text-bg-dark"  style="color: white; width: 100%; padding: 5px; font-size: 15px">${remain_time}</span>`
                    }
                    else if (remain_day<1 && remain_hour<1) { 
                         return `<span class="badge text-bg-danger"  style="color: white; width: 100%; padding: 5px; font-size: 15px">Product expired</span>`
                    }
                    
                    else if (remain_hour >= 5) {
                         return `<span class="badge text-bg-primary"  style="color: white; width: 100%; padding: 5px; font-size: 15px">${remain_time}</span>`
                    } else if (remain_hour < 1) {
                         return `<span class="badge text-bg-warning"  style="color: black; width: 100%; padding: 5px; font-size: 15px">${remain_time}</span>`
                    } 

                   
                 },
                },

                { "data": null,
                 "render": function(data, type, row, meta) {
                    // Calculate remain time
                    let due_date = new Date(row.due_date);
                    let now = new Date();
                    let diff = due_date.getTime() - now.getTime();
                    let remain_day = Math.floor(diff / (1000 * 60 * 60 * 24));
                    let remain_hour = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let remain_time = remain_day + " days " + remain_hour + " hour(s)";
                    if (remain_day > 1) {
                        return `<span style="color: black; width: 100%; padding: 5px; font-size: 15px;  font-weight: bold;">More than 1 day</span>`
                    }
                    else if (remain_day == 1) {
                        return `<span style="color: green; width: 100%; padding: 5px; font-size: 15px;  font-weight: bold;">Remain 1 day</span>`
                    } 
                    else if (remain_day<1 && remain_hour<1) { 
                         return `<span  style="color: red; width: 100%; padding: 5px; font-size: 15px">Expired</span>`
                    }

                    else if (remain_hour >= 5) {
                         return `<span style="color: orange; width: 100%; padding: 5px; font-size: 15px; font-weight: bold;">Remain few hours</span>`
                    } else if (remain_hour < 1) {
                         return `<span style="color: redorange; width: 100%; padding: 5px; font-size: 15px; font-weight: bold;">Less than 1 hour</span>`
                    } else {
                         return `<span style="color: red; width: 100%; padding: 5px; font-size: 15px; font-weight: bold;">Expired</span>`
                    }

                   
                 },
                },


                { "data": null,
                 "render": function(data, type, row, meta) {
                    return `<button class="btn btn-primary btn-sm" onclick="alert('Expand Time not Working yet')">Expand Time</button>`
                 },
                },

                
                
               
            ],
            "order": [[4, 'desc']],
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
