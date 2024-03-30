$(document).ready(function () {

  var store_id = getParameterByName('store_id'); 
    View_DayPurchaseRecord(); 
    View_DayDynamicRecord();
    View_DayFromStockRecord();
    View_MonthPurchaseRecord(store_id);
    populateMonthDropdown();
    $("#weeklysales").click(function () {
    
      View_WeekSalesRecord();
    });
    
    $("#yesterdaysales").click(function () {
    
      View_YesterdaySalesRecord();
    });

// picking from to date sales records

$('#searchDaily').on('keyup', filterTableRows);
  
     function filterTableRows() {
      const searchValue = $('#searchDaily').val().toLowerCase();
      $('#stock_table tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
      });
  }


  $('#searchdailyCombination').on('keyup', filterTableRow);
  
     function filterTableRow() {
      const searchValue = $('#searchdailyCombination').val().toLowerCase();
      $('#sells_table tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
      });
  }





    $("#retrieveMonthlyData").on("click", function () {
        
      

    const selectedMonth = $("#monthSelect").val();
    localStorage.removeItem("monthSelect");
 
    console.log("Selected Month: " + selectedMonth);
 

    // Check if any of these values is undefined or empty
    if (!selectedMonth) {
        console.error("One or more required values are missing. Unable to make the AJAX request.");
        return; // Exit the function to prevent the AJAX request
    }
    const [year, month] = selectedMonth.split('-');

   const startDate = new Date(year, month - 1, 1); // Subtract 1 from month to make it zero-based
   const endDate = new Date(year, month, 0);// Set the day to the last day of the selected month

   endDate.setHours(23, 59, 59, 999); // Set time to end of the day

    // Format the dates as YYYY-MM-DD
    const formattedStartDate = startDate.toISOString().slice(0, 10);
    const formattedEndDate = endDate.toISOString().slice(0, 10);
    
    console.log("Start Date: " + formattedStartDate);
    console.log("End Date: " + formattedEndDate);
    console.log("Store Id: " + store_id);
    
    // Make the AJAX request
    $.ajax({
        url: `functions/purchase/getalldaycombinationReportMonth.php?store_id=${store_id}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
        method: "POST",
        context: document.body,
        success: function(response) {
            try {
                console.log("Success Response: ", response);

                if (response.data && response.data.length > 0) {
                    let html = ""; // Initialize an empty string to store the HTML
                    let tot = "";
                    let btntype = "";
                    let excel = "";
                    let totexcel = "";
                    const sumtotal = response.sumtotal; // Access sumtotal
          // Access sumbenefit
                    
                    // Display sumtotal and sumbenefit as needed
                    console.log("Sum Total Amount: ", sumtotal);
                    
                    
                    btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Montly Inventory Report From ,<span>${formattedStartDate}</span> - <span>${formattedEndDate}</span></p>
                <div>    
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchmonthlysalesReport(${store_id})"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelMonthTable', 'MonthyInventory_Report')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>  `;
                
                $("#combinationBtnMonth").html(btntype);


                

                     tot += `<tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Items: ${parseFloat(sumtotal)}</strong></td>
                              <td style="font-size: 14px;"></td>
                              <td style="font-size: 14px;"><strong></strong></td>
                              <td style="font-size: 14px;"></td>
                           </tr>`;
                    $("#totalams").html(tot);
                    
                    totexcel += `
                
                 <tr>
                     <td style="font-size: 14px;"><strong></strong></td>
                     <td style="font-size: 14px;"><strong></strong></td>
                     <td style="font-size: 14px;"><strong>${parseFloat(sumtotal)}</strong></td>
                     <td style="font-size: 14px;"></td>
                     <td style="font-size: 14px;"><strong></td>
                     <td style="font-size: 14px;"><strong></strong> </td>
                     <td style="font-size: 14px;"><strong></strong></td>
                 </tr>
                
                 `;
                 $("#totalmonthexcel").html(totexcel);
                        
                   

                 for (let i = 0; i < response.data.length; i++) {
                  const item = response.data[i];
                  
                    console.log("item.product_id:", item.product_id);

                  

                  html += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}. ${item.product_name}</td>
                          <td style="font-size: 14px;">${item.opening_stock}</td>
                          <td style="font-size: 14px;">${item.entry_stock}</td>
                          <td style="font-size: 14px;">${item.totalstock}</td>
                          <td style="font-size: 14px;">${item.sold_stock}</td>
                        <td style="font-size: 14px;">${item.closing_stock}</td>
                         
                      </tr>
                  `;
                  
                  
                  excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.product_name}</td>
                          <td style="font-size: 14px;">${item.opening_stock}</td>
                          <td style="font-size: 14px;"> ${item.entry_stock}</td>
                          <td style="font-size: 14px;">${item.totalstock}</td>
                          <td style="font-size: 14px;"> ${item.sold_stock}</td>
                           <td style="font-size: 14px;"> ${item.closing_stock}</td>
                          
                      </tr>
                  `;
              }
                    $("#stock_table").html(html); // Set the HTML content of the table
                    
                $("#excel_month").html(excel); 
                    
                    
                } else {
                    $("#stock_table").html("No results");
                     $("#excel_month").html("No results"); 
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





function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}




 $("#editBtnSales").on("click", function() {
        var id = localStorage.getItem("saleID");
        var raw_material_id = localStorage.getItem("raw_material_id");
        var purchase_date = localStorage.getItem("purchase_date");
        var quantity = $("#editquantity").val();
        var prices = $("#editprice").val();
        var sales_point_id = localStorage.getItem("SptID");
        var use_id= parseInt(localStorage.getItem("UserID"));
        

        $.ajax({
            type: "POST",
            url: "functions/purchase/updatepurchase.php", // Update this with the actual path to your PHP script
            data: {
                id: id,
                raw_material_id: raw_material_id,
                quantity: quantity,
                purchase_date: purchase_date,
                price_per_unity:prices,
                spt: sales_point_id,
                user_id: use_id,
            },
            success: function(response) {
                if (response.message) {
                console.log(response.message);
               } else {
                console.log("Sale purchase  updated successfully.");
                }
                $("#edit_sales_modal").modal("hide");
                localStorage.removeItem("raw_material_id");
                localStorage.removeItem("purchase_date");
                $("#editquantity").val("");
                $("#editprice").val("");
                setTimeout(function() {
                location.reload();
            }, 1000);
                
                
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
                
                
                
            }
        });
    });



$("#deleteBtnSales").on("click", function() {
    var saleID = localStorage.getItem("saleID");
    var raw_material_id = localStorage.getItem("raw_material_id");
    var purchase_date = localStorage.getItem("purchase_date");
    const salesPointID = localStorage.getItem("SptID");
    var use_id= parseInt(localStorage.getItem("UserID"));

    $.ajax({
        type: "POST",
        url: "functions/purchase/deletepurchase.php", // Update this with the actual path to your PHP script
        data: {
            id: saleID, // Corrected variable name to match the PHP script
            raw_material_id: raw_material_id,
            purchase_date: purchase_date, // Corrected variable name to match the PHP script
            spt:salesPointID,
            user_id:use_id,
        },
        success: function(response) {
            if (response.message) {
                console.log(response.message);
            } else {
                console.log("Sale pURCHASE AND STOCK  deleted successfully.");
            }
            $("#delete_sales_modal").modal("hide");
            localStorage.removeItem("saleID");
            localStorage.removeItem("raw_material_id");
            localStorage.removeItem("purchase_date");
            setTimeout(function() {
                location.reload();
            }, 1000);
            

        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);

        }
    });
});





  
    
    
    
    
  });
  


// Function to calculate week number
function getWeekNumber(year, month, day) {
var date = new Date(year, month - 1, day);
date.setHours(0, 0, 0);
date.setDate(date.getDate() + 4 - (date.getDay() || 7));
var yearStart = new Date(date.getFullYear(), 0, 1);
var weekNo = Math.ceil(((date - yearStart) / 86400000 + 1) / 7);
return weekNo;
}




function GetYearlyTotal() {
const currentDate = new Date();
const year = currentDate.getFullYear();

// Retrieve values from localStorage
var sales_point_id = localStorage.getItem("SptID");

// Ajax Start!
$.ajax({
url: `functions/sales/daytotalandcountsptYearly.php?spt=${sales_point_id}`,
method: "POST",
context: document.body,
success: function (response) {
    if (response) {
        console.log(response);
        $("#getYearly").html(response);
    } else {
        $("#getYearly").html("No results available");
    }
},
error: function (xhr, status, error) {
    console.log("Error:", error);
},
});
// Ajax End!
}

  
  
  
  function View_DayDynamicRecord() {

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

    // Retrieve values from localStorage
   var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReport.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                // Access sumtotal
                
                var usertype = localStorage.getItem("UserType");
                           

                // Display sumtotal and sumbenefit as needed
        

                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Daily Summary Report ,At <span>${formattedDate}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailyDynamicReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'dailyPurchase_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>`;
                
                $("#combinationBtndyna").html(btntype);
                
                 tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalamdyna").html(tot);
                
                 totexcel += `
                
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>
                
                `;
                $("#totalexceldyna").html(totexcel);
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];
                    
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;">${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;">${item.sold_stock}</td>
                          <td style="font-size: 14px;">${item.closing_stock}</td>
                           
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;"> ${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;"> ${item.sold_stock}</td>
                             <td style="font-size: 14px;"> ${item.closing_stock}</td>
                            
                        </tr>
                    `;
                }

                $("#sellsdyna_table").html(html); // Set the HTML content of the table
                 $("#exceldyna_table").html(excel); // Set the HTML content of the table
            } else {
                $("#sellsdyna_table").html("No results");
                $("#exceldyna_table").html("No results"); 
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
    // Ajax End!
  }
  
  
  function View_DayPurchaseRecord() {

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

    // Retrieve values from localStorage
   var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReport.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const sumtotal = response.sumtotal; // Access sumtotal
                
                var usertype = localStorage.getItem("UserType");
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total Amount: ", sumtotal);

                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Daily Summary Report ,At <span>${formattedDate}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'dailyPurchase_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>`;
                
                $("#combinationBtn").html(btntype);
                
                 tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales : ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                
                 totexcel += `
                
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales Amount: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>
                
                `;
                $("#totalexcel").html(totexcel);
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];
                    
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;">${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;">${item.sold_stock}</td>
                            <td style="font-size: 14px;">${item.unit_price}</td>
                            <td style="font-size: 14px;">${item.totalprice}</td>
                          <td style="font-size: 14px;">${item.closing_stock}</td>
                           
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;"> ${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;"> ${item.sold_stock}</td>
                            <td style="font-size: 14px;">${item.unit_price}</td>
                            <td style="font-size: 14px;">${item.totalprice}</td>
                             <td style="font-size: 14px;"> ${item.closing_stock}</td>
                            
                        </tr>
                    `;
                }

                $("#sells_table").html(html); // Set the HTML content of the table
                 $("#excel_table").html(excel); // Set the HTML content of the table
            } else {
                $("#sells_table").html("No results");
                $("#excel_table").html("No results"); 
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
    // Ajax End!
  }
  
   function View_DayFromStockRecord() {

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

    // Retrieve values from localStorage
   var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReportFromStock.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const sumtotal = response.sumtotal; // Access sumtotal
                
                var usertype = localStorage.getItem("UserType");
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total Amount: ", sumtotal);

                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Daily Summary Report ,At <span>${formattedDate}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailysalesReportfrom()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'dailyPurchase_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>`;
                
                $("#combinationBtnFromstock").html(btntype);
                
                 tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales : ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalamfrom").html(tot);
                
                 totexcel += `
                
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales Amount: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>
                
                `;
                $("#totalexcelfrom").html(totexcel);
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];
                    
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;">${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;">${item.sold_stock}</td>
                            <td style="font-size: 14px;">${item.unit_price}</td>
                            <td style="font-size: 14px;">${item.totalprice}</td>
                          <td style="font-size: 14px;">${item.closing_stock}</td>
                           
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;"> ${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;"> ${item.sold_stock}</td>
                            <td style="font-size: 14px;">${item.unit_price}</td>
                            <td style="font-size: 14px;">${item.totalprice}</td>
                             <td style="font-size: 14px;"> ${item.closing_stock}</td>
                            
                        </tr>
                    `;
                }

                $("#sells_tablefrom").html(html); // Set the HTML content of the table
                 $("#excel_tablefrom").html(excel); // Set the HTML content of the table
            } else {
                $("#sells_tablefrom").html("No results");
                $("#excel_tablefrom").html("No results"); 
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
    // Ajax End!
  }

  function View_MonthPurchaseRecord(store_id) {

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

    // Retrieve values from localStorage
   
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldayBigstock.php?store_id=${store_id}&date=${formattedDate}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
              

                const sumtotal = response.sumtotal; // Access sumtotal
                
                var usertype = localStorage.getItem("UserType");
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total Amount: ", sumtotal);

                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Daily Inventory Report ,At <span>${formattedDate}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailyBigReport(${store_id})"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'dailyInventory_Report');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>`;
                
                $("#combinationBtnMonth").html(btntype);

               

                
                 tot += `
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales : ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                
                 totexcel += `
                
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales Amount: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>
                
                `;
                $("#totalexcel").html(totexcel);
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];
                    
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;">${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;">${item.sold_stock}</td>
                          <td style="font-size: 14px;">${item.closing_stock}</td>
                           
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.product_name}</td>
                            <td style="font-size: 14px;">${item.opening_stock}</td>
                            <td style="font-size: 14px;"> ${item.entry_stock}</td>
                            <td style="font-size: 14px;">${item.totalstock}</td>
                            <td style="font-size: 14px;"> ${item.sold_stock}</td>
                             <td style="font-size: 14px;"> ${item.closing_stock}</td>
                            
                        </tr>
                    `;
                }

                $("#stock_table").html(html); // Set the HTML content of the table
                 $("#excel_stock").html(excel); // Set the HTML content of the table
            } else {
                $("#stock_table").html("No results");
                $("#excel_stock").html("No results"); 
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
    // Ajax End!
  }



  
  
  
  function View_YesterdaySalesRecord() {

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

    // Retrieve values from localStorage
    var company_ID = parseInt(localStorage.getItem("CoID"));
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaypurchasebyspt.php?date=${formattedDate}&company=${company_ID}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let btntype = "";
                let excel = "";
                let totexcel = "";
                const sumtotal = response.sumtotal; // Access sumtotal
               
                           

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total Amount: ", sumtotal);
                
                
                
                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Yesterday Purchase ,At <span>${formattedDate}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchyesterdaysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelYesterdayTable', 'YesterdayPurchase_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button></div>`;
                
                $("#btnsalesType").html(btntype);
                
                 tot += `
               <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Purchase Amount: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                
                 totexcel += `
                
                 <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong>${parseFloat(sumtotal)}</strong></td>
                    <td style="font-size: 14px;"><strong></strong> </td>
                    <td style="font-size: 14px;"><strong></strong></td>
                </tr>
                
                `;
                $("#totalyesterdayexcel").html(totexcel);
                
               
                
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];
                    
                  console.log("item.id:", item.id);
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.name}</td>
                            <td style="font-size: 14px;">${item.quantity}</td>
                            <td style="font-size: 14px;"> ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                          }).format(parseFloat(item.price_per_unity))}</td>
                          <td style="font-size: 14px;"> ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                          }).format(parseFloat(item.total_price))}</td>
                          <td style="font-size: 14px;">${item.storename}</td>
                          <td style="font-size: 14px;">${item.supplierNames}</td>
                          <td style="font-size: 14px;">${item.supplierPhone}</td>
                            <td style="font-size: 14px;">${item.purchase_date}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.id}','${item.product_id}','${item.purchase_date}','${item.quantity}','${item.price_per_unity}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.id}','${item.product_id}','${item.purchase_date}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.name}</td>
                            <td style="font-size: 14px;"> ${parseFloat(item.price_per_unity)}</td>
                            <td style="font-size: 14px;"> ${parseFloat(item.total_price)}</td>
                            <td style="font-size: 14px;"> ${item.storename}</td>
                            <td style="font-size: 14px;">${item.quantity}</td>
                            <td style="font-size: 14px;"> ${item.supplierNames}</td>
                            <td style="font-size: 14px;"> ${item.supplierPhone}</td>
                            <td style="font-size: 14px;">${item.purchase_date}</td>
                            
                        </tr>
                    `;
                }

                $("#sells_table").html(html); // Set the HTML content of the table
                 $("#excel_yesterday").html(excel); // Set the HTML content of the table
            } else {
                $("#sells_table").html("No results");
                $("#excel_yesterday").html("No results"); 
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
    // Ajax End!
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
  
  
  
  
  
  function View_WeekSalesRecord() {

    const currentDate = new Date();
const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1;
const day = currentDate.getDate();
const week = getWeekNumber(year, month, day);
console.log(week);

    var company_ID = parseInt(localStorage.getItem("CoID"));

    // Ajax Start!
    $.ajax({
        url: `functions/purchase/getalldaypurchasewithcompanysptweek.php?company=${company_ID}&week=${week}`,
        method: "POST",
        context: document.body,
        success: function(response) {
          try {
              console.log("Success Response: ", response);
  
              if (response.data && response.data.length > 0) {
                  let html = ""; // Initialize an empty string to store the HTML
                  let tot = "";
                  let btntype = "";
                  let excel = "";
                  let totexcel = "";
                  const sumtotal = response.sumtotal; // Access sumtotal
              
  
                  // Display sumtotal and sumbenefit as needed
                  console.log("Sum Total Amount: ", sumtotal);
                  
                
                
                
                 btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Weekly Purchase ,At Week <span>${week}</span></p>
                 <div>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchweeklysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelWeekTable', 'WeeklyPurchase_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button> </div> `;
                
                $("#btnsalesType").html(btntype);

        
                     
                  tot += `<tr>
                      <td style="font-size: 14px;"><strong></strong></td>
                      <td style="font-size: 14px;"><strong></strong></td>
                      <td style="font-size: 14px;"><strong></strong></td>
                      <td style="font-size: 14px;"><strong>Total Purchase Amount: ${new Intl.NumberFormat("en-US", {
                          style: "currency",
                          currency: "RWF",
                      }).format(parseFloat(sumtotal))}</strong></td>
                      <td style="font-size: 14px;"></td>
                      <td style="font-size: 14px;"><strong></strong></td>
                      <td style="font-size: 14px;"></td>
                  </tr>`;
                 $("#totalam").html(tot);
                 
                 totexcel += `
                
                <tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>${parseFloat(sumtotal)}</stong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong> </td>
                    <td style="font-size: 14px;"><strong></strong></td>
                </tr>
                
                `;
                $("#totalweekexcel").html(totexcel);
                     
           
                  
  
                  for (let i = 0; i < response.data.length; i++) {
                      const item = response.data[i];
  
                   console.log("item.id:", item.id);
                      console.log("item.product_id:", item.product_id);

                    

                    html += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}. ${item.name}</td>
                            <td style="font-size: 14px;">${item.quantity}</td>
                            <td style="font-size: 14px;"> ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                          }).format(parseFloat(item.price_per_unity))}</td>
                          <td style="font-size: 14px;"> ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                          }).format(parseFloat(item.total_price))}</td>
                          <td style="font-size: 14px;">${item.storename}</td>
                          <td style="font-size: 14px;">${item.supplierNames}</td>
                          <td style="font-size: 14px;">${item.supplierPhone}</td>
                            <td style="font-size: 14px;">${item.purchase_date}</td>
                            <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.id}','${item.product_id}','${item.purchase_date}','${item.quantity}','${item.price_per_unity}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.id}','${item.product_id}','${item.purchase_date}')" "><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `;
                    
                    
                    excel += `
                        <tr>
                            <td style="font-size: 14px;">${i+1}</td>
                            <td style="font-size: 14px;">${item.name}</td>
                            <td style="font-size: 14px;"> ${parseFloat(item.price_per_unity)}</td>
                            <td style="font-size: 14px;"> ${parseFloat(item.total_price)}</td>
                            <td style="font-size: 14px;"> ${item.storename}</td>
                            <td style="font-size: 14px;">${item.quantity}</td>
                            <td style="font-size: 14px;"> ${item.supplierNames}</td>
                            <td style="font-size: 14px;"> ${item.supplierPhone}</td>
                            <td style="font-size: 14px;">${item.purchase_date}</td>
                            
                        </tr>
                    `;
                      
                  }
  
                  $("#sells_table").html(html); // Set the HTML content of the table
                  $("#excel_week").html(excel);
              } else {
                  $("#sells_table").html("No results");
                  $("#excel_week").html("No results");
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
    // Ajax End!
}



function populateMonthDropdown() {
// Populate the month dropdown with options (e.g., from January to December)
const monthSelect = $("#monthSelect");
const currentDate = new Date();
const currentYear = currentDate.getFullYear();

for (let i = 1; i <= 12; i++) {
  const date = new Date(currentYear, i - 1, 1);
  if (!isNaN(date.getTime())) {
    const monthName = date.toLocaleString('default', { month: 'long' });
    const monthValue = currentYear + '-' + (i < 10 ? '0' : '') + i;
    monthSelect.append(new Option(monthName, monthValue));
  } else {
    console.error('Invalid date:', date);
  }
}
}





function View_YearSalesRecord() {

  const currentDate = new Date();
  const formattedStartDate = new Date(currentDate.getFullYear(), 0, 1).toISOString().split('T')[0];
  const formattedEndDate = new Date(currentDate.getFullYear(), 11, 31).toISOString().split('T')[0];

  const formatDate = (myDate) => {
      const dateParts = myDate.split("-");
      const year = dateParts[0];
      const month = dateParts[1];
      const day = dateParts[2];

      const formattedDate = new Date(year, month - 1, day).toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
      });

      return formattedDate;
  };

  $("#yearShow").html(formatDate(formattedStartDate) + ' - ' + formatDate(formattedEndDate));

  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!
  $.ajax({
      url: `functions/sales/getallYearlySales.php?startDate=${formattedStartDate}&endDate=${formattedEndDate}&company=${company_ID}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
          if (response) {
              $("#year_table").html(response);
          } else {
              $("#year_table").html("No results");
          }
      },
      error: function (xhr, status, error) {
          // Handle error
      },
  });
  // Ajax End!
}


function fetchdaterangesalesReport() {
  const fromdate = localStorage.getItem("fromdate")
  const todate = localStorage.getItem("todate")

  var company_ID = parseInt(localStorage.getItem("CoID"));

  if ( !company_ID) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/purchase/getallMonthlyPurchase.php?company=${company_ID}&startDate=${fromdate}&endDate=${todate}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        const typereport = "From "+fromdate+" To "+todate+" Purchase Report";
        printDailySalesReport(salesdata, sumtotal,typereport);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}


function fetchpickeddatesalesReport() {
  const date = localStorage.getItem("datepicked")
  var company_ID = parseInt(localStorage.getItem("CoID"));

  if ( !company_ID) {
    console.error(" Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/purchase/getalldaypurchasebyspt.php?date=${date}&company=${company_ID}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        const typereport = "Picked Date Purchase Report on "+date;
        printDailySalesReport(salesdata, sumtotal,typereport);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}



function fetchdailyBigReport(store_id) {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;

  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldayBigstock.php?store_id=${store_id}&date=${formattedDate}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        
        const typereport = "Daily Inventory Report on "+ formattedDate;
        printDailySalesReport(salesdata, sumtotal,typereport);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}


function fetchdailysalesReport() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;


  var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReport.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        
        const typereport = "Daily Summarized Report on "+ formattedDate;
        printDailySalesReport(salesdata, sumtotal,typereport);
    
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}

function fetchdailysalesReportfrom() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;


  var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReportFromStock.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        
        const typereport = "Daily Summarized Report on "+ formattedDate;
        printDailySalesReport(salesdata, sumtotal,typereport);
       
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}

function fetchdailyDynamicReport() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;


  var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/purchase/getalldaycombinationReport.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;

        
        const typereport = "Daily Summarized Report on "+ formattedDate;
        
        printDailyDynamicReport(salesdata,typereport);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}

function fetchweeklysalesReport() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth() + 1;
  const day = currentDate.getDate();
  const week = getWeekNumber(year, month, day);
  console.log(week);
  
      // Retrieve values from localStorage

      var company_ID = parseInt(localStorage.getItem("CoID"));
  
      // Ajax Start!
      $.ajax({
          url: `functions/purchase/getalldaypurchasewithcompanysptweek.php?company=${company_ID}&week=${week}`,
          method: 'GET',
          dataType: 'json',
          success: function (data) {
            if (data && data.data && data.data.length > 0) {
              const salesdata = data.data;
              const sumtotal = data.sumtotal;
              const typereport = "Weekly Purchase Report";
              printDailySalesReport(salesdata, sumtotal,typereport);
            } else {
              console.error('Empty or invalid data received from the server.');
            }
          },
          error: function (xhr, status, error) {
            console.error('Error fetching daily sales data:', error);
          }
        });
}






function fetchyesterdaysalesReport() {
  const currentDate = new Date();
  const yesterday = new Date(currentDate);
    yesterday.setDate(currentDate.getDate() - 1);
    
  const year = yesterday.getFullYear();
  const month = String(yesterday.getMonth() + 1).padStart(2, '0');
  const day = String(yesterday.getDate()).padStart(2, '0');
  
  const formattedDate = `${year}-${month}-${day}`;

   var company_ID = parseInt(localStorage.getItem("CoID"));

  if ( !company_ID) {
    console.error("Company ID or Sales Point ID is missing in localStorage.");
    return;
  }

  // Make an AJAX request to fetch appointment data
  $.ajax({
    url: `functions/purchase/getalldaypurchasebyspt.php?date=${formattedDate}&company=${company_ID}`,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data && data.data && data.data.length > 0) {
        const salesdata = data.data;
        const sumtotal = data.sumtotal;
        
        const typereport = "Yesterday Purchase Report";
        printDailySalesReport(salesdata, sumtotal, typereport);
      } else {
        console.error('Empty or invalid data received from the server.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error fetching daily sales data:', error);
    }
  });
}


function fetchmonthlysalesReport(store_id) {

  var selectedMonth = localStorage.getItem("monthSelect");
  


  console.log("Selected Month: " + selectedMonth);
  


  // Check if any of these values is undefined or empty
  if (!selectedMonth) {
      console.error("One or more required values are missing. Unable to make the AJAX request.");
      return; // Exit the function to prevent the AJAX request
  }
  const [year, month] = selectedMonth.split('-');

  // Calculate the start and end dates for the selected month
  const startDate = new Date(year, month - 1, 1); // Subtract 1 from month to make it zero-based
  const endDate = new Date(year, month, 0); // Setting day to 0 gets the last day of the previous month

  // Format the dates as YYYY-MM-DD
  const formattedStartDate = startDate.toISOString().slice(0, 10);
  const formattedEndDate = endDate.toISOString().slice(0, 10);

  console.log("Start Date: " + formattedStartDate);
  console.log("End Date: " + formattedEndDate);



      // Ajax Start!
      $.ajax({
        url: `functions/purchase/getalldaycombinationReportMonth.php?store_id=${store_id}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
          method: 'GET',
          dataType: 'json',
          success: function (data) {
            if (data && data.data && data.data.length > 0) {
              const salesdata = data.data;
              const sumtotal = data.sumtotal;
              const typereport = "Monthly Inventory Report";
              printDailySalesReport(salesdata, sumtotal,typereport);
            } else {
              console.error('Empty or invalid data received from the server.');
            }
          },
          error: function (xhr, status, error) {
            console.error('Error fetching daily sales data:', error);
          }
        });
}



function fetchyearlysalesReport() {

  var selectedYear = localStorage.getItem("yearSelect");
  
  var company_ID = localStorage.getItem("CoID");
  


  console.log("Selected Month: " + selectedYear);



  // Check if any of these values is undefined or empty
  if (!selectedYear ||  !company_ID) {
      console.error("One or more required values are missing. Unable to make the AJAX request.");
      return; // Exit the function to prevent the AJAX request
  }
  const startDate = selectedYear + "-01-01"; // Start of the year
  const endDate = selectedYear + "-12-31";   // End of the year

  console.log("Start Date: " + startDate);
  console.log("End Date: " + endDate);


      // Ajax Start!
      $.ajax({
          url:`functions/purchase/getallMonthlyPurchase.php?company=${company_ID}&startDate=${startDate}&endDate=${endDate}`,
          method: 'GET',
          dataType: 'json',
          success: function (data) {
            if (data && data.data && data.data.length > 0) {
              const salesdata = data.data;
              const sumtotal = data.sumtotal;
            
              const typereport = "Yearly Purchase Report";
              printDailySalesReport(salesdata, sumtotal, typereport);
            } else {
              console.error('Empty or invalid data received from the server.');
            }
          },
          error: function (xhr, status, error) {
            console.error('Error fetching daily sales data:', error);
          }
        });
}




function printDailySalesReport(salesdata,sumtotal,typereport) {
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

for (let i = 0; i < salesdata.length; i++) {
  const item = salesdata[i];
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.product_name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.opening_stock}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.entry_stock}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.totalstock}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.sold_stock}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.unit_price}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.totalprice}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.closing_stock}</td>
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
            Product
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Open
          </th>
  
           
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Entry
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Total
            </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            SOLD
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            UNIT/PRICE
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            TOTAL AMOUNT
            </th>
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
             CLOSING
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
            <strong></strong>
          </td>
          
        </tr>
        <tr>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
          </td>
          <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            <strong>Total Items :   ${(parseFloat(sumtotal))}</strong>
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

function printDailyDynamicReport(salesdata,typereport) {
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

for (let i = 0; i < salesdata.length; i++) {
  const item = salesdata[i];
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.product_name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.opening_stock}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.entry_stock}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.totalstock}</td>
      <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.sold_stock}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.closing_stock}</td>
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
            Product
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Open
          </th>
  
           
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Entry
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Total
            </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            SOLD
            </th>
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
             CLOSING
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

function getSalesID(sale_id,raw_material_id,purchase_date,quantity,price_per_unity){
     localStorage.setItem("saleID", sale_id);
        localStorage.setItem("raw_material_id", raw_material_id);
        localStorage.setItem("purchase_date", purchase_date);
        $("#editquantity").val(quantity);
        $("#editprice").val(price_per_unity);
        
        console.log("saleID ", sale_id);
        console.log("raw_material_id ", raw_material_id);
        console.log("purchase_date ", purchase_date);
     console.log("quantity ", quantity);
        console.log("quantity ", quantity);
}

function getSalesIDremove(sale_id,raw_material_id,purchase_date){
   localStorage.setItem("saleID", sale_id);
        localStorage.setItem("raw_material_id", raw_material_id);
        localStorage.setItem("purchase_date", purchase_date);
        console.log("saleID ", sale_id);
        console.log("raw_material_id ", raw_material_id);
        console.log("purchase_date ", purchase_date);
}

 function redirectToMonthlySales() {
            // Change the window.location.href to the desired URL
            window.location.href = '../client/monthlysales.php';
        }


 