$(document).ready(function () {
  View_DaySalesRecord(); 
  View_YearSalesRecord();
  populateMonthDropdown();
  $("#weeklysales").click(function () {
  
    View_WeekSalesRecord();
  });
  
  $("#yesterdaysales").click(function () {
  
    View_YesterdaySalesRecord();
  });

// picking from to date sales records


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

           var company_ID = localStorage.getItem("CoID");
           var sales_point_id = localStorage.getItem("SptID");


          // Make the AJAX request
  $.ajax({
      url: `functions/sales/getallMonthlySales.php?company=${company_ID}&spt=${sales_point_id}&startDate=${startDate}&endDate=${endDate}`,
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
                  const sumbenefit = response.sumbenefit; // Access sumbenefit
                  const sumtotalPaid = response.sumtotalPaid;
                  const sumbenefitPaid = response.sumbenefitPaid;
                  const sumtotalNotPaid = response.sumtotalNotPaid;
                  const sumbenefitNotPaid = response.sumbenefitNotPaid;
                  const sumtotalexpenses = response.sumtotalexpenses;
                  var usertype = localStorage.getItem("UserType");

                  // Display sumtotal and sumbenefit as needed
                  console.log("Sum Total Amount: ", sumtotal);
                  console.log("Sum Total Benefit: ", sumbenefit);
                  // Display sumtotalPaid and sumbenefitPaid
                  console.log("Sum Total Amount (Paid): ", sumtotalPaid);
                  console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
                  
                  // Display sumtotalNotPaid and sumbenefitNotPaid
                  console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
                  console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
                  console.log("Sum total expenses: ", sumtotalexpenses);
                  
                  

                  if(usertype==="BOSS"){

                    btntype += `<p class="text-primary m-0 fw-bold" style="font-size: 13px;"><span id="message"></span>From <span>${startDate}</span> To <span>${endDate}</span> Sales Records</p>
              
                    <div>
                      <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesPaidReport()"><i class="fa fa-dollar-sign"></i>
      
      Paid Sales </button>
                    <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchdaterangesalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
      
      Debts Sales </button>
                     </div>
                    
                    <div>
                    <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdaterangesalesReport()"><i class="fa fa-file-pdf"  style="margin-right:10px;"></i>Export in Pdf </button>
                    <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelfromtoTable', 'FromToSales_data')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>
                    </div>
                    `;
                    
                    $("#btnsalesType").html(btntype);

                   tot += `<tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                            }).format(parseFloat(sumbenefit))}</strong></td>
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
                   <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                   <td style="font-size: 14px;"><strong></strong></td>
               </tr>
              
               `;
               $("#totalfromtoexcel").html(totexcel);
                      
                  }else {
                    btntype += `<p class="text-primary m-0 fw-bold" style="font-size: 13px;"><span id="message"></span>From <span>${startDate}</span> To <span>${endDate}</span> Sales Records</p>
              
                    
                    `;
                    
                    $("#btnsalesType").html(btntype);


                    tot += `<tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"></td>
                         </tr>`;
                   $("#totalam").html(tot);
                   totexcel += `
              
               <tr>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></td>
                   <td style="font-size: 14px;"></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                     <td style="font-size: 14px;"><strong></strong> </td>
                   <td style="font-size: 14px;"><strong></strong></td>
               </tr>
              
               `;
               $("#totalfromtoexcel").html(totexcel);
                   
                  }
                         

                  for (let i = 0; i < response.data.length; i++) {
                      const item = response.data[i];

                      let sts = "";
                    let endis = "";
                    let icon = "";
                    let msg = "";
                    let stsstore = "";
                    let endistore = "";
                    let iconstore = "";
                    let msgstore = "";
                    let stsmanager = "";
                    let endimanager = "";
                    let iconmanager = "";
                    let msgmanager = "";

                    if (item.paid_status === "Paid") {
                        sts = "Active";
                        endis = "btn btn-success";
                        icon = "fa fa-check-square text-white";
                        msg = "Paid";
                    } else {
                        sts = "Not Active";
                        endis = "btn btn-danger";
                        icon = "bi bi-x-circle";
                        msg = "Debt";
                    }

                    

                    if (item.storekeeperaproval == 0) {
                        stsstore = "Active";
                        endistore = "btn btn-warning";
                        iconstore = "bi bi-x-circle";
                        msgstore = "Pending";
                    } else {
                        stsstore = "Not Active";
                        endistore = "btn btn-primary";
                        iconstore = "fa fa-check-square text-white";
                        msgstore = "Approved";
                    }
                    
                    if (item.manageraproval == 0) {
                      stsmanager = "Active";
                      endimanager = "btn btn-warning";
                      iconmanager = "bi bi-x-circle";
                      msgmanager = "Pending";
                  } else {
                      stsmanager = "Not Active";
                      endimanager = "btn btn-primary";
                      iconmanager = "fa fa-check-square text-white";
                      msgmanager = "Approved";
                  }
                  

                  html += `
                  <tr>
                  <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.sales_price))}</td>
                  <td style="font-size: 12px;">${item.quantity}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.total_amount))}</td>
                  <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodal(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodal(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                  <td style="font-size: 12px;">${item.created_time}</td>
                  <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
              </tr>
                  `;
                  
                      
                      excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
                      </tr>
                  `;
                      
                      
                  }

                  $("#sells_table").html(html); // Set the HTML content of the table
                  
              $("#excel_fromto").html(excel); 
                  
                  
              } else {
                  $("#sells_table").html("No results");
                   $("#excel_fromto").html("No results"); 
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

//picking date  sales record

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
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/sales/getalldaysaleswithcompanysptyyest.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
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
              const sumbenefit = response.sumbenefit; // Access sumbenefit
              const sumtotalPaid = response.sumtotalPaid;
              const sumbenefitPaid = response.sumbenefitPaid;
              const sumtotalNotPaid = response.sumtotalNotPaid;
              const sumbenefitNotPaid = response.sumbenefitNotPaid;
              const sumtotalexpenses = response.sumtotalexpenses;
              var usertype = localStorage.getItem("UserType");
                         

              // Display sumtotal and sumbenefit as needed
              console.log("Sum Total Amount: ", sumtotal);
              console.log("Sum Total Benefit: ", sumbenefit);
              // Display sumtotalPaid and sumbenefitPaid
              console.log("Sum Total Amount (Paid): ", sumtotalPaid);
              console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
              
              // Display sumtotalNotPaid and sumbenefitNotPaid
              console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumtotalexpenses);
              
              
               
              
              if(usertype==="BOSS"){


                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Custom Sales Record ,At <span>${formattedDate}</span></p>
               
                <div>
                 <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchPickedsalesPaidReport()"><i class="fa fa-dollar-sign"></i>
 
 Paid Sales </button>
               <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchPickedsalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
 
 Debts Sales </button>
                </div>
                <div>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchpickeddatesalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelPickedTable', 'PickedDateSales_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>
               </div>
               `;
               
               $("#btnsalesType").html(btntype);




               tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumbenefit))}</strong></td>
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
                  <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalpickexcel").html(totexcel);
              
              }else{

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Custom Sales Record ,At <span>${formattedDate}</span></p>
               
               `;
               
               $("#btnsalesType").html(btntype);



                tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"></td>
              </tr>`;
              $("#totalam").html(tot);
              
              totexcel += `
              
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalpickexcel").html(totexcel);
              
              }
             
              
              

              for (let i = 0; i < response.data.length; i++) {
                  const item = response.data[i];
                  
                    console.log("item.sales_id:", item.sale_id);
                    console.log("item.product_id:", item.product_id);

                    let sts = "";
                    let endis = "";
                    let icon = "";
                    let msg = "";
                    let stsstore = "";
                    let endistore = "";
                    let iconstore = "";
                    let msgstore = "";
                    let stsmanager = "";
                    let endimanager = "";
                    let iconmanager = "";
                    let msgmanager = "";

                    if (item.paid_status === "Paid") {
                        sts = "Active";
                        endis = "btn btn-success";
                        icon = "fa fa-check-square text-white";
                        msg = "Paid";
                    } else {
                        sts = "Not Active";
                        endis = "btn btn-danger";
                        icon = "bi bi-x-circle";
                        msg = "Debt";
                    }

                    

                    if (item.storekeeperaproval == 0) {
                        stsstore = "Active";
                        endistore = "btn btn-warning";
                        iconstore = "bi bi-x-circle";
                        msgstore = "Pending";
                    } else {
                        stsstore = "Not Active";
                        endistore = "btn btn-primary";
                        iconstore = "fa fa-check-square text-white";
                        msgstore = "Approved";
                    }
                    
                    if (item.manageraproval == 0) {
                      stsmanager = "Active";
                      endimanager = "btn btn-warning";
                      iconmanager = "bi bi-x-circle";
                      msgmanager = "Pending";
                  } else {
                      stsmanager = "Not Active";
                      endimanager = "btn btn-primary";
                      iconmanager = "fa fa-check-square text-white";
                      msgmanager = "Approved";
                  }
                  

                  html += `
                  <tr>
                  <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.sales_price))}</td>
                  <td style="font-size: 12px;">${item.quantity}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.total_amount))}</td>
                  <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodal(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodal(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                  <td style="font-size: 12px;">${item.created_time}</td>
                  <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
              </tr>
                  `;
                  
                  
                  
                  excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
                      </tr>
                  `;
              }

              $("#sells_table").html(html); // Set the HTML content of the table
               $("#excel_picked").html(excel); // Set the HTML content of the table
          } else {
              $("#sells_table").html("No results");
              $("#excel_picked").html("No results"); 
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














  $("#retrieveMonthlyData").on("click", function () {
      
    

  const selectedMonth = $("#monthSelect").val();
  const company_ID = localStorage.getItem("CoID");
  const salesPointID = localStorage.getItem("SptID");
  localStorage.removeItem("monthSelect");

  console.log("Selected Month: " + selectedMonth);
  console.log("Company ID (from localStorage): " + company_ID);
  console.log("Sales Point ID (from localStorage): " + salesPointID);

  // Check if any of these values is undefined or empty
  if (!selectedMonth || !company_ID || !salesPointID) {
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
  
  // Make the AJAX request
  $.ajax({
      url: `functions/sales/getallMonthlySales.php?company=${company_ID}&spt=${salesPointID}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
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
                  const sumbenefit = response.sumbenefit; // Access sumbenefit
                  const sumtotalPaid = response.sumtotalPaid;
                  const sumbenefitPaid = response.sumbenefitPaid;
                  const sumtotalNotPaid = response.sumtotalNotPaid;
                  const sumbenefitNotPaid = response.sumbenefitNotPaid;
                  const sumtotalexpenses = response.sumtotalexpenses;
                  var usertype = localStorage.getItem("UserType");

                  // Display sumtotal and sumbenefit as needed
                  console.log("Sum Total Amount: ", sumtotal);
                  console.log("Sum Total Benefit: ", sumbenefit);
                  // Display sumtotalPaid and sumbenefitPaid
                  console.log("Sum Total Amount (Paid): ", sumtotalPaid);
                  console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
                  
                  // Display sumtotalNotPaid and sumbenefitNotPaid
                  console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
                  console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
                  console.log("Sum total expenses: ", sumtotalexpenses);
                  
                  

                  if(usertype==="BOSS"){


                    btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Montly Sales,<span>${formattedStartDate}</span> - <span>${formattedEndDate}</span></p>
                  
                    <div>
                  <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchmonthlysalesPaidReport()"><i class="fa fa-dollar-sign"></i>
  
  Paid Sales </button>
                <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchmonthlysalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
  
  Debts Sales </button>
                 </div>
                <div>    
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchmonthlysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
                <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelMonthTable', 'MonthySales_data')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>
                </div>
                
                `;
                
                $("#btnsalesType").html(btntype);



                   tot += `<tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                              style: "currency",
                              currency: "RWF",
                            }).format(parseFloat(sumbenefit))}</strong></td>
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
                   <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                   <td style="font-size: 14px;"><strong></strong></td>
               </tr>
              
               `;
               $("#totalmonthexcel").html(totexcel);
                      
                  }else{

                    btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Montly Sales,<span>${formattedStartDate}</span> - <span>${formattedEndDate}</span></p>
                  
                `;
                
                $("#btnsalesType").html(btntype);



                    tot += `<tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"></td>
                            <td style="font-size: 14px;"></td>
                         </tr>`;
                   $("#totalam").html(tot);
                   totexcel += `
              
               <tr>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></td>
                   <td style="font-size: 14px;"></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                     <td style="font-size: 14px;"><strong></strong> </td>
                   <td style="font-size: 14px;"><strong></strong></td>
               </tr>
              
               `;
               $("#totalmonthexcel").html(totexcel);
                   
                  }
                         

                  for (let i = 0; i < response.data.length; i++) {
                      const item = response.data[i];

                      let sts = "";
                      let endis = "";
                      let icon = "";
                      let msg = "";
                      let stsstore = "";
                      let endistore = "";
                      let iconstore = "";
                      let msgstore = "";
                      let stsmanager = "";
                      let endimanager = "";
                      let iconmanager = "";
                      let msgmanager = "";
  
                      if (item.paid_status === "Paid") {
                          sts = "Active";
                          endis = "btn btn-success";
                          icon = "fa fa-check-square text-white";
                          msg = "Paid";
                      } else {
                          sts = "Not Active";
                          endis = "btn btn-danger";
                          icon = "bi bi-x-circle";
                          msg = "Debt";
                      }
  
                      
  
                      if (item.storekeeperaproval == 0) {
                          stsstore = "Active";
                          endistore = "btn btn-warning";
                          iconstore = "bi bi-x-circle";
                          msgstore = "Pending";
                      } else {
                          stsstore = "Not Active";
                          endistore = "btn btn-primary";
                          iconstore = "fa fa-check-square text-white";
                          msgstore = "Approved";
                      }
                      
                      if (item.manageraproval == 0) {
                        stsmanager = "Active";
                        endimanager = "btn btn-warning";
                        iconmanager = "bi bi-x-circle";
                        msgmanager = "Pending";
                    } else {
                        stsmanager = "Not Active";
                        endimanager = "btn btn-primary";
                        iconmanager = "fa fa-check-square text-white";
                        msgmanager = "Approved";
                    }
                    

                    html += `
                    <tr>
                    <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                    <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(item.sales_price))}</td>
                    <td style="font-size: 12px;">${item.quantity}</td>
                    <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(item.total_amount))}</td>
                    <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                    <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodal(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                    <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodal(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                    <td style="font-size: 12px;">${item.created_time}</td>
                    <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
                </tr>
                    `;
                    
                      
                      
                      excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
                      </tr>
                  `;
                      
                      
                  }

                  $("#sells_table").html(html); // Set the HTML content of the table
                  
              $("#excel_month").html(excel); 
                  
                  
              } else {
                  $("#sells_table").html("No results");
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


$("#retrieveYearlyData").on("click", function () {
const selectedYear = $("#yearSelect").val();
const company_ID = localStorage.getItem("CoID");
const salesPointID = localStorage.getItem("SptID");
localStorage.removeItem("yearSelect");

console.log("Selected Year: " + selectedYear);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + salesPointID);

// Check if any of these values is undefined or empty
if (!selectedYear || !company_ID || !salesPointID) {
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
    url: `functions/sales/getallYearlySales.php?company=${company_ID}&spt=${salesPointID}&startDate=${startDate}&endDate=${endDate}`,
    method: "POST",
    context: document.body,
    success: function(response) {
        try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                let html = ""; // Initialize an empty string to store the HTML
                let tot = "";
                let totexcel= "";
                let excel = "";
                let btntype = "";
                const sumtotal = response.sumtotal; // Access sumtotal
                const sumbenefit = response.sumbenefit; // Access sumbenefit
                const sumtotalPaid = response.sumtotalPaid;
                const sumbenefitPaid = response.sumbenefitPaid;
                  const sumtotalNotPaid = response.sumtotalNotPaid;
                  const sumbenefitNotPaid = response.sumbenefitNotPaid;
                  const sumtotalexpenses = response.sumtotalexpenses;
                  var usertype = localStorage.getItem("UserType");

                  // Display sumtotal and sumbenefit as needed
                  console.log("Sum Total Amount: ", sumtotal);
                  console.log("Sum Total Benefit: ", sumbenefit);
                  // Display sumtotalPaid and sumbenefitPaid
                  console.log("Sum Total Amount (Paid): ", sumtotalPaid);
                  console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
                  
                  // Display sumtotalNotPaid and sumbenefitNotPaid
                  console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
                  console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
                  console.log("sum total expenses: ", sumtotalexpenses);
                  
                  
                  
              
               
               if(usertype==="BOSS"){

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Yearly Sales, <span>${startDate}</span> - <span>${endDate}</span></p>
                   
                    <div>
                <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchyearlysalesPaidReport()"><i class="fa fa-dollar-sign"></i>

Paid Sales </button>
              <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchyearlysalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>

Debts Sales </button>
               </div>
                   
              <div>     
              <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchyearlysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
              <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelYearTable', 'YearlySales_data')"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>
              </div>
              
              `;
              
              $("#btnsalesType").html(btntype);



                tot += `<tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumbenefit))}</strong></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                
                 totexcel += `
              
//                 <tr>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                     <td style="font-size: 14px;"><strong></td>
//                     <td style="font-size: 14px;"></td>
//                     <td style="font-size: 14px;"><strong>${parseFloat(sumtotal)}</strong></td>
//                     <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                 </tr>
              
//                 `;
                
                $("#totalam").html(tot);
                 $("#totalyearexcel").html(totexcel);
               }else{


                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Yearly Sales, <span>${startDate}</span> - <span>${endDate}</span></p>
                   
                
          
          `;
          
          $("#btnsalesType").html(btntype);




                 tot += `<tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                 totexcel += `
              
//                 <tr>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                     <td style="font-size: 14px;"><strong></td>
//                     <td style="font-size: 14px;"></td>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                     <td style="font-size: 14px;"><strong></strong> </td>
//                     <td style="font-size: 14px;"><strong></strong></td>
//                 </tr>
              
//                 `;
                
                   $("#totalam").html(tot);
                    $("#totalyearexcel").html(totexcel);
               }   
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];

                    let sts = "";
                    let endis = "";
                    let icon = "";
                    let msg = "";
                    let stsstore = "";
                    let endistore = "";
                    let iconstore = "";
                    let msgstore = "";
                    let stsmanager = "";
                    let endimanager = "";
                    let iconmanager = "";
                    let msgmanager = "";

                    if (item.paid_status === "Paid") {
                        sts = "Active";
                        endis = "btn btn-success";
                        icon = "fa fa-check-square text-white";
                        msg = "Paid";
                    } else {
                        sts = "Not Active";
                        endis = "btn btn-danger";
                        icon = "bi bi-x-circle";
                        msg = "Debt";
                    }

                    

                    if (item.storekeeperaproval == 0) {
                        stsstore = "Active";
                        endistore = "btn btn-warning";
                        iconstore = "bi bi-x-circle";
                        msgstore = "Pending";
                    } else {
                        stsstore = "Not Active";
                        endistore = "btn btn-primary";
                        iconstore = "fa fa-check-square text-white";
                        msgstore = "Approved";
                    }
                    
                    if (item.manageraproval == 0) {
                      stsmanager = "Active";
                      endimanager = "btn btn-warning";
                      iconmanager = "bi bi-x-circle";
                      msgmanager = "Pending";
                  } else {
                      stsmanager = "Not Active";
                      endimanager = "btn btn-primary";
                      iconmanager = "fa fa-check-square text-white";
                      msgmanager = "Approved";
                  }
                  

                  html += `
                  <tr>
                  <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.sales_price))}</td>
                  <td style="font-size: 12px;">${item.quantity}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.total_amount))}</td>
                  <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodal(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodal(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                  <td style="font-size: 12px;">${item.created_time}</td>
                  <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
              </tr>
                  `;
                           
                     excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
                      </tr>
                  `;
                    
                }

                $("#sells_table").html(html); // Set the HTML content of the table

              $("#excel_year").html(excel);
            } else {
                $("#sells_table").html("No results");
                 $("#excel_year").html("No results");
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
// Ajax End!




$("#editBtnSales").on("click", function() {
      var product_id = localStorage.getItem("productID");
      var s_id = localStorage.getItem("saleID");
      var sess_id = localStorage.getItem("sessID");
      var quantity = $("#editquantity").val();

      $.ajax({
          type: "POST",
          url: "functions/sales/updatesales.php", // Update this with the actual path to your PHP script
          data: {
              product_id: product_id,
              quantity: quantity,
              s_id: s_id,
              sess_id:sess_id,
          },
          success: function(response) {
              if (response.message) {
              console.log(response.message);
             } else {
              console.log("Sale product updated successfully.");
              }
              $("#edit_sales_modal").modal("hide");
              localStorage.removeItem("productID");
              localStorage.removeItem("saleID");
              localStorage.removeItem("sessID");
              $("#editquantity").val("");
              setTimeout(function() {
              location.reload();
          }, 1000);
              
              
          },
          error: function(xhr, status, error) {
              console.log("Error: " + error);
              $("#edit_sales_modal").modal("hide");
              localStorage.removeItem("productID");
              localStorage.removeItem("saleID");
              localStorage.removeItem("sessID");
              $("#editquantity").val("");
              setTimeout(function() {
              location.reload();
          }, 1000);
              
              
          }
      });
  });


  $("#approvebtn").on("click", function() {
    var storeapproval = localStorage.getItem("storeapproval");
    var s_id = localStorage.getItem("sale_id");
    
    

    $.ajax({
        type: "POST",
        url: "functions/sales/approvedbyStorekeeper.php", // Update this with the actual path to your PHP script
        data: {
            s_id: s_id,
            storeapproval:storeapproval,
        },
        success: function(response) {
            
            console.log(response);
          
            $("#aprovalmodal").modal("hide");
            localStorage.removeItem("storeapproval");
            localStorage.removeItem("sale_id");
             View_DaySalesRecord();
          
         
            
            
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
            
        }
    });
});
$("#approvebtnyest").on("click", function() {
  var storeapproval = localStorage.getItem("storeapproval");
  var s_id = localStorage.getItem("sale_id");
  
  

  $.ajax({
      type: "POST",
      url: "functions/sales/approvedbyStorekeeper.php", // Update this with the actual path to your PHP script
      data: {
          s_id: s_id,
          storeapproval:storeapproval,
      },
      success: function(response) {
          
          console.log(response);
        
          $("#aprovalmodalyest").modal("hide");
          localStorage.removeItem("storeapproval");
          localStorage.removeItem("sale_id");
     
        View_YesterdaySalesRecord();
       
          
          
      },
      error: function(xhr, status, error) {
          console.log("Error: " + error);
          
      }
  });
});

$("#approvebtnweek").on("click", function() {
var storeapproval = localStorage.getItem("storeapproval");
var s_id = localStorage.getItem("sale_id");



$.ajax({
    type: "POST",
    url: "functions/sales/approvedbyStorekeeper.php", // Update this with the actual path to your PHP script
    data: {
        s_id: s_id,
        storeapproval:storeapproval,
    },
    success: function(response) {
        
        console.log(response);
      
        $("#aprovalmodalweek").modal("hide");
        localStorage.removeItem("storeapproval");
        localStorage.removeItem("sale_id");
   
      View_WeekSalesRecord();
     
        
        
    },
    error: function(xhr, status, error) {
        console.log("Error: " + error);
        
    }
});
});

$("#managerapprovebtn").on("click", function() {
  var managerapproval = localStorage.getItem("managerapproval");
  var s_id = localStorage.getItem("sale_id");
  
  

  $.ajax({
      type: "POST",
      url: "functions/sales/approvedbyManager.php", // Update this with the actual path to your PHP script
      data: {
          s_id: s_id,
          managerapproval:managerapproval,
      },
      success: function(response) {
          
          console.log(response);
        
          $("#aprovalmanagermodal").modal("hide");
          localStorage.removeItem("managerapproval");
          localStorage.removeItem("sale_id");
         View_DaySalesRecord();
          
       
          
          
      },
      error: function(xhr, status, error) {
          console.log("Error: " + error);
          
      }
  });
});

$("#managerapprovebtnyest").on("click", function() {
var managerapproval = localStorage.getItem("managerapproval");
var s_id = localStorage.getItem("sale_id");



$.ajax({
    type: "POST",
    url: "functions/sales/approvedbyManager.php", // Update this with the actual path to your PHP script
    data: {
        s_id: s_id,
        managerapproval:managerapproval,
    },
    success: function(response) {
        
        console.log(response);
      
        $("#aprovalmanagermodalyest").modal("hide");
        localStorage.removeItem("managerapproval");
        localStorage.removeItem("sale_id");
        
        View_YesterdaySalesRecord();
         
    },
    error: function(xhr, status, error) {
        console.log("Error: " + error);
        
    }
});
});

$("#managerapprovebtnweek").on("click", function() {
var managerapproval = localStorage.getItem("managerapproval");
var s_id = localStorage.getItem("sale_id");
console.log("sales_id " ,s_id);


$.ajax({
    type: "POST",
    url: "functions/sales/approvedbyManager.php", // Update this with the actual path to your PHP script
    data: {
        s_id: s_id,
        managerapproval:managerapproval,
    },
    success: function(response) {
        
        console.log(response);
      
        $("#aprovalmanagermodalweek").modal("hide");
        localStorage.removeItem("managerapproval");
        localStorage.removeItem("sale_id");
        
        View_WeekSalesRecord();
         
    },
    error: function(xhr, status, error) {
        console.log("Error: " + error);
        
    }
});
});



$("#deleteBtnSales").on("click", function() {
  var product_id = localStorage.getItem("productID");
  var s_id = localStorage.getItem("saleID");
  var sess_id = localStorage.getItem("sessID");
  const salesPointID = localStorage.getItem("SptID");

  $.ajax({
      type: "POST",
      url: "functions/sales/deletesales.php", // Update this with the actual path to your PHP script
      data: {
          sales_id: s_id, // Corrected variable name to match the PHP script
          product_id: product_id,
          sess_id: sess_id, // Corrected variable name to match the PHP script
          spt:salesPointID,
      },
      success: function(response) {
          if (response.message) {
              console.log(response.message);
          } else {
              console.log("Sale product deleted successfully.");
          }
          $("#delete_sales_modal").modal("hide");
          localStorage.removeItem("productID");
          localStorage.removeItem("saleID");
          localStorage.removeItem("sessID");
          $("#editquantity").val("");
          setTimeout(function() {
              location.reload();
          }, 1000);
          

      },
      error: function(xhr, status, error) {
          console.log("Error: " + error);
          $("#delete_sales_modal").modal("hide");
          localStorage.removeItem("productID");
          localStorage.removeItem("saleID");
          localStorage.removeItem("sessID");
          $("#editquantity").val("");
          setTimeout(function() {
              location.reload();
          }, 1000);

      }
  });
});






  
  
  
  
});



// Function to calculate week number
function getWeekNumber(year, month, day) {
// Create a new Date object with the provided year, month, and day
var date = new Date(year, month - 1, day);

// Set hours to avoid timezone discrepancies
date.setHours(0, 0, 0);

// Adjust the date to start of the week (Monday)
var dayOfWeek = date.getDay();
var mondayOffset = 1; // Monday is the first day of the week
var daysToMonday = (7 + dayOfWeek - mondayOffset) % 7;
date.setDate(date.getDate() - daysToMonday);

// Get the year of the first day of the year
var yearStart = new Date(year, 0, 1);

// Calculate the week number
var weekNo = Math.ceil((((date - yearStart) / 86400000) + 1) / 7);

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


function View_DaySalesRecord() {

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

  console.log('NEW TEST', formattedDate);


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
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/sales/getalldaysaleswithcompanyspt.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
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
              const sumbenefit = response.sumbenefit; // Access sumbenefit
              const sumtotalPaid = response.sumtotalPaid;
              const sumbenefitPaid = response.sumbenefitPaid;
              const sumtotalNotPaid = response.sumtotalNotPaid;
              const sumbenefitNotPaid = response.sumbenefitNotPaid;
              const sumtotalexpenses = response.sumtotalexpenses;
              var usertype = localStorage.getItem("UserType");
                         

              // Display sumtotal and sumbenefit as needed
              console.log("Sum Total Amount: ", sumtotal);
              console.log("Sum Total Benefit: ", sumbenefit);
              // Display sumtotalPaid and sumbenefitPaid
              console.log("Sum Total Amount (Paid): ", sumtotalPaid);
              console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
              
              // Display sumtotalNotPaid and sumbenefitNotPaid
              console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumtotalexpenses);
              
      
              
              if(usertype==="BOSS"){

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Daily Sales Record ,At <span>${formattedDate}</span></p>
                <div>
                <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchdailysalesPaidReport()"><i class="fa fa-dollar-sign"></i>
 
 Paid Sales </button>
               <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchdailysalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
 
 Debts Sales </button>
               </div>
               <div>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchdailysalesReport()"><i class="fa fa-file-pdf"></i>
 
 Export in Pdf </button>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelTable', 'dailySales_data');"><i class="fa fa-file-excel"></i>
 
 Export in Excel </button>  </div>`;
               
               $("#btnsalesType").html(btntype);




               tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumbenefit))}</strong></td>
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
                  <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalexcel").html(totexcel);
              
              }else if(usertype==="Manager"){

               
               $("#btnsalesType").html(" ");


                tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"></td>
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
              $("#totalexcel").html(totexcel);
              
              }else{

               
                $("#btnsalesType").html(" ");
 
 
                 tot += `
               <tr>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"></td>
                   <td style="font-size: 14px;"></td>
                   <td style="font-size: 14px;"></td>
               </tr>`;
               $("#totalam").html(tot);
               
               totexcel += `
               
               <tr>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></td>
                   <td style="font-size: 14px;"></td>
                   <td style="font-size: 14px;"><strong></strong></td>
                   <td style="font-size: 14px;"><strong></strong> </td>
                   <td style="font-size: 14px;"><strong></strong></td>
               </tr>
               
               `;
               $("#totalexcel").html(totexcel);
               
               }
             
              
              

              for (let i = 0; i < response.data.length; i++) {
                  const item = response.data[i];
                  
                    console.log("item.sales_id:", item.sale_id);
                    console.log("item.product_id:", item.product_id);

                  let sts = "";
                  let endis = "";
                  let icon = "";
                  let msg = "";
                  let stsstore = "";
                  let endistore = "";
                  let iconstore = "";
                  let msgstore = "";
                  let stsmanager = "";
                  let endimanager = "";
                  let iconmanager = "";
                  let msgmanager = "";

                  if (item.paid_status === "Paid") {
                      sts = "Active";
                      endis = "btn btn-success";
                      icon = "fa fa-check-square text-white";
                      msg = "Paid";
                  } else {
                      sts = "Not Active";
                      endis = "btn btn-danger";
                      icon = "bi bi-x-circle";
                      msg = "Debt";
                  }

                  

                  if (item.storekeeperaproval == 0) {
                      stsstore = "Active";
                      endistore = "btn btn-warning";
                      iconstore = "bi bi-x-circle";
                      msgstore = "Pending";
                  } else {
                      stsstore = "Not Active";
                      endistore = "btn btn-primary";
                      iconstore = "fa fa-check-square text-white";
                      msgstore = "Approved";
                  }
                  
                  if (item.manageraproval == 0) {
                    stsmanager = "Active";
                    endimanager = "btn btn-warning";
                    iconmanager = "bi bi-x-circle";
                    msgmanager = "Pending";
                } else {
                    stsmanager = "Not Active";
                    endimanager = "btn btn-primary";
                    iconmanager = "fa fa-check-square text-white";
                    msgmanager = "Approved";
                }

                  html += `
                      <tr>
                          <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                          <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                            style: "currency",
                            currency: "RWF",
                        }).format(parseFloat(item.sales_price))}</td>
                          <td style="font-size: 12px;">${item.quantity}</td>
                          <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                            style: "currency",
                            currency: "RWF",
                        }).format(parseFloat(item.total_amount))}</td>
                          <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodal(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                          <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodal(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                          <td style="font-size: 12px;">${item.created_time}</td>
                          <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
                      </tr>
                  `;
                  
                  
                  excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
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
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/sales/getalldaysaleswithcompanysptyyest.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
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
              const sumbenefit = response.sumbenefit; // Access sumbenefit
              const sumtotalPaid = response.sumtotalPaid;
              const sumbenefitPaid = response.sumbenefitPaid;
              const sumtotalNotPaid = response.sumtotalNotPaid;
              const sumbenefitNotPaid = response.sumbenefitNotPaid;
              const sumtotalexpenses = response.sumtotalexpenses;
              var usertype = localStorage.getItem("UserType");
                         

              // Display sumtotal and sumbenefit as needed
              console.log("Sum Total Amount: ", sumtotal);
              console.log("Sum Total Benefit: ", sumbenefit);
              // Display sumtotalPaid and sumbenefitPaid
              console.log("Sum Total Amount (Paid): ", sumtotalPaid);
              console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
              
              // Display sumtotalNotPaid and sumbenefitNotPaid
              console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumtotalexpenses);
              
              
               
              
              if(usertype==="BOSS"){

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Yesterday Sales Record ,At <span>${formattedDate}</span></p>
                <div>
                
                 <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchyesterdaysalesPaidReport()"><i class="fa fa-dollar-sign"></i>
 
 Paid Sales </button>
               <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchyesterdaysalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
 
 Debts Sales </button>
                </div>
                
                
               <div><button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;"  onclick="fetchyesterdaysalesReport()"><i class="fa fa-file-pdf"></i>
 Export in Pdf </button>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelYesterdayTable', 'YesterdaySales_data');"><i class="fa fa-file-excel"></i>
 Export in Excel </button></div>`;
               
               $("#btnsalesType").html(btntype);





               tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumtotal))}</strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                      style: "currency",
                      currency: "RWF",
                  }).format(parseFloat(sumbenefit))}</strong></td>
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
                  <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalyesterdayexcel").html(totexcel);
              
              }else{

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Yesterday Sales Record ,At <span>${formattedDate}</span></p>
                `;
               
               $("#btnsalesType").html(btntype);




                tot += `
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"></td>
              </tr>`;
              $("#totalam").html(tot);
              
              totexcel += `
              
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalyesterdayexcel").html(totexcel);
              
              }
             
              
              

              for (let i = 0; i < response.data.length; i++) {
                  const item = response.data[i];
                  
                    console.log("item.sales_id:", item.sale_id);
                    console.log("item.product_id:", item.product_id);

                    let sts = "";
                    let endis = "";
                    let icon = "";
                    let msg = "";
                    let stsstore = "";
                    let endistore = "";
                    let iconstore = "";
                    let msgstore = "";
                    let stsmanager = "";
                    let endimanager = "";
                    let iconmanager = "";
                    let msgmanager = "";

                    if (item.paid_status === "Paid") {
                        sts = "Active";
                        endis = "btn btn-success";
                        icon = "fa fa-check-square text-white";
                        msg = "Paid";
                    } else {
                        sts = "Not Active";
                        endis = "btn btn-danger";
                        icon = "bi bi-x-circle";
                        msg = "Debt";
                    }

                    

                    if (item.storekeeperaproval == 0) {
                        stsstore = "Active";
                        endistore = "btn btn-warning";
                        iconstore = "bi bi-x-circle";
                        msgstore = "Pending";
                    } else {
                        stsstore = "Not Active";
                        endistore = "btn btn-primary";
                        iconstore = "fa fa-check-square text-white";
                        msgstore = "Approved";
                    }
                    
                    if (item.manageraproval == 0) {
                      stsmanager = "Active";
                      endimanager = "btn btn-warning";
                      iconmanager = "bi bi-x-circle";
                      msgmanager = "Pending";
                  } else {
                      stsmanager = "Not Active";
                      endimanager = "btn btn-primary";
                      iconmanager = "fa fa-check-square text-white";
                      msgmanager = "Approved";
                  }
                  

                  html += `
                  <tr>
                  <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.sales_price))}</td>
                  <td style="font-size: 12px;">${item.quantity}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.total_amount))}</td>
                  <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodalyest(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodalyest(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                  <td style="font-size: 12px;">${item.created_time}</td>
                  <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
              </tr>
                  `;
                  
                  
                  excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
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

  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!
  $.ajax({
      url: `functions/sales/getalldaysaleswithcompanysptweek.php?company=${company_ID}&spt=${sales_point_id}&week=${week}`,
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
                const sumbenefit = response.sumbenefit; // Access sumbenefit
                const sumtotalPaid = response.sumtotalPaid;
                const sumbenefitPaid = response.sumbenefitPaid;
                const sumtotalNotPaid = response.sumtotalNotPaid;
                const sumbenefitNotPaid = response.sumbenefitNotPaid;
                const sumtotalexpenses = response.sumtotalexpenses;
                var usertype = localStorage.getItem("UserType");

                // Display sumtotal and sumbenefit as needed
                console.log("Sum Total Amount: ", sumtotal);
                console.log("Sum Total Benefit: ", sumbenefit);
                
                // Display sumtotalPaid and sumbenefitPaid
              console.log("Sum Total Amount (Paid): ", sumtotalPaid);
              console.log("Sum Total Benefit (Paid): ", sumbenefitPaid);
              
              // Display sumtotalNotPaid and sumbenefitNotPaid
              console.log("Sum Total Amount (Not Paid): ", sumtotalNotPaid);
              console.log("Sum Total Benefit (Not Paid): ", sumbenefitNotPaid);
              console.log("sum total expenses: ", sumtotalexpenses);
              
              
              
               

               if(usertype==="BOSS"){

                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Weekly Sales Record ,At Week <span>${week}</span></p>
                <div>
                <button class="btn btn-success"  style="font-size: 15px; font-weight: bold;" onclick="fetchweeklysalesPaidReport()"><i class="fa fa-dollar-sign"></i>
 
 Paid Sales </button>
               <button class="btn btn-danger" style="font-size: 15px; font-weight: bold;" onclick="fetchweeklysalesDebtsReport();"><i class="fa fa-money-bill-wave"></i>
 
 Debts Sales </button>
                
                </div>
                <div>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#a30603; color:white;" onclick="fetchweeklysalesReport()"><i class="fa fa-file-pdf" style="margin-right:10px;"></i>Export in Pdf </button>
               <button class="btn btn-light" style="font-size: 15px; font-weight: bold; background-color:#054d13; color:white;" onclick="exportTableToExcel('excelWeekTable', 'WeeklySales_data');"><i class="fa fa-file-excel" style="margin-right:10px;"></i>Export in Excel </button>
               </div>
               `;
               
               $("#btnsalesType").html(btntype);

                   
                tot += `<tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong>Total Sales: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumtotal))}</strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"><strong>Gross Profit: ${new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "RWF",
                    }).format(parseFloat(sumbenefit))}</strong></td>
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
                  <td style="font-size: 14px;"><strong>${parseFloat(sumbenefit)}</strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalweekexcel").html(totexcel);
                   
               }else{


                btntype += `<p class="text-primary m-0 fw-bold"><span id="message"></span>Weekly Sales Record ,At Week <span>${week}</span></p>
                
               `;
               
               $("#btnsalesType").html(btntype);


                 tot += `<tr>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"><strong></strong></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                    <td style="font-size: 14px;"></td>
                </tr>`;
                $("#totalam").html(tot);
                totexcel += `
              
              <tr>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></td>
                  <td style="font-size: 14px;"></td>
                  <td style="font-size: 14px;"><strong></strong></td>
                  <td style="font-size: 14px;"><strong></strong> </td>
                  <td style="font-size: 14px;"><strong></strong></td>
              </tr>
              
              `;
              $("#totalweekexcel").html(totexcel);
                
               }
              
                

                for (let i = 0; i < response.data.length; i++) {
                    const item = response.data[i];

                    let sts = "";
                    let endis = "";
                    let icon = "";
                    let msg = "";
                    let stsstore = "";
                    let endistore = "";
                    let iconstore = "";
                    let msgstore = "";
                    let stsmanager = "";
                    let endimanager = "";
                    let iconmanager = "";
                    let msgmanager = "";

                    if (item.paid_status === "Paid") {
                        sts = "Active";
                        endis = "btn btn-success";
                        icon = "fa fa-check-square text-white";
                        msg = "Paid";
                    } else {
                        sts = "Not Active";
                        endis = "btn btn-danger";
                        icon = "bi bi-x-circle";
                        msg = "Debt";
                    }

                    

                    if (item.storekeeperaproval == 0) {
                        stsstore = "Active";
                        endistore = "btn btn-warning";
                        iconstore = "bi bi-x-circle";
                        msgstore = "Pending";
                    } else {
                        stsstore = "Not Active";
                        endistore = "btn btn-primary";
                        iconstore = "fa fa-check-square text-white";
                        msgstore = "Approved";
                    }
                    
                    if (item.manageraproval == 0) {
                      stsmanager = "Active";
                      endimanager = "btn btn-warning";
                      iconmanager = "bi bi-x-circle";
                      msgmanager = "Pending";
                  } else {
                      stsmanager = "Not Active";
                      endimanager = "btn btn-primary";
                      iconmanager = "fa fa-check-square text-white";
                      msgmanager = "Approved";
                  }
                  

                  html += `
                  <tr>
                  <td style="font-size: 12px;">${i+1}. ${item.Product_Name}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.sales_price))}</td>
                  <td style="font-size: 12px;">${item.quantity}</td>
                  <td style="font-size: 12px;"> ${new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "RWF",
                }).format(parseFloat(item.total_amount))}</td>
                  <td style="font-size: 12px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msg}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endistore}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightstoremodalweek(${item.storekeeperaproval},${item.sale_id})"><i class="${iconstore}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgstore}</span></button></td>
                  <td style="font-size: 12px;"><button class="${endimanager}" type="button" style="margin-left: 20px;width: 100px;color: rgb(255,255,255);font-weight: bold;" onclick="getrightmanagermodalweek(${item.manageraproval},${item.sale_id})"><i class="${iconmanager}"></i>&nbsp; <span style="font-size: 11px; font-weight=bold; ">${msgmanager}</span></button></td>
                  <td style="font-size: 12px;">${item.created_time}</td>
                  <td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}','${item.sess_id}','${item.product_id}')" "><i class="fa fa-trash"></i></button></td>
              </tr>
                  `;
                  
                   excel += `
                      <tr>
                          <td style="font-size: 14px;">${i+1}</td>
                          <td style="font-size: 14px;">${item.Product_Name}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.sales_price)}</td>
                          <td style="font-size: 14px;">${item.quantity}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_amount)}</td>
                          <td style="font-size: 14px;"> ${parseFloat(item.total_benefit)}</td>
                          <td style="font-size: 14px;"><button class="${endis}" type="button" style="margin-left: 20px;width: 108.4531px;color: rgb(255,255,255);font-weight: bold;"><i class="${icon}"></i>&nbsp; <span style="font-size: 14px; font-weight=bold; ">${msg}</span></button></td>
                          <td style="font-size: 14px;">${item.created_time}</td>
                          
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


function fetchdaterangesalesDebtsReport() {
const fromdate = localStorage.getItem("fromdate")
const todate = localStorage.getItem("todate")
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getallMonthlySalesDebts.php?company=${company_ID}&spt=${sales_point_id}&startDate=${fromdate}&endDate=${todate}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalNotPaid;
      const sumbenefitPaid = data.sumbenefitNotPaid;
      const typereport = "From "+fromdate+" To "+todate+" Debts Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}



function fetchdaterangesalesPaidReport() {
const fromdate = localStorage.getItem("fromdate")
const todate = localStorage.getItem("todate")
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getallMonthlySalesPaid.php?company=${company_ID}&spt=${sales_point_id}&startDate=${fromdate}&endDate=${todate}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const typereport = "From "+fromdate+" To "+todate+" Paid Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}

function fetchdaterangesalesReport() {
const fromdate = localStorage.getItem("fromdate")
const todate = localStorage.getItem("todate")
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getallMonthlySales.php?company=${company_ID}&spt=${sales_point_id}&startDate=${fromdate}&endDate=${todate}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotal = data.sumtotal;
      const sumbenefit = data.sumbenefit;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const sumtotalNotPaid = data.sumtotalNotPaid;
      const sumbenefitNotPaid = data.sumbenefitNotPaid;
      const sumtotalexpenses = data.sumtotalexpenses;
      const typereport = "From "+fromdate+" To "+todate+" Sales Report";
      printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid,sumtotalexpenses);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}

function fetchPickedsalesDebtsReport() {
const date = localStorage.getItem("datepicked")
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptDebts.php?date=${date}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalNotPaid;
      const sumbenefitPaid = data.sumbenefitNotPaid;
      const typereport = "Picked Date Paid Sales Report on "+date;
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}


function fetchPickedsalesPaidReport() {
const date = localStorage.getItem("datepicked")
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptPaid.php?date=${date}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const typereport = "Picked Date Paid Sales Report on "+date;
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
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
const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptyyest.php?date=${date}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotal = data.sumtotal;
      const sumbenefit = data.sumbenefit;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const sumtotalNotPaid = data.sumtotalNotPaid;
      const sumbenefitNotPaid = data.sumbenefitNotPaid;
      const sumtotalexpenses = data.sumtotalexpenses;
      const typereport = "Picked Date Sales Report on "+date;
      printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid,sumtotalexpenses);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}

function fetchdailysalesDebtsReport() {
const currentDate = new Date();
const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');
const formattedDate = `${year}-${month}-${day}`;

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptDebts.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalNotPaid;
      const sumbenefitPaid = data.sumbenefitNotPaid;
      const typereport = "Daily Debts Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}


function fetchdailysalesPaidReport() {
const currentDate = new Date();
const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');
const formattedDate = `${year}-${month}-${day}`;

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptPaid.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const typereport = "Daily Paid Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
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

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanyspt.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotal = data.sumtotal;
      const sumbenefit = data.sumbenefit;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const sumtotalNotPaid = data.sumtotalNotPaid;
      const sumbenefitNotPaid = data.sumbenefitNotPaid;
      const sumtotalexpenses = data.sumtotalexpenses;
      const typereport = "Daily Sales Report";
      printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid,sumtotalexpenses);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}



function fetchweeklysalesDebtsReport() {
const currentDate = new Date();
const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1;
const day = currentDate.getDate();
const week = getWeekNumber(year, month, day);
console.log(week);

    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/sales/getalldaysaleswithcompanysptweekDebts.php?company=${company_ID}&spt=${sales_point_id}&week=${week}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalNotPaid;
      const sumbenefitPaid = data.sumbenefitNotPaid;
            const typereport = "Weekly Debts Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}



function fetchweeklysalesPaidReport() {
const currentDate = new Date();
const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1;
const day = currentDate.getDate();
const week = getWeekNumber(year, month, day);
console.log(week);

    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/sales/getalldaysaleswithcompanysptweekPaid.php?company=${company_ID}&spt=${sales_point_id}&week=${week}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const typereport = "Weekly Paid Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
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
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");

    // Ajax Start!
    $.ajax({
        url: `functions/sales/getalldaysaleswithcompanysptweek.php?company=${company_ID}&spt=${sales_point_id}&week=${week}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotal = data.sumtotal;
            const sumbenefit = data.sumbenefit;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const sumtotalNotPaid = data.sumtotalNotPaid;
            const sumbenefitNotPaid = data.sumbenefitNotPaid;
            const sumtotalexpenses = data.sumtotalexpenses;
            const typereport = "Weekly Sales Report";
            printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid,sumtotalNotPaid,sumtotalexpenses);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}


function fetchyesterdaysalesDebtsReport() {
const currentDate = new Date();
const yesterday = new Date(currentDate);
  yesterday.setDate(currentDate.getDate() - 1);
  
const year = yesterday.getFullYear();
const month = String(yesterday.getMonth() + 1).padStart(2, '0');
const day = String(yesterday.getDate()).padStart(2, '0');

const formattedDate = `${year}-${month}-${day}`;

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptDebts.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalNotPaid;
      const sumbenefitPaid = data.sumbenefitNotPaid;
      const typereport = "Yesterday Debts Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}


function fetchyesterdaysalesPaidReport() {
const currentDate = new Date();
const yesterday = new Date(currentDate);
  yesterday.setDate(currentDate.getDate() - 1);
  
const year = yesterday.getFullYear();
const month = String(yesterday.getMonth() + 1).padStart(2, '0');
const day = String(yesterday.getDate()).padStart(2, '0');

const formattedDate = `${year}-${month}-${day}`;

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptPaid.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const typereport = "Yesterday Paid Sales Report";
      printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}

function fetchyesterdayMessagesalesReport(formattedDate,company_ID,sales_point_id) {
//   const currentDate = new Date();
//   const yesterday = new Date(currentDate);
//     yesterday.setDate(currentDate.getDate() - 1);
  
//   const year = yesterday.getFullYear();
//   const month = String(yesterday.getMonth() + 1).padStart(2, '0');
//   const day = String(yesterday.getDate()).padStart(2, '0');

// //   const formattedDate = `${year}-${month}-${day}`;

//   const company_ID = localStorage.getItem("companysel");
//   const sales_point_id = localStorage.getItem("SptID");
//   const formattedDate = localStorage.getItem("datesel");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanyspt.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotal = data.sumtotal;
      const sumbenefit = data.sumbenefit;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const sumtotalNotPaid = data.sumtotalNotPaid;
      const sumbenefitNotPaid = data.sumbenefitNotPaid;
      const sumtotalexpenses = data.sumtotalexpenses;
      const typereport = "Yesterday Sales Report";
      printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid,sumtotalexpenses);
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

const company_ID = localStorage.getItem("CoID");
const sales_point_id = localStorage.getItem("SptID");

if (!company_ID || !sales_point_id) {
  console.error("Company ID or Sales Point ID is missing in localStorage.");
  return;
}

// Make an AJAX request to fetch appointment data
$.ajax({
  url: `functions/sales/getalldaysaleswithcompanysptyyest.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    if (data && data.data && data.data.length > 0) {
      const salesdata = data.data;
      const sumtotal = data.sumtotal;
      const sumbenefit = data.sumbenefit;
      const sumtotalPaid = data.sumtotalPaid;
      const sumbenefitPaid = data.sumbenefitPaid;
      const sumtotalNotPaid = data.sumtotalNotPaid;
      const sumbenefitNotPaid = data.sumbenefitNotPaid;
      const sumtotalexpenses = data.sumtotalexpenses;
      const typereport = "Yesterday Sales Report";
      printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid,sumtotalexpenses);
    } else {
      console.error('Empty or invalid data received from the server.');
    }
  },
  error: function (xhr, status, error) {
    console.error('Error fetching daily sales data:', error);
  }
});
}

function fetchmonthlysalesDebtsReport() {

var selectedMonth = localStorage.getItem("monthSelect");

var company_ID = localStorage.getItem("CoID");
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedMonth);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);

// Check if any of these values is undefined or empty
if (!selectedMonth || !company_ID || !sales_point_id) {
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
        url:`functions/sales/getallMonthlySalesDebts.php?company=${company_ID}&spt=${sales_point_id}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalNotPaid;
            const sumbenefitPaid = data.sumbenefitNotPaid;
            const typereport = "Monthly Debts Sales Report";
            printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}



function fetchmonthlysalesPaidReport() {

var selectedMonth = localStorage.getItem("monthSelect");

var company_ID = localStorage.getItem("CoID");
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedMonth);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);

// Check if any of these values is undefined or empty
if (!selectedMonth || !company_ID || !sales_point_id) {
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
        url:`functions/sales/getallMonthlySalesPaid.php?company=${company_ID}&spt=${sales_point_id}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const typereport = "Monthly Paid Sales Report";
            printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}




function fetchmonthlysalesReport() {

var selectedMonth = localStorage.getItem("monthSelect");

var company_ID = localStorage.getItem("CoID");
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedMonth);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);

// Check if any of these values is undefined or empty
if (!selectedMonth || !company_ID || !sales_point_id) {
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
        url:`functions/sales/getallMonthlySales.php?company=${company_ID}&spt=${sales_point_id}&startDate=${formattedStartDate}&endDate=${formattedEndDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotal = data.sumtotal;
            const sumbenefit = data.sumbenefit;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const sumtotalNotPaid = data.sumtotalNotPaid;
            const sumbenefitNotPaid = data.sumbenefitNotPaid;
             const sumtotalexpenses = data.sumtotalexpenses;
            const typereport = "Monthly Sales Report";
            printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid,sumtotalNotPaid,sumtotalexpenses);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}


function fetchyearlysalesDebtsReport() {

var selectedYear = localStorage.getItem("yearSelect");

var company_ID = localStorage.getItem("CoID");
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedYear);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);


// Check if any of these values is undefined or empty
if (!selectedYear || !company_ID || !sales_point_id) {
    console.error("One or more required values are missing. Unable to make the AJAX request.");
    return; // Exit the function to prevent the AJAX request
}
const startDate = selectedYear + "-01-01"; // Start of the year
const endDate = selectedYear + "-12-31";   // End of the year

console.log("Start Date: " + startDate);
console.log("End Date: " + endDate);


    // Ajax Start!
    $.ajax({
        url:`functions/sales/getallMonthlySalesDebts.php?company=${company_ID}&spt=${sales_point_id}&startDate=${startDate}&endDate=${endDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalNotPaid;
            const sumbenefitPaid = data.sumbenefitNotPaid;
            const typereport = "Yearly Debts Sales Report";
            printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}



function fetchyearlysalesPaidReport() {

var selectedYear = localStorage.getItem("yearSelect");

var company_ID = localStorage.getItem("CoID");
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedYear);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);


// Check if any of these values is undefined or empty
if (!selectedYear || !company_ID || !sales_point_id) {
    console.error("One or more required values are missing. Unable to make the AJAX request.");
    return; // Exit the function to prevent the AJAX request
}
const startDate = selectedYear + "-01-01"; // Start of the year
const endDate = selectedYear + "-12-31";   // End of the year

console.log("Start Date: " + startDate);
console.log("End Date: " + endDate);


    // Ajax Start!
    $.ajax({
        url:`functions/sales/getallMonthlySalesPaid.php?company=${company_ID}&spt=${sales_point_id}&startDate=${startDate}&endDate=${endDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const typereport = "Yearly Paid Sales Report";
            printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid);
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
var sales_point_id = localStorage.getItem("SptID");


console.log("Selected Month: " + selectedYear);
console.log("Company ID (from localStorage): " + company_ID);
console.log("Sales Point ID (from localStorage): " + sales_point_id);


// Check if any of these values is undefined or empty
if (!selectedYear || !company_ID || !sales_point_id) {
    console.error("One or more required values are missing. Unable to make the AJAX request.");
    return; // Exit the function to prevent the AJAX request
}
const startDate = selectedYear + "-01-01"; // Start of the year
const endDate = selectedYear + "-12-31";   // End of the year

console.log("Start Date: " + startDate);
console.log("End Date: " + endDate);


    // Ajax Start!
    $.ajax({
        url:`functions/sales/getallYearlySales.php?company=${company_ID}&spt=${sales_point_id}&startDate=${startDate}&endDate=${endDate}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data && data.data && data.data.length > 0) {
            const salesdata = data.data;
            const sumtotal = data.sumtotal;
            const sumbenefit = data.sumbenefit;
            const sumtotalPaid = data.sumtotalPaid;
            const sumbenefitPaid = data.sumbenefitPaid;
            const sumtotalNotPaid = data.sumtotalNotPaid;
            const sumbenefitNotPaid = data.sumbenefitNotPaid;
            const sumtotalexpenses = data.sumtotalexpenses;
            const typereport = "Yearly Sales Report";
            printDailySalesReport(salesdata, sumtotal, sumbenefit,typereport,sumtotalPaid,sumtotalNotPaid,sumtotalexpenses);
          } else {
            console.error('Empty or invalid data received from the server.');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
        }
      });
}




function printDailySalesReport(salesdata,sumtotal,sumbenefit,typereport,sumtotalPaid, sumtotalNotPaid, sumtotalexpenses) {
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
const netprofit = sumbenefit - sumtotalexpenses; 


let table = '';

for (let i = 0; i < salesdata.length; i++) {
const item = salesdata[i];
table += `<tr >
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.Product_Name}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(parseFloat(item.sales_price))}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color:${ item.paid_status == "Paid" ? "green" : "red" }; font-weight: bold;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.paid_status}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(parseFloat(item.total_amount))}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
style: "currency",
currency: "RWF",
}).format(parseFloat(item.total_benefit))}</td>
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
          Item
          </th>
        <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
        Quantity
        </th>

         

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Price
          </th> 
          
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
          Paid Status
          </th>

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
          Sales Amount
          </th>

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
           Benefit
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
          <strong>Cash Sales :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumtotalPaid))}</strong>
        </td>
        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Gross Profit :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumbenefit))}</strong>
        </td>
      </tr>
      
        <tr>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Credit Sales :  ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumtotalNotPaid))}</strong>
        </td>
        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Total Expenses :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumtotalexpenses))}</strong>
        </td>
        
      </tr>
      <tr>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Total Sales :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumtotal))}</strong>
        </td>
        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Net Profit :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(netprofit))}</strong>
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





function printDailyPaidAndDebtsSalesReport(salesdata,typereport,sumtotalPaid,sumbenefitPaid) {
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
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.Product_Name}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(parseFloat(item.sales_price))}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color:${ item.paid_status == "Paid" ? "green" : "red" }; font-weight: bold;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.paid_status}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(parseFloat(item.total_amount))}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${new Intl.NumberFormat("en-US", {
style: "currency",
currency: "RWF",
}).format(parseFloat(item.total_benefit))}</td>
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
          Item
          </th>
        <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
        Quantity
        </th>

         

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Price
          </th> 
          
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
          Paid Status
          </th>

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
          Sales Amount
          </th>

          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
           Benefit
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
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Total Sales :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumtotalPaid))}</strong>
        </td>
        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          
        </td>
        <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
          <strong>Benefit :   ${new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "RWF",
        }).format(parseFloat(sumbenefitPaid))}</strong>
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

function getSalesID(sale_id, sess_id, product_id){
   localStorage.setItem("saleID", sale_id);
      localStorage.setItem("productID", product_id);
      localStorage.setItem("sessID", sess_id);
      
      console.log("saleID ", sale_id);
      console.log("productID ", product_id);
      console.log("sessID ", sess_id);
  
}

function redirectToMonthlySales() {
          // Change the window.location.href to the desired URL
          window.location.href = '../client/monthlysales.php';
      }





      function getrightstoremodal(storekeeper,sale_id){
        console.log("Store keeper", storekeeper);

        var usertype = localStorage.getItem("UserType");
        if(usertype === "EndUser"){
       if(storekeeper== 0){
          $("#aprovalmodal").modal("show");
          localStorage.setItem("storeapproval",storekeeper);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaproved").modal("show");
        }
        }else{
          $("#notallowedmodal").modal("show");
        }
        
    
      }
    
      function getrightmanagermodal(manager,sale_id){
        console.log("manager appreoval", manager);
    
        var usertype = localStorage.getItem("UserType");
    
        if(usertype === "BOSS"){
         if(manager== 0){
          $("#aprovalmanagermodal").modal("show");
          localStorage.setItem("managerapproval",manager);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaprovedbymanager").modal("show");
        } 
        }else{
          $("#notallowedmodal").modal("show");
        }
    
        
      }
    
    
      function getrightstoremodalyest(storekeeper,sale_id){
        console.log("Store keeper", storekeeper);

        var usertype = localStorage.getItem("UserType");
        if(usertype === "EndUser"){
    
        if(storekeeper== 0){
          $("#aprovalmodalyest").modal("show");
          localStorage.setItem("storeapproval",storekeeper);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaproved").modal("show");
        }
      }else{
        $("#notallowedmodal").modal("show");
      }
    
      }
    
      function getrightmanagermodalyest(manager,sale_id){
        console.log("manager appreoval", manager);
    
        var usertype = localStorage.getItem("UserType");
    
        if(usertype === "BOSS"){
         if(manager== 0){
          $("#aprovalmanagermodalyest").modal("show");
          localStorage.setItem("managerapproval",manager);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaprovedbymanager").modal("show");
        } 
        }else{
          $("#notallowedmodal").modal("show");
        }
    
        
      }



      function getrightstoremodalweek(storekeeper,sale_id){
        console.log("Store keeper", storekeeper);

        var usertype = localStorage.getItem("UserType");
        if(usertype === "EndUser"){
    
        if(storekeeper== 0){
          $("#aprovalmodalweek").modal("show");
          localStorage.setItem("storeapproval",storekeeper);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaproved").modal("show");
        }

      }else{
        $("#notallowedmodal").modal("show");
      }
    
      }
    
      function getrightmanagermodalweek(manager,sale_id){
        console.log("manager appreoval", manager);
    
        var usertype = localStorage.getItem("UserType");
    
        if(usertype === "BOSS"){
         if(manager== 0){
          $("#aprovalmanagermodalweek").modal("show");
          localStorage.setItem("managerapproval",manager);
          localStorage.setItem("sale_id",sale_id);
        }else{
          $("#alreadyaprovedbymanager").modal("show");
        } 
        }else{
          $("#notallowedmodal").modal("show");
        }
    
        
      }

  