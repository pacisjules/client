$(document).ready(function () {

 View_WeekexpensesRecord();
 populateExpenseTypes();
 View_DayexpensesRecord();
 foreditExpenseTypes();
 View_MonthexpensesRecord();
 View_YearexpensesRecord();


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
        console.log(name);
        console.log(decsr);
        // Retrieve values from localStorage
        var sales_point_id = parseInt(localStorage.getItem("SptID"));
        
        // Disable the button to prevent multiple clicks
        $(this).prop("disabled", true).html("Adding...");

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
            },
            success: function (response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === "success") {
                    console.log(jsonResponse.message);
                } else {
                    console.log(jsonResponse.message);
                }
                 $("#expname").val("");
                 $("#descriexp").val("");
                 $("#expenseTypeSelect").val("");
                 $("#amountnum").val("");
                 $("#addexpensesmodal").modal('hide');
                 View_DayexpensesRecord();
                
            },
            error: function (error) {
                console.log(error.responseText);
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
                View_DayexpensesRecord();
                
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



