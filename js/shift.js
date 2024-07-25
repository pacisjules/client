$(document).ready(function () {
  var shift_id = getParameterByName('shift_id'); 
  var from = getParameterByName('from'); 
  var to = getParameterByName('to');  
  View_allusershiftRecords();
  
  View_LoginRecords(); 
  View_shiftRecords(); 
  

    SelectEditCustomer();
    SelectDeleteCustomer();
    SelectExpand();
    
    $("#backtostock").click(function () {
      window.location.href = `shift`;
         
      });


      
  var company_ID = localStorage.getItem("CoID");
  var spt = localStorage.getItem("SptID");

  // Make an AJAX request to fetch data by customer_id
  // $.ajax({
  //   url: `functions/shift/getalluserbyshift.php?company=${company_ID}&shift_id=${shift_id}`,
  //   method: 'GET',
  //   success: function(data) {
  //     // Handle the data received from the AJAX request and display it in the table
  //     var html = '';
  //     var shiftname = data.data[0].shift_name;
 
  //      var num = 0;                       
  //     $.each(data.data, function(index, item) {
  //       num += 1; 
          
  //       html += '<tr>';
  //       html += '<td>'+num+'. ' + item.first_name + '</td>';
  //       html += '<td>' + item.last_name + '</td>';
  //       html += '<td>' + item.username + '</td>';
  //       html += '<td>' + item.email + '</td>';
  //       html += '<td>' + item.phone + '</td>';
  //       html += '<td>' + item.category_name + '</td>';
  //       html += `<td class="d-flex flex-row justify-content-start align-items-center">
  //       <button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.id}','${item.shift_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
  //       <button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.id}','${item.shift_id}')" "><i class="fa fa-trash"></i></button>     
               
  //        </td> `; 
  //       html += '</tr>';
  //     });
  //     $('#usershift_table').html(html);
  //     $('#shiftname').html(shiftname);
      
  //   },
  //   error: function() {
  //     alert('An error occurred while fetching user shift details.');
  //   }
  // });
    



  $.ajax({
    url: `functions/sales/getallShiftSales.php?company=${company_ID}&spt=${spt}&startDate=${from}&endDate=${to}`,
    method: 'GET',
    success: function(data) {
      // Handle the data received from the AJAX request and display it in the table
      var html = '';
 
       var num = 0;                       
      $.each(data.data, function(index, item) {
        num += 1; 
          
        html += '<tr>';
        html += '<td>'+num+'. ' + item.Product_Name + '</td>';
        html += '<td>' + item.quantity + '</td>';
        html += '<td>' + item.sales_price + '</td>';
        html += '<td>' + item.total_amount + '</td>';
        html += '<td>' + item.created_time + '</td>';
        html += '<td>' + item.paid_status + '</td>';
        html += `<td class="d-flex flex-row justify-content-start align-items-center">
        <button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.sale_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button>
        <button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.sale_id}')" "><i class="fa fa-trash"></i></button>     
               
         </td> `; 
        html += '</tr>';
      });
      $('#shift_detail').html(html);
    
      
    },
    error: function() {
      alert('An error occurred while fetching user shift details.');
    }
  });















            // Function to get URL query parameters
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }
    
 
  
    $("#addSHIFT").click(function () {
      // Retrieve values from input fields
      var names = $("#names").val();
      var starttime = $("#starttime").val();
      var endtime = $("#endtime").val();
     
      var sales_point_id = localStorage.getItem("SptID");
      var company = localStorage.getItem("CoID");
  
      // Start AJAX request
      $.ajax({
        url: "functions/shift/addnewSHIFT.php",
        method: "POST",
        data: {
          names: names,
          spt: sales_point_id,
          company:company,
          starttime:starttime,
          endtime:endtime
          
        },
        success: function (response) {
          $("#names").val("");
          $("#add_customer_modal").modal("hide");
          View_shiftRecords();
        },
        error: function (error) {},
      });
  
      $("#addSHIFT").html("Please wait.."); // Update another element's text (saveNewUser)
    });
  
    
    
    
    
    //Update Inventory
    $("#editSHIFT").click(function () {
      $("#editSHIFT").html("Please wait..");
  
      var names = $("#editnames").val();
      var shiftstart = $("#editstarttime").val();
      var shiftend = $("#editendtime").val();
  
      var sales_point_id = localStorage.getItem("SptID");
      var shift_id = parseInt(localStorage.getItem("cust_id"));
  
      //Ajax Start!
      $.ajax({
        url: "functions/shift/editSHIFT.php",
        method: "POST",
  
        data: {
            shift_id:shift_id,
            names:names,
            starttime:shiftstart,
            endtime:shiftend,
        },
  
        success: function (response) {
          console.log(response);
          View_shiftRecords(); 
          $("#editSHIFT").html("Edit Shift");
          $("#edit_shift_modal").modal("hide");
          localStorage.removeItem("cust_id");
        },
        error: function (error) {
          $("#editSHIFT").html("Edit Shift");
          console.log(error.responseText);
        },
      });
    });



    //Update Inventory
    $("#expandSHIFT").click(function () {
      $("#expandSHIFT").html("Please wait..");
  
      var shift_id = parseInt(localStorage.getItem("emp_id"));
    console.log(shift_id);
      // //Ajax Start!
      $.ajax({
        url: "functions/shift/expandSHIFT.php",
        method: "POST",
  
        data: {
          shift_id:shift_id,
        },
  
        success: function (response) {
          console.log(response);
          View_allusershiftRecords();
          $("#expandSHIFT").html("YES");
          $("#shiftmodal").modal("hide");
          localStorage.removeItem("emp_id");
        },
        error: function (error) {
          $("#expandSHIFT").html("YES");
          console.log(error.responseText);
        },
      });
    });







  
              //Delete Inventory
              $("#removeCustomer").click(function () {
                  $("#removeCustomer").html("Please wait..");
                  var id = parseInt(localStorage.getItem("cust_id"));

                  console.log("deleteable id: "+id);
  
                  //Ajax Start!
                  $.ajax({
                  url: "functions/customer/deletecustomer.php",
                  method: "POST",
  
                  data: {
                    customer_id: id,
                  },
  
                  success: function (response) {
                      console.log(response);
                      View_customerRecord(); 
                      $("#removeCustomer").html("Delete");
                      $("#delete-modal").modal("hide");
                      $("#diagMsg").html("Customer removed");
                  },
                  error: function (error) {
                      console.log(error);
                      $("#removeCustomer").html("Delete");
                  },
                  });
              });
        
          

                $("#searchCustomer").on("input", function (e) {
                  
                  var sales_point_id = localStorage.getItem("SptID");
                
                  // Clear the table before making the AJAX request
                  $("#cust_table").empty();
                
                  // Ajax Start!
                  $.ajax({
                    url: `functions/customer/searchcustomerbyname.php?spt=${sales_point_id}&name=${e.target.value}`,
                    method: "GET", // Change method to GET to match your PHP code
                    context: document.body,
                    success: function (response) {
                      if (response && response.length > 0) {
                        // Iterate through the response data and build table rows
                        $.each(response, function (index, row) {
                          var html = `
                            <tr>
                              <td>${index + 1}. ${row.names}</td>
                              <td>${row.phone}</td>
                              <td>${row.address}</td>
                              <td>${row.created_at}</td>
                              <td class="d-flex flex-row justify-content-start align-items-center">
                                <button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditCustomer('${row.customer_id}', '${row.names}', '${row.phone}', '${row.address}')">
                                  <i class="fa fa-edit" style="color: rgb(255,255,255);"></i>
                                </button>
                                <button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteCustomer('${row.customer_id}', '${row.names}')">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </td>  
                            </tr>
                          `;
                
                          $("#cust_table").append(html);
                        });
                      } else {
                        // No results found
                        $("#cust_table").html("<tr><td colspan='7'>Not Any result</td></tr>");
                      }
                    },
                    error: function (xhr, status, error) {
                      // Handle AJAX request errors here
                      console.error("AJAX request failed: " + error);
                    },
                  });
                  // Ajax End!   
                });
                
                
              

  });
  
  function View_customerRecord() {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/customer/getcustomerbyspt.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#cust_table").html(response);
        } else {
          //console.log(response);
          $("#cust_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }

  function View_LoginRecords() {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/shift/getallloginshift.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        
        if (response) {
          // console.log(response);
          $("#info_table").html(response);
        } else {
          //console.log(response);
          $("#info_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }

  function View_shiftRecords() {
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/shift/getallshift.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          $("#shift_table").html(response);
        } else {
          //console.log(response);
          $("#shift_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }

  function View_allusershiftRecords() {
    
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url:`functions/sales/getallusershift.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
      
        if (response) {
          console.log(response);
          $("#usershift_table").html(response);
        } else {
          console.log(response);
          $("#usershift_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
  
 
  
  
  
  function RemoveProductID(e) {
    console.log(e);
    localStorage.setItem("cust_id", e);
  }
  
function SelectEditCustomer(customer_id, names, shiftstart, shiftend) {
    // console.log(customer_id);
    // console.log(names);
    // console.log(shiftstart);
    // console.log(shiftend);

    $("#editnames").val(names); // Use .val() to set the value
    $("#editstarttime").val(shiftstart); // Use .val() to set the value
    $("#editendtime").val(shiftend); // Use .val() to set the value

    localStorage.setItem("cust_id", customer_id);
}
  
  
  function SelectDeleteCustomer(e, names) {
    console.log(e);
    $("#delnames").html(names);
    localStorage.setItem("cust_id", e);
    }


    function SelectExpand(e, names) {
      console.log(e);
  
      localStorage.setItem("emp_id", e);
      }
  
    
    
    
    
    
    
    
    
function printInventoryReport(inventorydata, inventorytotal,typereport) {
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
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.alert_quantity}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.last_updated}</td>
  
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
          Quantity
          </th>
  
           
  
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Alert Quantity
            </th> 
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
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

    