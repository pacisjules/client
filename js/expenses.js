$(document).ready(function () {

 View_WeekexpensesRecord();
 populateExpenseTypes();
 View_DayexpensesRecord();
 foreditExpenseTypes();
 View_MonthexpensesRecord();
 View_YearexpensesRecord();

 $("#viewexpenses").click(function(){
  View_expensesRecordPrint();
 })


    $("#addnewtype").click(function () {
        
        var name = $("#named").val();
        var decsr = $("#decsri").val();
        // Retrieve values from localStorage
        var sales_point_id = parseInt(localStorage.getItem("SptID"));
        
        // Disable the button to prevent multiple clicks
        $(this).prop("disabled", true).html("Adding...");

        // Start AJAX request
        $.ajax({
            url: "functions/expenses/insertexpense_type.php",
            method: "POST",
            data: {
                name: name,
                description: decsr,
                salepoint_id: sales_point_id
            },
            success: function (response) {
                
                 $("#named").html("");
                $("#decsri").html("");
                $("#expensesmodal").modal("hide");
                $("#addnewtype").html("Done");
                location.reload();
            },
            error: function (error) {
                
                alert("Some thing went wrong!"+error.responseText);
            },
            complete: function () {
                // Re-enable the button after the AJAX request completes
                $("#addnewtype").prop("disabled", false).html("Add New Type");
            }
        });
    });


    $("#expensesBtn").click(function () {

        var name = $("#expname").val();
        var decsr = $("#descriexp").val();
        var exp_type = $("#expenseTypeSelect").val();
        var amount = $("#amountnum").val();
        var dependon = $("#dependon").val();
        var payment = $("#payment").val();
        console.log(name);
        console.log(decsr);
        // Retrieve values from localStorage
        var sales_point_id = parseInt(localStorage.getItem("SptID"));
        var user_id = parseInt(localStorage.getItem("UserID"));
        
        // Disable the button to prevent multiple clicks
        $(this).prop("disabled", true).html("Adding...");

        if (name == "" || exp_type == "" || amount == "" || dependon == "") {
            alert("Please fill all fields");
            return;
        }

        // Start AJAX request
        $.ajax({
            url: "functions/expenses/insertexpenses.php",
            method: "POST",
            data: {
                name: name,
                description: decsr,
                amount: amount,
                sales_point_id: sales_point_id,
                exp_type:exp_type,
                user_id:user_id,
                dependon:dependon,
                payment:payment,
            },
            success: function (response) {
             
                 $("#expname").val("");
                 $("#descriexp").val("");
                 $("#expenseTypeSelect").val("");
                 $("#amountnum").val("");
                 $("#addexpensesmodal").modal('hide');
                 location.reload();
                
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
                // Re-enable the button after the AJAX request completes
                $("#expensesBtn").prop("disabled", false).html("Add New expenses");
            }
        });
    });

    $(document).on('click', '.ogeditexpense', function () {
        var expenseId = $(this).data('expense-id');
        localStorage.setItem("expid", expenseId);
        // Open the modal
        $('#edit_expe_modal').modal('show');

        // Fetch and populate expense details using AJAX
        $.ajax({
            url: 'functions/expenses/get_expense_details.php',
            method: 'GET',
            data: { id: expenseId },
            dataType: 'json',
            success: function (response) {
                // Populate the modal fields with expense details
                $('#dexpname').val(response.name);
                $('#edescriexp').val(response.description);
                // $('#expenseTypeedit').val(response.exp_type);
                $('#amountedit').val(response.amount);
            },
            error: function (xhr, status, error) {
                console.log('AJAX request failed!');
                console.log('Error:', error);
            }
        });
    });

    $("#editexpensesBtn").click(function () {
        var expenseId = localStorage.getItem("expid"); // Assuming you attach expense ID to this button
        var sales_point_id = parseInt(localStorage.getItem("SptID"));
        var name = $("#dexpname").val();
        var description = $("#edescriexp").val();
        var exp_type = $("#expenseTypeedit").val();
        var amount = $("#amountedit").val();
    
        // AJAX request to update expense
        $.ajax({
            url: "functions/expenses/update_expense.php",
            method: "POST",
            data: {
                id: expenseId,
                name: name,
                description: description,
                sales_point_id:sales_point_id,
                exp_type: exp_type,
                amount: amount
            },
            success: function (response) {
                console.log("Expense updated successfully.");
                localStorage.removeItem("expid");
                // Refresh the expenses list or perform any other necessary action
                location.reload();
                
            },
            error: function (xhr, status, error) {
                console.log("AJAX request failed!");
                console.log("Error:", error);
            }
        });
    
        // Close the modal after updating
        $("#edit_expe_modal").modal("hide");
    });

    $(document).on('click', '.getdeleteid', function () {
        var expenseId = $(this).data('expense-id');
        localStorage.setItem("expid", expenseId);
        // Open the modal
        $('#delete_expe_modal').modal('show'); 
    });
    
    $("#confirmDeleteBtn").click(function () {
        var expenseId = localStorage.getItem("expid");
    
        // AJAX request to delete the expense
        $.ajax({
            url: "functions/expenses/remove_expense.php",
            method: "POST",
            data: {id: expenseId },
            success: function (response) {
                console.log(response.message);
                localStorage.removeItem("expid");
                // Refresh the expenses list or perform any other necessary action
                View_DayexpensesRecord();
            },
            error: function (xhr, status, error) {
                console.log("AJAX request failed!");
                console.log("Error:", error);
            }
        });
    
        // Close the modal after deleting
        $('#delete_expe_modal').modal('hide');
    });
    

});


function populateExpenseTypes() {
    var sales_point_id = parseInt(localStorage.getItem("SptID"));

    $.ajax({
        url: "functions/expenses/get_expense_types.php",
        method: "POST",
        data: { salepoint_id: sales_point_id },
        success: function (response) {
            $("#expenseTypeSelect").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function foreditExpenseTypes() {
    var sales_point_id = parseInt(localStorage.getItem("SptID"));

    $.ajax({
        url: "functions/expenses/get_expense_types.php",
        method: "POST",
        data: { salepoint_id: sales_point_id },
        success: function (response) {
            $("#expenseTypeedit").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function View_DayexpensesRecord() {
    var sales_point_id = localStorage.getItem("SptID");
    var today = new Date(); // Get today's date
    var selectedDate = today.toISOString().substr(0, 10); // Convert to YYYY-MM-DD format

    $.ajax({
      url: `functions/expenses/getsdailyexpensesspt.php?sales_point_id=${sales_point_id}&date=${selectedDate}`,
      method: "GET",  // Use GET for fetching data
      dataType: "json",  // Expect JSON response
      success: function (response) {
        if (response && response.length > 0) {
          var htmlRows = "";
          $.each(response, function (index, expense) {
            htmlRows += `
              <tr>
                <td style="font-size: 14px;">${index + 1}. ${expense.name}</td>
                <td style="font-size: 14px;">${expense.description}</td>
                <td style="font-size: 14px;">${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(expense.amount))}</td>
                <td style="font-size: 14px;">${expense.expense_name}</td>
                <td style="font-size: 14px;">${expense.created_date}</td>
                <td class="d-flex flex-row justify-content-start align-items-center">
                  <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                  <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-trash"></i></button>
                </td>
              </tr>`;
          });
          $("#dailyexpenses").html(htmlRows);
        } else {
          $("#dailyexpenses").html("<tr><td colspan='6'>Not Any result</td></tr>");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
  }


  function View_WeekexpensesRecord() {
    var sales_point_id = localStorage.getItem("SptID");

    // Get the date range for the current week (Monday to Sunday)
    var currentDate = new Date();
    var currentDay = currentDate.getDay(); // 0 for Sunday, 1 for Monday, ..., 6 for Saturday
    var daysToMonday = currentDay === 0 ? 6 : currentDay - 1;
    var daysToSunday = currentDay === 0 ? 0 : 7 - currentDay;
    var mondayDate = new Date(currentDate);
    mondayDate.setDate(currentDate.getDate() - daysToMonday);
    var sundayDate = new Date(currentDate);
    sundayDate.setDate(currentDate.getDate() + daysToSunday);

    var formattedMonday = formatDate(mondayDate);
    var formattedSunday = formatDate(sundayDate);

    $.ajax({
      url: `functions/expenses/getweeklyexpenses.php?sales_point_id=${sales_point_id}&monday=${formattedMonday}&sunday=${formattedSunday}`,
      method: "GET",  // Use GET for fetching data
      dataType: "json",  // Expect JSON response
      success: function (response) {
        if (response && response.length > 0) {
          var htmlRows = "";
          $.each(response, function (index, expense) {
            htmlRows += `
              <tr>
                <td style="font-size: 14px;">${index + 1}. ${expense.name}</td>
                <td style="font-size: 14px;">${expense.description}</td>
                <td style="font-size: 14px;">${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(expense.amount))}</td>
                <td style="font-size: 14px;">${expense.expense_name}</td>
                <td style="font-size: 14px;">${expense.created_date}</td>
                <td class="d-flex flex-row justify-content-start align-items-center">
                  <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                  <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-trash"></i></button>
                </td>
              </tr>`;
          });
          $("#weeklyexpenses").html(htmlRows);
        } else {
          $("#weeklyexpenses").html("<tr><td colspan='6'>Not Any result</td></tr>");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
  }

// Format date to YYYY-MM-DD
function formatDate(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, "0");
    var day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
}

function View_MonthexpensesRecord() {
    var sales_point_id = localStorage.getItem("SptID");

    // Get the current year and month
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, "0");

    $.ajax({
      url: `functions/expenses/getMonthlyexpenses.php?sales_point_id=${sales_point_id}&year=${year}&month=${month}`,
      method: "GET",  // Use GET for fetching data
      dataType: "json",  // Expect JSON response
      success: function (response) {
        if (response && response.length > 0) {
          var htmlRows = "";
          $.each(response, function (index, expense) {
            htmlRows += `
              <tr>
                <td style="font-size: 14px;">${index + 1}. ${expense.name}</td>
                <td style="font-size: 14px;">${expense.description}</td>
                <td style="font-size: 14px;">${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(expense.amount))}</td>
                <td style="font-size: 14px;">${expense.expense_name}</td>
                <td style="font-size: 14px;">${expense.created_date}</td>
                <td class="d-flex flex-row justify-content-start align-items-center">
                  <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                  <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-trash"></i></button>
                </td>
              </tr>`;
          });
          $("#monthlyexpenses").html(htmlRows);
        } else {
          $("#monthlyexpenses").html("<tr><td colspan='6'>Not Any result</td></tr>");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
  }

  function View_YearexpensesRecord() {
    var sales_point_id = localStorage.getItem("SptID");

    // Get the current year
    var currentDate = new Date();
    var year = currentDate.getFullYear();

    $.ajax({
      url: `functions/expenses/get_expenses_by_year.php?sales_point_id=${sales_point_id}&year=${year}`,
      method: "GET",  // Use GET for fetching data
      dataType: "json",  // Expect JSON response
      success: function (response) {
        if (response && response.length > 0) {
          var htmlRows = "";
          $.each(response, function (index, expense) {
            htmlRows += `
              <tr>
                <td style="font-size: 14px;">${index + 1}. ${expense.name}</td>
                <td style="font-size: 14px;">${expense.description}</td>
                <td style="font-size: 14px;">${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(expense.amount))}</td>
                <td style="font-size: 14px;">${expense.expense_name}</td>
                <td style="font-size: 14px;">${expense.created_date}</td>
                <td class="d-flex flex-row justify-content-start align-items-center">
                  <button class="btn btn-success ogeditexpense" type="button" data-bs-target="#edit_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
                  <button class="btn btn-danger getdeleteid" type="button" style="margin-left: 20px;" data-bs-target="#delete_expe_modal" data-bs-toggle="modal" data-expense-id=${expense.id}><i class="fa fa-trash"></i></button>
                </td>
              </tr>`;
          });
          $("#yearexpenses").html(htmlRows);
        } else {
          $("#yearexpenses").html("<tr><td colspan='6'>Not Any result</td></tr>");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
  }



  function View_expensesRecordPrint() {
    // Retrieve values from localStorage
  
    var sales_point_id = localStorage.getItem("SptID");
    var today = new Date(); // Get today's date
    var selectedDate = today.toISOString().substr(0, 10);
  
    // Ajax Start!
  
    $.ajax({
      url:`functions/expenses/getsdailyexpensesspt.php?sales_point_id=${sales_point_id}&date=${selectedDate}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          const inventorydata = response;
          const inventorytotal = response.length;
          const typereport = "Expenses Report";
          printExpensesReport(inventorydata, inventorytotal,typereport);
          
        } else {
          //console.log(response);
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




  function printExpensesReport(inventorydata, inventorytotal,typereport) {
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
    
    for (let i = 0; i < inventorydata.length; i++) {
    const item = inventorydata[i];
    table += `<tr >
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.name}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="250">${item.description}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.expense_name}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.amount}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.created_date}</td>
    
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
             Expenses
              </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="250">
            Description
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Type
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Amount
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            DATE
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
            
          <tr>
              <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                
              </td>
              <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
               
              </td>
            </tr>
            -->
            
            <tr>
            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
              
            </td>
            <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
              <strong>Total Items : ${inventorytotal} </strong>
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
    



