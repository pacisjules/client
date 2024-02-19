$(document).ready(function () {
    populateCustomer(); 
    
    
    
 
  
  View_customerRequestsRecord();
  
   $("#yesterdayrequest").click(function () {
  View_YestcustomerRequestsRecord();
   });
   
   $("#weeklyrequest").click(function () {
   
  View_WeeklycustomerRequestsRecord(); 
   
   });
   
   
   
   
   
   $(function () {
        // Initialize the datepicker
        $("#datepicker").datepicker({
            onSelect: function (dateText) {
                
               function convertDateFormat(dateText) {
                const dateParts = dateText.split("/");
                const month = dateParts[0];
                const day = dateParts[1];
                const year = dateParts[2];
            
                const formattedDate =
                    year +
                    "-" +
                    month.toString().padStart(2, "0") +
                    "-" +
                    day.toString().padStart(2, "0");
            
                return formattedDate;
            }
                
            var formattedDate = convertDateFormat(dateText);    
                // Retrieve values from localStorage
 var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/request/getallrequestcompanyspt.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchpickeddateRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelPickTable', 'PickedRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelpick_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelpick_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
    error: function(xhr, status, error) {
        console.error("ERROR Response: ", error);
        // Handle the error or display an error message to the user
    },
    });
                
                
        localStorage.setItem("datepicked",formattedDate); 
      
                
                
            }
        });

        // Open the datepicker when the button is clicked
        $("#pickDateButton").on("click", function () {
            $("#datepicker").focus();
        });
        
        
        
    });
   
   
  $(function () {
            // Initialize the date range picker
            $('#daterange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });

            // Handle the date range selection
            $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                const startDate = picker.startDate.format('YYYY-MM-DD');
                const endDate = picker.endDate.format('YYYY-MM-DD');
                console.log("from "+startDate);
                 console.log("to "+endDate);

             var sales_point_id = localStorage.getItem("SptID");


            // Make the AJAX request
   // Ajax Start!
    $.ajax({
        url: `functions/request/getWeeklyRequestdata.php?start_date=${startDate}&end_date=${endDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchFromToRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelFromToTable', 'FromToRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelfromto_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelfromto_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
        error: function(xhr, status, error) {
            console.error("ERROR Response: ", error);
            // Handle the error or display an error message to the user
        },
    });


        localStorage.setItem("fromdate",startDate);   
        localStorage.setItem("todate",endDate);   

            });

            // Handle the button click event to open the date range picker
            $('#Pickdaterangebtn').on('click', function () {
                $('#daterange').click();
            });
            
            
            
        });  
        
        
        
    $("#retrieveMonthlyData").on("click", function () {
        
       const formatDate = (myDate) => {
        const dateParts = myDate.split("-");
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    };

    const selectedMonth = $("#monthSelect").val();
    const salesPointID = localStorage.getItem("SptID");
    localStorage.removeItem("monthSelect");

    // Get the current year
    const currentYear = new Date().getFullYear();

    // Construct the start and end dates for the selected month in the current year
    const startDate = new Date(`${currentYear}-${selectedMonth}-01`);
    const endDate = new Date(`${currentYear}-${selectedMonth}-31`);

    // Format the dates
    const formattedStartDate = formatDate(startDate.toISOString().split('T')[0]);
    const formattedEndDate = formatDate(endDate.toISOString().split('T')[0]);

    console.log(formattedStartDate, formattedEndDate);
    
    // Make the AJAX request
    $.ajax({
        url: `functions/request/getWeeklyRequestdata.php?start_date=${formattedStartDate}&end_date=${formattedEndDate}&spt=${salesPointID}`,
         method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchMonthlyRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelMonthlyTable', 'MonthlyRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelmonth_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelmonth_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
        error: function(xhr, status, error) {
            console.error("ERROR Response: ", error);
            // Handle the error or display an error message to the user
        },
    });

 localStorage.setItem("monthSelect",selectedMonth); 
$("#selectMonthModal").modal("hide");
});        
        
        
        
 $("#retrieveYearlyData").on("click", function () {
  const selectedYear = $("#yearSelect").val();
  
  const salesPointID = localStorage.getItem("SptID");
  localStorage.removeItem("yearSelect");

  console.log("Selected Year: " + selectedYear);
  console.log("Sales Point ID (from localStorage): " + salesPointID);

  // Check if any of these values is undefined or empty
  if (!selectedYear || !salesPointID) {
      console.error("One or more required values are missing. Unable to make the AJAX request.");
      return; // Exit the function to prevent the AJAX request
  }

  // Calculate the start and end dates for the selected year
  const startDate = selectedYear + "-01-01"; // Start of the year
  const endDate = selectedYear + "-12-31";   // End of the year

  console.log("Start Date: " + startDate);
  console.log("End Date: " + endDate);

  // Make the AJAX request
  $.ajax({
        url: `functions/request/getWeeklyRequestdata.php?start_date=${startDate}&end_date=${endDate}&spt=${salesPointID}`,
         method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchYearlyRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelYearlyTable', 'YearlyRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelyear_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelyear_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
      error: function(xhr, status, error) {
          console.error("ERROR Response: ", error);
          // Handle the error or display an error message to the user
      },
  });
  localStorage.setItem("yearSelect",selectedYear);
  $("#selectYearModal").modal("hide");
});  
  

  
  
    

  
  
  
   $("#searchDebt").on("input", function (e) {
                  
    var sales_point_id = localStorage.getItem("SptID");
                
                  // Clear the table before making the AJAX request
     $("#debt_table").empty();
                
                  // Ajax Start!
        $.ajax({
         url: `functions/debts/getbysearchname.php?spt=${sales_point_id}&names=${e.target.value}`,
         method: "GET", // Change method to GET to match your PHP code
         context: document.body,
         success: function (response) {
         if (response && response.length > 0) {
                        // Iterate through the response data and build table rows
         $.each(response, function (index, row) {
             
             var mes = "";
          var color = "";
          if (row.paid_status == 1) {
            mes = "Debt";
            color = "red";
          } else {
            mes = "Full paid";
            color = "green";
          }
             
             
         var html = `
             <tr>
              <td>${index + 1}. ${row.names}</td>
              <td>${row.phone}</td>
              <td>${row.address}</td>
              <td>${new Intl.NumberFormat("en-US", {
                                  style: "currency",
                                  currency: "RWF",
                              }).format(parseFloat(row.total_amount))}</td>
              <td style="color:${color}; font-weight:bold;">${mes}</td>
              <td>${row.due_date}</td>
              <td class="d-flex flex-row justify-content-start align-items-center">
               <a class="nav-link active" href="debtdetails.php?customer_id=${row.customer_id}">
                <button class="btn btn-success rounded-circle" type="button">
                    <i class="fas fa-eye" style="margin-left: 5px; color: white"></i>
                </button>
            </a>
            </td>  
             </tr>
         `;
                
         $("#debt_table").append(html);
     });
         } else {
                        // No results found
          $("#debt_table").html("<tr><td colspan='7'>Not Any result</td></tr>");
        }
    },
    error: function (xhr, status, error) {
                      // Handle AJAX request errors here
     console.error("AJAX request failed: " + error);
     },
    });
                  // Ajax End!   
 });
 
 
 
 
 
$("#InsertRequest").click(function () {
    // Check if the button is already disabled to prevent multiple clicks
    if ($(this).prop("disabled")) {
        return;
    }

    // Disable the button to prevent double-clicks
    $(this).prop("disabled", true);

    var customer = $("#CustomerSelect").val(); 
    var carName = $("#carname").val(); 
    var plateName = $("#plate").val();
    var cartype = $("#cartypeSelect").val();
    var serviceSelect = $("#serviceSelect").val();
    var sales_point_id = localStorage.getItem("SptID");

    $.ajax({
        type: "POST",
        url: "functions/request/insertrequest.php",
        data: {
            customer_id: customer,
            carName: carName,
            plateName: plateName,
            cartype: cartype,
            serviceSelect: serviceSelect,
            spt: sales_point_id,
        },
        success: function (response) {
            console.log(response);

            // Clear input fields
            $("#carname").val("");
            $("#plate").val("");
            $("#CustomerSelect").val("");
            $("#cartypeSelect").val("");
            $("#serviceSelect").val("");
           

            // Re-enable the button
            $("#InsertRequest").prop("disabled", false);

            // Check if the modal is not already hidden before attempting to hide it
            if ($("#add_newdebt_modal").is(":visible")) {
                // Close the modal or perform other actions as needed
                $("#add_newdebt_modal").modal("hide");
            }

            // Refresh the view
            View_customerRequestsRecord();
        },
        error: function (xhr, status, error) {
            console.log(error);

            // Re-enable the button in case of an error
            $("#InsertRequest").prop("disabled", false);

            // Close the modal or perform other actions as needed
            $("#add_newdebt_modal").modal("hide");

            // Refresh the view
            View_customerRequestsRecord();
        },
    });
});
   



    $("#EditDebts").click(function () {
      
        var Quantity = $("#editqty").val();
        var amountDue = parseInt($("#editamount").val(), 10);
    var amountPaid = parseInt($("#editamountpaid").val(), 10);
        var sales_point_id = localStorage.getItem("SptID"); 
         var debt_id = localStorage.getItem("debt_id"); 
        

        $.ajax({
            type: "POST",
            url: "functions/debts/updatedebt.php", // Replace with the actual URL of your PHP script
            data: {
                id: debt_id,
                qty: Quantity,
                amount: amountDue,
                amount_paid:amountPaid,
                sales_point_id:sales_point_id,
                
            },
            success: function (response) {
                // Handle success here, e.g., show a success message
                console.log(response);
                $("#edit_debts_modal").modal("hide");
                $("#successmodal").modal("show");
                  setTimeout(function() {
                        location.reload();
                    }, 1000);
            },
            error: function (xhr, status, error) {
                // Handle errors here, e.g., show an error message
                console.log(error);
                $("#edit_debts_modal").modal("hide");
                $("#errormodal").modal("show");
                  setTimeout(function() {
                        location.reload();
                    }, 1000);
            },
        });
    });            




  $("#RemoveDebts").click(function () {
      
         var debt_id = localStorage.getItem("debt_id"); 
        

        $.ajax({
            type: "POST",
            url: "functions/debts/removedebt.php", // Replace with the actual URL of your PHP script
            data: {
                id: debt_id,
                
            },
            success: function (response) {
                // Handle success here, e.g., show a success message
                console.log(response);
                $("#delete_debts_modal").modal("hide");
                $("#successmodal").modal("show");
                  setTimeout(function() {
                        location.reload();
                    }, 1000);
            },
            error: function (xhr, status, error) {
                // Handle errors here, e.g., show an error message
                console.log(error);
                $("#delete_debts_modal").modal("hide");
                $("#errormodal").modal("show");
                  setTimeout(function() {
                        location.reload();
                    }, 1000);
            },
        });
    });            








                





   
  });
  
  

  
  
   function View_customerpaymnetPrint(customer_id) {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/debts/paymenthistory.php?customer_id=${customer_id}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response.data);
          const historydata = response.data;
          const names = response.names;
          const phone = response.phone;
          const address = response.address;
          const total_debtcust = response.total_debtcust;
          const total_paidcust = response.total_paidcust;
          const total_balance = response.total_balance;
          const typereport = " Debts Payment History Report";
          printInventoryhistory(historydata,typereport,names,phone,address,total_debtcust,total_paidcust,total_balance);
          
        } else {
          console.log(response);
        console.error('Empty or invalid data received from the server.');
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
  
  function View_allCustomerDebtsPrint() {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/debts/getalldebtscompanysptNotPaid.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response.data);
          const debstdata = response.debts;
          const totalamount = response.total_debt;
          const typereport = "All Debts Report";
          printAllDebtsReport(debstdata,totalamount,typereport);
          
        } else {
          console.log(response);
        console.error('Empty or invalid data received from the server.');
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
  
  
  
   function View_allCustomerPaidPrint() {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/debts/getalldebtscompanysptPaid.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response.data);
          const debstdata = response.debts;
          const totalamount = response.total_debt;
          const typereport = "All Paid Debts Report";
          printAllDebtsReport(debstdata,totalamount,typereport);
          
        } else {
          console.log(response);
        console.error('Empty or invalid data received from the server.');
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
  
  
  
  
  
  
function View_customerRequestsRecord() {
    
     const currentDate = new Date();
    const montly = currentDate.getMonth();
    const date = currentDate.getDate();
    const year = currentDate.getFullYear();
    const formattedDate =
    year +
    "-" +
    (montly + 1).toString().padStart(2, "0") +
    "-" +
    date.toString().padStart(2, "0");


    const formatDate = (myDate) => {
      const dateParts = myDate.split("-");
      const year = dateParts[0];
      const month = dateParts[1];
      const day = dateParts[2];
  
      const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
        "en-US",
        {
          year: "numeric",
          month: "long",
          day: "numeric",
        }
      );
  
      return formattedDate;
    };

    
    console.log(formattedDate);
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/request/getallrequestcompanyspt.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailyRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'DailyRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excel_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excel_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
        error: function (xhr, status, error) {
            // console.log("AJAX request failed!");
            // console.log("Error:", error);
        },
    });
    // Ajax End!
}

function View_YestcustomerRequestsRecord() {
    
     const currentDate = new Date();
    const yesterday = new Date(currentDate);
    yesterday.setDate(currentDate.getDate() - 1);
    
    const montly = yesterday.getMonth();
    const date = yesterday.getDate();
    const year = yesterday.getFullYear();
    const formattedDate =
    year +
    "-" +
    (montly + 1).toString().padStart(2, "0") +
    "-" +
    date.toString().padStart(2, "0");


    const formatDate = (myDate) => {
      const dateParts = myDate.split("-");
      const year = dateParts[0];
      const month = dateParts[1];
      const day = dateParts[2];
  
      const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
        "en-US",
        {
          year: "numeric",
          month: "long",
          day: "numeric",
        }
      );
  
      return formattedDate;
    };
    
    console.log(formattedDate);
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/request/getallrequestcompanyspt.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchyestRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelYestTable', 'YestRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${parseFloat(totalrequest)}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelyest_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelyest_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
        error: function (xhr, status, error) {
            // console.log("AJAX request failed!");
            // console.log("Error:", error);
        },
    });
    // Ajax End!
}

function View_WeeklycustomerRequestsRecord() {
    
    
    
     const formatDate = (myDate) => {
        const dateParts = myDate.split("-");
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
    
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    };
    
    
    
    
    const currentDate = new Date();
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
    
    const endOfWeek = new Date(currentDate);
    endOfWeek.setDate(currentDate.getDate() - currentDate.getDay() + 6);

    // Format the dates
    const startDate = formatDate(startOfWeek.toISOString().split('T')[0]);
    const endDate = formatDate(endOfWeek.toISOString().split('T')[0]);

    console.log(startDate, endDate);
  
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/request/getWeeklyRequestdata.php?start_date=${startDate}&end_date=${endDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.requests && response.requests.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const totalrequest = response.totalrequest; // Access sumtotal
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total rEQUEST: ", totalrequest);
                
                
                  btntype += `
                            <div> <button class="btn btn-primary" style="font-size: 15px; font-weight: bold;" data-bs-target="#add_newdebt_modal" data-bs-toggle="modal"><i class="fa fa-plus" style="padding-right: 0px;"></i>
Add New Request</button> </div>
                            <div>
                  <button class="btn btn-warning"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-clock"></i>

Pending Request </button>
                <button class="btn btn-success" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-check"></i>

Done Request </button>
                 </div>
                
                <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchweeklyRequestReport();"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelWeekTable', 'WeeklyRequestData')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>`;
                
                $("#btnrequestType").html(btntype); 

                
              
                  tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Requests: ${totalrequest}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                

                for (let i = 0; i < response.requests.length; i++) {
                    const item = response.requests[i];
                    console.log(item.names);

                    let sts = "";
                    let endis = "";
                    

                    if (item.statuss == 1) {
                        sts = "Pending";
                       
                    } else if(item.statuss == 2) {
                        sts = "Done";
                       
                    }else{
                        sts = "Error";
                        
                    }
                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                            <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px; color=${ item.statuss == 1 ? "orange" : "green" };font-weight:bold;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getDataEdit('${item.id}','${item.carName}','${item.platename}','${item.carType}','${item.servicesNeeded}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getDataRemove('${item.id}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.names}</td>
                            <td style="font-size: 14px;"> ${item.phone}</td>
                            <td style="font-size: 14px;">${item.carName}</td>
                            <td style="font-size: 14px;"> ${item.platename}</td>
                            <td style="font-size: 14px;"> ${item.carType}</td>
                             <td style="font-size: 14px;"> ${item.servicesNeeded}</td>
                            <td style="font-size: 14px;">${sts}</td>
                            <td style="font-size: 14px;">${item.created_at}</td>
                            
                        </tr>
                    `;
                }

                $("#request_table").html(html); // Set the HTML content of the table
                 $("#excelweek_table").html(excel); // Set the HTML content of the table
            } else {
                $("#request_table").html("No results");
                $("#excelweek_table").html("No results"); 
            }
        } catch (e) {
            console.error("Error handling response: ", e);
            // Handle the error or display an error message to the user
        }
    },
        error: function (xhr, status, error) {
            // console.log("AJAX request failed!");
            // console.log("Error:", error);
        },
    });
    // Ajax End!
}



// function printInventoryhistory(historydata,typereport,names,phone,address,total_debtcust,total_paidcust,total_balance) {
//   // Calculate the total amount with interest
//   const currentDate = new Date();

// const year = currentDate.getFullYear();
// const month = String(currentDate.getMonth() + 1).padStart(2, '0');
// const day = String(currentDate.getDate()).padStart(2, '0');

// const formattedDate = `${year}-${month}-${day}`;

// const c_name = localStorage.getItem("companyName");
// const Phone =  localStorage.getItem("phone");
// const c_logo = localStorage.getItem("company_logo");
// const c_color =  localStorage.getItem("company_color");
// const nameManager =  localStorage.getItem("Names");
// const salespoint =  localStorage.getItem("spt_name");



// let table = '';

// for (let i = 0; i < historydata.length; i++) {
//   const item = historydata[i];
//   table += `<tr >
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.user_name}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.action}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.amount_paid}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.current_balance}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.created_at}</td>
  
// </tr>`;
 
// };

     
//   const printWindow = window.open('', '_blank');
//   printWindow.document.write(`
//   <!DOCTYPE html>
//   <html>
    
//   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//   <title> ${typereport}  </title>
//   <meta name="robots" content="noindex,nofollow" />
//   <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
 
  
  
//   <style type="text/css">
//   @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
//   body { margin: 0; padding: 0; background: white; }
//   div, p, a, li, td { -webkit-text-size-adjust: none; }
//   .ReadMsgBody { width: 100%; background-color: #ffffff; }
//   .ExternalClass { width: 100%; background-color: #ffffff; }
//   body { width: 100%; height: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
//   html { width: 100%; }
//   p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
//   .visibleMobile { display: none; }
//   .hiddenMobile { display: block; }
  
//   @media only screen and (max-width: 600px) {
//   body { width: auto !important; }
//   table[class=fullTable] { width: 96% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 45% !important; }
//   .erase { display: none; }
//   }
  
//   @media only screen and (max-width: 420px) {
//   table[class=fullTable] { width: 100% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 100% !important; clear: both; }
//   table[class=col] td { text-align: left !important; }
//   .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
//   .visibleMobile { display: block !important; }
//   .hiddenMobile { display: none !important; }
//   }
//   </style>
  
  
//   <!-- Header -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tr>
//   <td height="20"></td>
//   </tr>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
//   <tr class="hiddenMobile">
//   <td height="40"></td>
//   </tr>
//   <tr class="visibleMobile">
//   <td height="30"></td>
//   </tr>
  
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td>
//           <table width="240" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
//             <tbody>
//               <tr>
//                 <td align="left"> <img src="${c_logo}" width="75" height="75" alt="logo" border="0" style="object-fit:cover;" /></td>
//               </tr>
//               <tr class="hiddenMobile">
//                 <td height="40"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 22px; color: ${c_color}; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: left;">
//                   ${c_name}
//                 </td>
//               </tr>
  
//               <tr>
//             <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
//           </tr>
  
//               <tr>
//                   <td style="padding-top:20px; font-size: 18px; color: #1f0c57; font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Manager, ${nameManager} <br> Tel: ${Phone}
//                 </td>
                
//                   </tr>
  
//                   <tr>
//                   <td style="font-size: 12px; color: rgb(6, 6, 61); font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Sales Point Location : ${salespoint}
//                 </td>
//                   </tr>
//             </tbody>
//           </table>
//           <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//             <tbody>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td height="5"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 26px; color: rgb(6, 6, 61); letter-spacing: 1px; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: right;">
//                 ${typereport}
//                 </td>
//               </tr>
//               <tr>
//               <tr class="hiddenMobile">
//                 <td height="50"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Client Names: ${names}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Tel ${phone}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <small>On ${formattedDate}</small>
//                 </td>
//               </tr> 
              
//             </tbody>
//           </table>
//         </td>
//       </tr>
      
      
      
//       <tr>
//         <td>
          
//           <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//             <tbody>
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Amount Due: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_debtcust))}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Amount Paid: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_paidcust))}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Balance: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_balance))}</strong>
//                 </td>
//               </tr> 
              
//             </tbody>
//           </table>
//         </td>
//       </tr>
      
      
      
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   </table>
//   </td>
//   </tr>
//   </table>
//   <!-- /Header -->
//   <!-- Order Details -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white" >
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//   <tr class="hiddenMobile">
//     <td height="60"></td>
//   </tr>
//   <tr class="visibleMobile">
//     <td height="40"></td>
//   </tr>
//   <tr>
//     <td>
//       <table width="600" border="2" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
//           <tr>
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
//             User Name
//             </th>
//           <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
//           Quantity
//           </th>
            
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Amount Paid
//             </th>
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Balance
//             </th>
            
//              <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Date
//             </th>
          
//           ${table}
          
          
//         </tbody>
//       </table>
//     </td>
//   </tr>
//   <tr>
//     <td height="20"></td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   <!-- /Order Details -->
//   <!-- Total -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//     <td>
  
//       <!-- Table Total -->
//       <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
  
//         <!-- 
          
//         <tr>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
              
//             </td>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
             
//             </td>
//           </tr>
//           -->
          
//           <tr>
//           <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
//           </td>
//           <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
//           </td>
//         </tr>
          
//         </tbody>
//       </table>
//       <!-- /Table Total -->
  
//     </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
 
//   </tbody>
//   </table>
//   <!-- /Total -->
  
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding" bgcolor="white">
//         <tbody>
//           <tr>
//             <td>
//   <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="margin-left:100px; margin-top:50px;">
//                 <tbody>
//                   <tr class="visibleMobile">
//                     <td height="20"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #1f0c57; line-height: 1; vertical-align: top; ">
//                       <strong>Manager Name: ${nameManager}</strong>
//                     </td>
//                   </tr>
//                   <tr>
//                     <td width="100%" height="40"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; font-weight:100; color: #080743; line-height: 1; vertical-align: top; ">
//                       <strong>Official Stamp & Signature</strong>
//                     </td>
//                   </tr>
  
//                   <tr height='20px'>
//           <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4; margin-bottom:10px"></td>
//           </tr>
//                   <tr>
//                     <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
//                       <br/>
//                       <br/>
//                       <br/>
  
//                     </td>
//                   </tr>
//                 </tbody>
//               </table>
//             </td>
//           </tr>
//         </tbody>
//       </table></td></tr></tbody></table>
  
  
  
  
//   <!-- Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr class="visibleMobile">
//     <td height="30">
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
  
  
  
  
//   <!-- /Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
//           Have A nice day!!!
//         </td>
//       </tr>
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   <tr class="spacer">
//   <td height="50"></td>
//   </tr>
  
//   </table>
//   </td>
//   </tr>
//   <tr>
//   <td height="20"></td>
//   </tr>
  
//   </table>
//   <script>
//             // Automatically print the report
//             window.onload = function() {
//               window.print();
//               setTimeout(function() { window.close(); }, 100);
//             };
//           </script>
//   </html>
//   `);

//   // Close the document after printing
//   printWindow.document.close();
//  // Use jsPDF to convert the HTML to a PDF and print it


// }









// function  printOnlyCustomerDebts(debtdata,typereport,names,phone,address,total_debtcust,total_paidcust,total_balance) {
//   // Calculate the total amount with interest
//   const currentDate = new Date();

// const year = currentDate.getFullYear();
// const month = String(currentDate.getMonth() + 1).padStart(2, '0');
// const day = String(currentDate.getDate()).padStart(2, '0');

// const formattedDate = `${year}-${month}-${day}`;

// const c_name = localStorage.getItem("companyName");
// const Phone =  localStorage.getItem("phone");
// const c_logo = localStorage.getItem("company_logo");
// const c_color =  localStorage.getItem("company_color");
// const nameManager =  localStorage.getItem("Names");
// const salespoint =  localStorage.getItem("spt_name");



// let table = '';

// for (let i = 0; i < debtdata.length; i++) {
//   const item = debtdata[i];
//   table += `<tr >
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.name}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.qty}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(item.amount))}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.due_date}</td>
  
// </tr>`;
 
// };

     
//   // Create a new window for printing
//   const printWindow = window.open('', '_blank');
//   printWindow.document.write(`
//   <!DOCTYPE html>
//   <html>
    
//   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//   <title> ${typereport}  </title>
//   <meta name="robots" content="noindex,nofollow" />
//   <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
 
  
  
//   <style type="text/css">
//   @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
//   body { margin: 0; padding: 0; background: white; }
//   div, p, a, li, td { -webkit-text-size-adjust: none; }
//   .ReadMsgBody { width: 100%; background-color: #ffffff; }
//   .ExternalClass { width: 100%; background-color: #ffffff; }
//   body { width: 100%; height: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
//   html { width: 100%; }
//   p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
//   .visibleMobile { display: none; }
//   .hiddenMobile { display: block; }
  
//   @media only screen and (max-width: 600px) {
//   body { width: auto !important; }
//   table[class=fullTable] { width: 96% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 45% !important; }
//   .erase { display: none; }
//   }
  
//   @media only screen and (max-width: 420px) {
//   table[class=fullTable] { width: 100% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 100% !important; clear: both; }
//   table[class=col] td { text-align: left !important; }
//   .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
//   .visibleMobile { display: block !important; }
//   .hiddenMobile { display: none !important; }
//   }
//   </style>
  
  
//   <!-- Header -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tr>
//   <td height="20"></td>
//   </tr>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
//   <tr class="hiddenMobile">
//   <td height="40"></td>
//   </tr>
//   <tr class="visibleMobile">
//   <td height="30"></td>
//   </tr>
  
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td>
//           <table width="240" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
//             <tbody>
//               <tr>
//                 <td align="left"> <img src="${c_logo}" width="75" height="75" alt="logo" border="0" style="object-fit:cover;" /></td>
//               </tr>
//               <tr class="hiddenMobile">
//                 <td height="40"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 22px; color: ${c_color}; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: left;">
//                   ${c_name}
//                 </td>
//               </tr>
  
//               <tr>
//             <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
//           </tr>
  
//               <tr>
//                   <td style="padding-top:20px; font-size: 18px; color: #1f0c57; font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Manager, ${nameManager} <br> Tel: ${Phone}
//                 </td>
                
//                   </tr>
  
//                   <tr>
//                   <td style="font-size: 12px; color: rgb(6, 6, 61); font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Sales Point Location : ${salespoint}
//                 </td>
//                   </tr>
//             </tbody>
//           </table>
//           <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//             <tbody>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td height="5"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 26px; color: rgb(6, 6, 61); letter-spacing: 1px; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: right;">
//                 ${typereport}
//                 </td>
//               </tr>
//               <tr>
//               <tr class="hiddenMobile">
//                 <td height="50"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Client Names: ${names}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Tel ${phone}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <small>On ${formattedDate}</small>
//                 </td>
//               </tr> 
              
//             </tbody>
//           </table>
//         </td>
//       </tr>
      
      
      
//       <tr>
//         <td>
          
//           <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//             <tbody>
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Amount Due: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_debtcust))}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Amount Paid: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_paidcust))}</strong>
//                 </td>
//               </tr>
              
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <strong>Balance: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(total_balance))}</strong>
//                 </td>
//               </tr> 
              
//             </tbody>
//           </table>
//         </td>
//       </tr>
      
      
      
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   </table>
//   </td>
//   </tr>
//   </table>
//   <!-- /Header -->
//   <!-- Order Details -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white" >
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//   <tr class="hiddenMobile">
//     <td height="60"></td>
//   </tr>
//   <tr class="visibleMobile">
//     <td height="40"></td>
//   </tr>
//   <tr>
//     <td>
//       <table width="600" border="2" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
//           <tr>
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
//             Product Name
//             </th>
//           <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
//           Quantity
//           </th>
            
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Amount Due
//             </th>
            
//              <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Date
//             </th>
          
//           ${table}
          
          
//         </tbody>
//       </table>
//     </td>
//   </tr>
//   <tr>
//     <td height="20"></td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   <!-- /Order Details -->
//   <!-- Total -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//     <td>
  
//       <!-- Table Total -->
//       <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
  
//         <!-- 
          
//         <tr>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
              
//             </td>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
             
//             </td>
//           </tr>
//           -->
          
//           <tr>
//           <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
//           </td>
//           <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
//           </td>
//         </tr>
          
//         </tbody>
//       </table>
//       <!-- /Table Total -->
  
//     </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
 
//   </tbody>
//   </table>
//   <!-- /Total -->
  
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding" bgcolor="white">
//         <tbody>
//           <tr>
//             <td>
//   <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="margin-left:100px; margin-top:50px;">
//                 <tbody>
//                   <tr class="visibleMobile">
//                     <td height="20"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #1f0c57; line-height: 1; vertical-align: top; ">
//                       <strong>Manager Name: ${nameManager}</strong>
//                     </td>
//                   </tr>
//                   <tr>
//                     <td width="100%" height="40"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; font-weight:100; color: #080743; line-height: 1; vertical-align: top; ">
//                       <strong>Official Stamp & Signature</strong>
//                     </td>
//                   </tr>
  
//                   <tr height='20px'>
//           <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4; margin-bottom:10px"></td>
//           </tr>
//                   <tr>
//                     <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
//                       <br/>
//                       <br/>
//                       <br/>
  
//                     </td>
//                   </tr>
//                 </tbody>
//               </table>
//             </td>
//           </tr>
//         </tbody>
//       </table></td></tr></tbody></table>
  
  
  
  
//   <!-- Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr class="visibleMobile">
//     <td height="30">
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
  
  
  
  
//   <!-- /Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
//           Have A nice day!!!
//         </td>
//       </tr>
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   <tr class="spacer">
//   <td height="50"></td>
//   </tr>
  
//   </table>
//   </td>
//   </tr>
//   <tr>
//   <td height="20"></td>
//   </tr>
  
//   </table>
//   <script>
//             // Automatically print the report
//             window.onload = function() {
//               window.print();
//               setTimeout(function() { window.close(); }, 100);
//             };
//           </script>
//   </html>
//   `);

//   // Close the document after printing
//   printWindow.document.close();
//  // Use jsPDF to convert the HTML to a PDF and print it


// }


// function printAllDebtsReport(debstdata,totalamount,typereport) {
//   // Calculate the total amount with interest
//   const currentDate = new Date();

// const year = currentDate.getFullYear();
// const month = String(currentDate.getMonth() + 1).padStart(2, '0');
// const day = String(currentDate.getDate()).padStart(2, '0');

// const formattedDate = `${year}-${month}-${day}`;

// const c_name = localStorage.getItem("companyName");
// const Phone =  localStorage.getItem("phone");
// const c_logo = localStorage.getItem("company_logo");
// const c_color =  localStorage.getItem("company_color");
// const nameManager =  localStorage.getItem("Names");
// const salespoint =  localStorage.getItem("spt_name");



// let table = '';

// for (let i = 0; i < debstdata.length; i++) {
//   const item = debstdata[i];
//   table += `<tr >
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.names}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.phone}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.address}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(item.total_amount))}</td>
//   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.due_date}</td>
  
// </tr>`;
 
// };

     
//   // Create a new window for printing
//   const printWindow = window.open('', '_blank');
//   printWindow.document.write(`
//   <!DOCTYPE html>
//   <html>
    
//   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//   <title> ${typereport}  </title>
//   <meta name="robots" content="noindex,nofollow" />
//   <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
 
  
  
//   <style type="text/css">
//   @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
//   body { margin: 0; padding: 0; background: white; }
//   div, p, a, li, td { -webkit-text-size-adjust: none; }
//   .ReadMsgBody { width: 100%; background-color: #ffffff; }
//   .ExternalClass { width: 100%; background-color: #ffffff; }
//   body { width: 100%; height: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
//   html { width: 100%; }
//   p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
//   .visibleMobile { display: none; }
//   .hiddenMobile { display: block; }
  
//   @media only screen and (max-width: 600px) {
//   body { width: auto !important; }
//   table[class=fullTable] { width: 96% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 45% !important; }
//   .erase { display: none; }
//   }
  
//   @media only screen and (max-width: 420px) {
//   table[class=fullTable] { width: 100% !important; clear: both; }
//   table[class=fullPadding] { width: 85% !important; clear: both; }
//   table[class=col] { width: 100% !important; clear: both; }
//   table[class=col] td { text-align: left !important; }
//   .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
//   .visibleMobile { display: block !important; }
//   .hiddenMobile { display: none !important; }
//   }
//   </style>
  
  
//   <!-- Header -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tr>
//   <td height="20"></td>
//   </tr>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
//   <tr class="hiddenMobile">
//   <td height="40"></td>
//   </tr>
//   <tr class="visibleMobile">
//   <td height="30"></td>
//   </tr>
  
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td>
//           <table width="240" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
//             <tbody>
//               <tr>
//                 <td align="left"> <img src="${c_logo}" width="75" height="75" alt="logo" border="0" style="object-fit:cover;" /></td>
//               </tr>
//               <tr class="hiddenMobile">
//                 <td height="40"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 22px; color: ${c_color}; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: left;">
//                   ${c_name}
//                 </td>
//               </tr>
  
//               <tr>
//             <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
//           </tr>
  
//               <tr>
//                   <td style="padding-top:20px; font-size: 18px; color: #1f0c57; font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Manager, ${nameManager} <br> Tel: ${Phone}
//                 </td>
                
//                   </tr>
  
//                   <tr>
//                   <td style="font-size: 12px; color: rgb(6, 6, 61); font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
//                   Sales Point Location : ${salespoint}
//                 </td>
//                   </tr>
//             </tbody>
//           </table>
//           <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//             <tbody>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td height="5"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 26px; color: rgb(6, 6, 61); letter-spacing: 1px; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: right;">
//                 ${typereport}
//                 </td>
//               </tr>
//               <tr>
//               <tr class="hiddenMobile">
//                 <td height="50"></td>
//               </tr>
//               <tr class="visibleMobile">
//                 <td height="20"></td>
//               </tr>
//               <tr>
//                 <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
//                   <small>On ${formattedDate}</small>
//                 </td>
//               </tr>
//             </tbody>
//           </table>
//         </td>
//       </tr>
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   </table>
//   </td>
//   </tr>
//   </table>
//   <!-- /Header -->
//   <!-- Order Details -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white" >
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//   <tr class="hiddenMobile">
//     <td height="60"></td>
//   </tr>
//   <tr class="visibleMobile">
//     <td height="40"></td>
//   </tr>
//   <tr>
//     <td>
//       <table width="600" border="2" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
//           <tr>
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
//             Client
//             </th>
//           <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
//           Phone
//           </th>
            
//             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Address
//             </th>
          
//           <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//           Amount Due
//             </th>
            
//              <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
//             Date
//             </th>
          
//           ${table}
          
          
//         </tbody>
//       </table>
//     </td>
//   </tr>
//   <tr>
//     <td height="20"></td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   <!-- /Order Details -->
//   <!-- Total -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr>
//     <td>
  
//       <!-- Table Total -->
//       <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//         <tbody>
  
//         <!-- 
          
//         <tr>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
              
//             </td>
//             <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
             
//             </td>
//           </tr>
//           -->
          
//           <tr>
//           <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
//           </td>
//           <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
//              <strong>Total Amount Due: ${new Intl.NumberFormat("en-US", {
//               style: "currency",
//               currency: "RWF",
//           }).format(parseFloat(totalamount))}</strong>
//           </td>
//         </tr>
          
//         </tbody>
//       </table>
//       <!-- /Table Total -->
  
//     </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
 
//   </tbody>
//   </table>
//   <!-- /Total -->
  
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding" bgcolor="white">
//         <tbody>
//           <tr>
//             <td>
//   <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="margin-left:100px; margin-top:50px;">
//                 <tbody>
//                   <tr class="visibleMobile">
//                     <td height="20"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #1f0c57; line-height: 1; vertical-align: top; ">
//                       <strong>Manager Name: ${nameManager}</strong>
//                     </td>
//                   </tr>
//                   <tr>
//                     <td width="100%" height="40"></td>
//                   </tr>
//                   <tr>
//                     <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; font-weight:100; color: #080743; line-height: 1; vertical-align: top; ">
//                       <strong>Official Stamp & Signature</strong>
//                     </td>
//                   </tr>
  
//                   <tr height='20px'>
//           <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4; margin-bottom:10px"></td>
//           </tr>
//                   <tr>
//                     <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
//                       <br/>
//                       <br/>
//                       <br/>
  
//                     </td>
//                   </tr>
//                 </tbody>
//               </table>
//             </td>
//           </tr>
//         </tbody>
//       </table></td></tr></tbody></table>
  
  
  
  
//   <!-- Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
//   <tbody>
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//   <tbody>
//   <tr class="visibleMobile">
//     <td height="30">
//   </td>
//   </tr>
//   </tbody>
//   </table>
//   </td>
//   </tr>
//   </tbody>
//   </table>
  
  
  
  
//   <!-- /Information -->
//   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  
//   <tr>
//   <td>
//   <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
//   <tr>
//   <td>
//   <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//     <tbody>
//       <tr>
//         <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
//           Have A nice day!!!
//         </td>
//       </tr>
//     </tbody>
//   </table>
//   </td>
//   </tr>
//   <tr class="spacer">
//   <td height="50"></td>
//   </tr>
  
//   </table>
//   </td>
//   </tr>
//   <tr>
//   <td height="20"></td>
//   </tr>
  
//   </table>
//   <script>
//             // Automatically print the report
//             window.onload = function() {
//               window.print();
//               setTimeout(function() { window.close(); }, 100);
//             };
//           </script>
//   </html>
//   `);

//   // Close the document after printing
//   printWindow.document.close();
//  // Use jsPDF to convert the HTML to a PDF and print it


// }






function populateCustomer() {
    var sales_point_id = parseInt(localStorage.getItem("SptID"));

    $.ajax({
        url: "functions/debts/getCustomerforDebt.php",
        method: "GET", // Change to GET method
        data: { spt: sales_point_id },
        success: function (response) {
            // console.log(response);
            $("#CustomerSelect").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function populateProduct() {
    var company_id = parseInt(localStorage.getItem("CoID"));
    var sales_point_id = parseInt(localStorage.getItem("SptID"));
    

    $.ajax({
        url: "functions/debts/getProductforDebt.php",
        method: "GET", // Change to GET method
        data: {company_id: company_id, spt: sales_point_id },
        success: function (response) {
            console.log(response);
            $("#ProductSelect").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}



function getDataEdit(id,name,qty,amount,amount_paid){
     localStorage.setItem("debt_id", id);
        localStorage.setItem("name", name);
        $("#editqty").val(qty);
        $("#editamount").val(amount);
        $("#editamountpaid").val(amount_paid);
     
        
        console.log("debt_id ", id);
        console.log("name ", name);
        console.log("qty ", qty);
     console.log("amount due ", amount);
        console.log("amount paid ", amount_paid);
}

function getDataRemove(id,name){
     localStorage.setItem("debt_id", id);
     localStorage.setItem("name", name);
}



function exportTableToExcel(tableID, filename = '') {
        var table = document.getElementById(tableID);
        var ws = XLSX.utils.table_to_sheet(table);

        // Create a new workbook with the sheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        // Save the workbook to an XLSX file
        XLSX.writeFile(wb, filename + '.xlsx');
    }
    
    
    
 function fetchpickeddateRequestReport() {
  const date = localStorage.getItem("datepicked")
 
  const sales_point_id = localStorage.getItem("SptID");

  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getallrequestcompanyspt.php?date=${date}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Yestrday Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}    
        
    
function fetchdailyRequestReport() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;


  const sales_point_id = localStorage.getItem("SptID");

  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getallrequestcompanyspt.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Daily Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}    



function fetchyestRequestReport() {
 const currentDate = new Date();
    const yesterday = new Date(currentDate);
    yesterday.setDate(currentDate.getDate() - 1);
    
    const montly = yesterday.getMonth();
    const date = yesterday.getDate();
    const year = yesterday.getFullYear();
    const formattedDate =
    year +
    "-" +
    (montly + 1).toString().padStart(2, "0") +
    "-" +
    date.toString().padStart(2, "0");


    const formatDate = (myDate) => {
      const dateParts = myDate.split("-");
      const year = dateParts[0];
      const month = dateParts[1];
      const day = dateParts[2];
  
      const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
        "en-US",
        {
          year: "numeric",
          month: "long",
          day: "numeric",
        }
      );
  
      return formattedDate;
    };


  const sales_point_id = localStorage.getItem("SptID");

  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getallrequestcompanyspt.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Yestrday Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}    
        
    


function fetchweeklyRequestReport() {
   
    
     const formatDate = (myDate) => {
        const dateParts = myDate.split("-");
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
    
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    };
    
    
    
    
    const currentDate = new Date();
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
    
    const endOfWeek = new Date(currentDate);
    endOfWeek.setDate(currentDate.getDate() - currentDate.getDay() + 6);

    // Format the dates
    const startDate = formatDate(startOfWeek.toISOString().split('T')[0]);
    const endDate = formatDate(endOfWeek.toISOString().split('T')[0]);

    console.log(startDate, endDate);
  
    var sales_point_id = localStorage.getItem("SptID");


  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getWeeklyRequestdata.php?start_date=${startDate}&end_date=${endDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Weekly Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
} 


function fetchFromToRequestReport() {
   
const fromdate = localStorage.getItem("fromdate")
  const todate = localStorage.getItem("todate")
  
    var sales_point_id = localStorage.getItem("SptID");


  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getWeeklyRequestdata.php?start_date=${fromdate}&end_date=${todate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "From "+fromdate +" To "+todate+" Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
} 


function fetchMonthlyRequestReport() {
   
 const formatDate = (myDate) => {
        const dateParts = myDate.split("-");
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    };

   
   
   
var selectedMonth = localStorage.getItem("monthSelect");
  
 
  var sales_point_id = localStorage.getItem("SptID");


  const currentYear = new Date().getFullYear();

    // Construct the start and end dates for the selected month in the current year
    const startDate = new Date(`${currentYear}-${selectedMonth}-01`);
    const endDate = new Date(`${currentYear}-${selectedMonth}-31`);

    // Format the dates
    const formattedStartDate = formatDate(startDate.toISOString().split('T')[0]);
    const formattedEndDate = formatDate(endDate.toISOString().split('T')[0]);

    console.log(formattedStartDate, formattedEndDate);

    


  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getWeeklyRequestdata.php?start_date=${formattedStartDate}&end_date=${formattedEndDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Monthly Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
} 

function fetchYearlyRequestReport() {
   
 const formatDate = (myDate) => {
        const dateParts = myDate.split("-");
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    };

   
   
   
var selectedYear = localStorage.getItem("yearSelect");
  
 
  var sales_point_id = localStorage.getItem("SptID");


    // Construct the start and end dates for the selected month in the current year
    const startDate = new Date(`${selectedYear}-01-01`);
    const endDate = new Date(`${selectedYear}-12-31`);

    // Format the dates
    const formattedStartDate = formatDate(startDate.toISOString().split('T')[0]);
    const formattedEndDate = formatDate(endDate.toISOString().split('T')[0]);

    console.log(formattedStartDate, formattedEndDate);

    


  if (!sales_point_id) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/request/getWeeklyRequestdata.php?start_date=${formattedStartDate}&end_date=${formattedEndDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response && response.requests && response.requests.length > 0) {
        const requestdata =response.requests;
        const typereport = "Yearly Request Report";
        const totalRequest = response.totalrequest;
        printPdfRequestReport(requestdata,typereport,totalRequest);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
} 





function printPdfRequestReport(requestdata,typereport,totalRequest) {
  // Calculate the total amount with interest
  const currentDate = new Date(); 


const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');

const formattedDate = `${year}-${month}-${day}`;

const c_name = localStorage.getItem("companyName");
const Phone =  localStorage.getItem("phone");
const c_logo = localStorage.getItem("company_logo");
const c_color =  localStorage.getItem("company_color");
const nameManager =  localStorage.getItem("Names");
const salespoint =  localStorage.getItem("spt_name");
 


let table = '';

for (let i = 0; i < requestdata.length; i++) {
  const item = requestdata[i];
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.names}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.phone}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.carName}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.platename}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.carType}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.servicesNeeded}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color:${ item.statuss == 1 ? "orange" : "green" }; font-weight: bold;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${ item.statuss == 1 ? "Pending" : "Done" }</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.created_at}</td>
</tr>`;
 
};

     
  // Create a new window for printing
  const printWindow = window.open('', '_blank');
  printWindow.document.write(`
  <!DOCTYPE html>
  <html>
    
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> ${typereport}  </title>
  <meta name="robots" content="noindex,nofollow" />
  <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
 
  
  
  <style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
  body { margin: 0; padding: 0; background: white; }
  div, p, a, li, td { -webkit-text-size-adjust: none; }
  .ReadMsgBody { width: 100%; background-color: #ffffff; }
  .ExternalClass { width: 100%; background-color: #ffffff; }
  body { width: 100%; height: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
  html { width: 100%; }
  p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
  .visibleMobile { display: none; }
  .hiddenMobile { display: block; }
  
  @media only screen and (max-width: 600px) {
  body { width: auto !important; }
  table[class=fullTable] { width: 96% !important; clear: both; }
  table[class=fullPadding] { width: 85% !important; clear: both; }
  table[class=col] { width: 45% !important; }
  .erase { display: none; }
  }
  
  @media only screen and (max-width: 420px) {
  table[class=fullTable] { width: 100% !important; clear: both; }
  table[class=fullPadding] { width: 85% !important; clear: both; }
  table[class=col] { width: 100% !important; clear: both; }
  table[class=col] td { text-align: left !important; }
  .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
  .visibleMobile { display: block !important; }
  .hiddenMobile { display: none !important; }
  }
  </style>
  
  
  <!-- Header -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  <tr>
  <td height="20"></td>
  </tr>
  <tr>
  <td>
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
  <tr class="hiddenMobile">
  <td height="40"></td>
  </tr>
  <tr class="visibleMobile">
  <td height="30"></td>
  </tr>
  
  <tr>
  <td>
  <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
    <tbody>
      <tr>
        <td>
          <table width="240" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
            <tbody>
              <tr>
                <td align="left"> <img src="${c_logo}" width="75" height="75" alt="logo" border="0" style="object-fit:cover;" /></td>
              </tr>
              <tr class="hiddenMobile">
                <td height="40"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="20"></td>
              </tr>
              <tr>
                <td style="font-size: 22px; color: ${c_color}; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: left;">
                  ${c_name}
                </td>
              </tr>
  
              <tr>
            <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
          </tr>
  
              <tr>
                  <td style="padding-top:20px; font-size: 18px; color: #1f0c57; font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
                  Manager, ${nameManager} <br> Tel: ${Phone}
                </td>
                
                  </tr>
  
                  <tr>
                  <td style="font-size: 12px; color: rgb(6, 6, 61); font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
                  Sales Point Location : ${salespoint}
                </td>
                  </tr>
            </tbody>
          </table>
          <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
            <tbody>
              <tr class="visibleMobile">
                <td height="20"></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td style="font-size: 26px; color: rgb(6, 6, 61); letter-spacing: 1px; font-family: 'Open Sans', sans-serif; font-weight:bold;  vertical-align: top; text-align: right;">
                ${typereport}
                </td>
              </tr>
              <tr>
              <tr class="hiddenMobile">
                <td height="50"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="20"></td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                  <small>On ${formattedDate}</small>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <!-- /Header -->
  <!-- Order Details -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white" >
  <tbody>
  <tr>
  <td>
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
  <tbody>
  <tr>
  <tr class="hiddenMobile">
    <td height="60"></td>
  </tr>
  <tr class="visibleMobile">
    <td height="40"></td>
  </tr>
  <tr>
    <td>
      <table width="600" border="2" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
        <tbody>
          <tr>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
            Customer
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Phone
          </th>
  
           
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Car Name
            </th> 
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Plaque
            </th>
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Type
            </th>
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
             Service
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
             Status
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
             Date
            </th>
          
          
          ${table}
          
          
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  </tbody>
  </table>
  </td>
  </tr>
  </tbody>
  </table>
  <!-- /Order Details -->
  <!-- Total -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  <tbody>
  <tr>
  <td>
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
  <tbody>
  <tr>
    <td>
  
      <!-- Table Total -->
      <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
        <tbody>
  
        <!-- 
          
        
          -->
          
          <tr>
          <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong></strong>
          </td>
          <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong></strong>
          </td>
        </tr>
        
          <tr>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong></strong>
          </td>
          <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong>Total Request :   ${totalRequest}</strong>
          </td>
          
        </tr>
        <tr>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong></strong>
          </td>
          <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong></strong>
          </td>
        </tr>
          
        </tbody>
      </table>
      <!-- /Table Total -->
  
    </td>
  </tr>
  </tbody>
  </table>
  </td>
  </tr>
 
  </tbody>
  </table>
  <!-- /Total -->
  
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding" bgcolor="white">
        <tbody>
          <tr>
            <td>
  <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="margin-left:100px; margin-top:50px;">
                <tbody>
                  <tr class="visibleMobile">
                    <td height="20"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #1f0c57; line-height: 1; vertical-align: top; ">
                      <strong>Manager Name: ${nameManager}</strong>
                    </td>
                  </tr>
                  <tr>
                    <td width="100%" height="40"></td>
                  </tr>
                  <tr>
                    <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; font-weight:100; color: #080743; line-height: 1; vertical-align: top; ">
                      <strong>Official Stamp & Signature</strong>
                    </td>
                  </tr>
  
                  <tr height='20px'>
          <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4; margin-bottom:10px"></td>
          </tr>
                  <tr>
                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                      <br/>
                      <br/>
                      <br/>
  
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table></td></tr></tbody></table>
  
  
  
  
  <!-- Information -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  <tbody>
  <tr>
  <td>
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
  <tbody>
  <tr class="visibleMobile">
    <td height="30">
  </td>
  </tr>
  </tbody>
  </table>
  </td>
  </tr>
  </tbody>
  </table>
  
  
  
  
  <!-- /Information -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
  
  <tr>
  <td>
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
  <tr>
  <td>
  <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
    <tbody>
      <tr>
        <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
          Have A nice day!!!
        </td>
      </tr>
    </tbody>
  </table>
  </td>
  </tr>
  <tr class="spacer">
  <td height="50"></td>
  </tr>
  
  </table>
  </td>
  </tr>
  <tr>
  <td height="20"></td>
  </tr>
  
  </table>
  <script>
            // Automatically print the report
            window.onload = function() {
              window.print();
              setTimeout(function() { window.close(); }, 100);
            };
          </script>
  </html>
  `);

  // Close the document after printing
  printWindow.document.close();
 // Use jsPDF to convert the HTML to a PDF and print it


}










        
    