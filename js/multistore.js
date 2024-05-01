$(document).ready(function () {
    
  var store_id = getParameterByName('store_id'); 
  
  
    View_StoreRecord(); 
    DisableProductID();

    SelectEditInventory();
    SelectDeleteInventory();
    populateSalespoints();
    getProductTransfer();
    
      
    $('#searchstoredetail').on('keyup', filterTableRowsStore);
  
     function filterTableRowsStore() {
      const searchValue = $('#searchstoredetail').val().toLowerCase();
      $('#stockdetail_table tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
      });
  }
    
    $("#storereport").click(function () {
    
      View_inventoryRecordPrint(store_id);
     
    });
    
    
    
    
    
    $("#backtostock").click(function () {
    window.location.href = `storedetails.php?store_id=${store_id}`;
       
    });
    
  
  
  var company_ID = localStorage.getItem("CoID");

  // Make an AJAX request to fetch data by customer_id
  $.ajax({
    url: `functions/multistore/getallCompanyStoredetailsstock.php?company=${company_ID}&store_id=${store_id}`,
    method: 'GET',
    success: function(data) {
      // Handle the data received from the AJAX request and display it in the table
      var html = '';
      var storename = data.data[0].storename;
      var storekeeper = data.data[0].storekeeper;
      var storephone = data.data[0].phone;
       var num = 0;                       
      $.each(data.data, function(index, item) {
        num += 1; 
          
        html += '<tr>';
        html += '<td>'+num+'. ' + item.name + '</td>';
        html += '<td>' + item.unit + '</td>';
        html += '<td>' + item.box_or_carton + '</td>';
        html += '<td>' + item.quantity + '</td>';
        html += '<td>' + item.created_at + '</td>';
        html += `<td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.detail_id}','${item.product_id}','${item.box_or_carton}','${item.quantity}','${store_id}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.detail_id}','${item.product_id}','${store_id}')" "><i class="fa fa-trash"></i></button> 
           <button class="btn btn-primary getremoveSales" type="button" style="margin-left: 18px;min-width: 128px;" data-bs-target="#transfer_modal" data-bs-toggle="modal" onclick="getProductTransfer('${store_id}','${item.product_id}','${item.unit_id}','${item.box_or_carton}','${item.quantity}')" "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-angle-contract" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M.172 15.828a.5.5 0 0 0 .707 0l4.096-4.096V14.5a.5.5 0 1 0 1 0v-3.975a.5.5 0 0 0-.5-.5H1.5a.5.5 0 0 0 0 1h2.768L.172 15.121a.5.5 0 0 0 0 .707M15.828.172a.5.5 0 0 0-.707 0l-4.096 4.096V1.5a.5.5 0 1 0-1 0v3.975a.5.5 0 0 0 .5.5H14.5a.5.5 0 0 0 0-1h-2.768L15.828.879a.5.5 0 0 0 0-.707"/>
</svg>&nbsp;Transfer</button>
        
               <a class="nav-link active" href="purchasedetails.php?store_id=${store_id}&product_id=${item.product_id}">
                <button class="btn btn-success"  rounded-circle" style="background-color:#040536; border-radius:10px; margin-left: 18px;min-width: 120px;color:white;font-weight:bold;" type="button">
                    <i class="fas fa-eye"></i>&nbsp; Purchase
                </button>
            </a>
            <a class="nav-link active" href="transferdetails.php?store_id=${store_id}&product_id=${item.product_id}">
                <button class="btn btn-success"  rounded-circle" style="background-color:#ebdbff; border-radius:10px; margin-left: 18px;min-width:120px;color:#4A5699;font-weight:bold;" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
  <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2z"/>
  <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5z"/>
</svg>&nbsp; Details
                </button>
            </a>
         </td> `; 
        html += '</tr>';
      });
      $('#stockdetail_table').html(html);
      $('#storename').html(storename);
      $('#storekeeper').html(storekeeper);
      $('#storephone').html(storephone);
      
    },
    error: function() {
      alert('An error occurred while fetching debt details.');
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
    
    
    
    
    $(function () {
    // Open the datepicker when the button is clicked
    $("#pickDateButton").on("click", function () {
        $("#datepicker").datepicker("show");
    });

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
            

             var company_ID = localStorage.getItem("CoID");
   
  
    // Ajax Start!

    $.ajax({
      url:`functions/multistore/getTransferReport.php?date=${formattedDate}&company=${company_ID}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
           

            if (response.data && response.data.length > 0) {
                 const historydata = response.data;
                 
                 const typereport =  "Transfer History Report on "+formattedDate;
                 printInventoryhistory(historydata,typereport);
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
        }
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
             
               
          var company_ID = parseInt(localStorage.getItem("CoID"));


          // Make the AJAX request
$.ajax({
      url:`functions/multistore/getTransferReportFromTo.php?startDate=${startDate}&endDate=${endDate}&company=${company_ID}`,
      method: "POST",
      context: document.body,
      success: function(response) {
        try {
            

            if (response.data && response.data.length > 0) {
                 const historydata = response.data;
                 
                 const typereport =  "Transfer History Report From "+startDate+" To "+endDate;
                 printInventoryhistory(historydata,typereport);
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
        


          });

          // Handle the button click event to open the date range picker
          $('#Pickdaterangebtn').on('click', function () {
              $('#daterange').click();
          });
          
          
          
      });
    
    
    
    
    
  
    $("#AddNewStore").click(function () {
      // Retrieve values from input fields
      var storename = $("#storename").val();
      var storekeeper = $("#storekeeper").val();
      var address = $("#storeAddress").val();
      var phone = $("#storephone").val();
  
      // Retrieve values from localStorage
      var company_ID = localStorage.getItem("CoID");
 
  
      // Start AJAX request
      $.ajax({
        url: "functions/multistore/addnewstore.php",
        method: "POST",
        data: {
          storename: storename,
          storekeeper: storekeeper,
          phone: phone,
          address: address,
          company_ID: company_ID,

        },
        success: function (response) {
          $("#storename").val("");
          $("#storekeeper").val("");
          $("#storeAddress").val("");
          $("#storephone").val("");
          $("#add_store_modal").modal("hide");
          View_StoreRecord();
        },
        error: function (error) {},
      });

    });
  
  
  $("#transferBtn").click(function () {
    
       function convertDateFormat(duedate) {
    // Create a new Date object with the selected date
        var dateObject = new Date(duedate);
    
        // Extract the year, month, and day
        var year = dateObject.getFullYear();
        var month = ('0' + (dateObject.getMonth() + 1)).slice(-2); // Add 1 because months are zero-based
        var day = ('0' + dateObject.getDate()).slice(-2);
    
        // Combine the parts into the desired format
        var formattedDate = year + '-' + month + '-' + day;
    
        return formattedDate;
    }
  
    
                  // Retrieve values from input fields
      var compnay_id = localStorage.getItem("CoID");
      var sales_point_id = parseInt($("#salespointSelect").val());
      var product_id = parseInt(localStorage.getItem("tras_id"));
      var store_id = parseInt(localStorage.getItem("store_id"));
      var box_or_carton = $("#qty").val();
      var quantity = localStorage.getItem("item");
      var unit = localStorage.getItem("unit");
      var user_id = parseInt(localStorage.getItem("UserID"));
     var duedate = $("#duedate").val(); 
     var convertedDate = convertDateFormat(duedate);


  
                  // Start AJAX request
                  $.ajax({
                    url: "functions/multistore/transferquantity.php",
                    method: "POST",
                    data: {
                      company: compnay_id,
                      spt: sales_point_id,
                      product_id: product_id,
                      store_id:store_id,
                      unit:unit,
                      box_or_carton:box_or_carton,
                      quantity:quantity,
                      user_id:user_id,
                      created_at:convertedDate,
                    },
                    success: function (response) {
                      $("#transfer_modal").modal("hide");
                      $("#successmodal").modal("show");
                      setTimeout(function() {
                        location.reload();
                    }, 1000);
                    
                    },
                    error: function (error) {
                     
                    },
                  });
            
                });
  
  
  
  
    
 $("#editBtnStock").on("click", function() {
        var detail_id = localStorage.getItem("detail_id");
        var product_id = localStorage.getItem("product_id");
        var store_id = localStorage.getItem("store_id");
        var quantitybox = $("#editquantity").val();
        var box = $("#editbox_or_carton").val();
        var company_id = localStorage.getItem("CoID");
        

        $.ajax({
            type: "POST",
            url: "functions/multistore/updatebigstock.php", // Update this with the actual path to your PHP script
            data: {
                detail_id: detail_id,
                product_id: product_id,
                store_id:store_id,
                quantity_per_box:quantitybox,
                box_or_carton: box,
                company_ID: company_id,
            },
            success: function(response) {
                if (response.message) {
               
               } else {
                
                }
                $("#edit_sales_modal").modal("hide");
                localStorage.removeItem("detail_id");
                localStorage.removeItem("product_id");
                $("#editquantity").val("");
                $("#editbox_or_carton").val("");
                setTimeout(function() {
                location.reload();
            }, 1000);
                
                
            },
            error: function(xhr, status, error) {
               
                
                
                
            }
        });
    });



$("#deleteBtnSales").on("click", function() {
    var saleID = localStorage.getItem("stock_id");
    var raw_material_id = localStorage.getItem("raw_material_id");
    var purchase_date = localStorage.getItem("purchase_date");
    const salesPointID = localStorage.getItem("SptID");
    var use_id= parseInt(localStorage.getItem("UserID"));

    $.ajax({
        type: "POST",
        url: "functions/rowinventory/deleteinventory.php", // Update this with the actual path to your PHP script
        data: {
            stock_id: saleID, // Corrected variable name to match the PHP script
            raw_material_id: raw_material_id,
            purchase_date: purchase_date, // Corrected variable name to match the PHP script
            spt:salesPointID,
            user_id:use_id,
        },
        success: function(response) {
            if (response.message) {
                
            } else {
                
            }
            $("#delete_sales_modal").modal("hide");
            localStorage.removeItem("saleID");
            localStorage.removeItem("raw_material_id");
            localStorage.removeItem("purchase_date");
            setTimeout(function() {
                location.reload();
            }, 1000);
            

        },
        error: function(error) {
            

        }
    });
});




  
  
              //Disable Product
              $("#disableorenable").click(function () {
  
                  $("#disableorenable").html("Please wait..");
                  var product_id = parseInt(localStorage.getItem("co_id"));
                  var c_status = parseInt(localStorage.getItem("currentStatus"));
  
                  var currentStatus=null;
  
                  if(c_status==1){
                      currentStatus=0;
  
                  }else{
                      currentStatus=1;
                  }
  
  
                  //Ajax Start!
                  $.ajax({
                  url: "functions/product/disableproduct.php",
                  method: "POST",
  
                  data: {
                      product_id: product_id,
                      state:currentStatus
                  },
  
                  success: function (response) {
                     
                      View_ProductsRecord();
                      $("#disable-product").modal("hide");
                      $("#diagMsg").html("User removed");
                  },
                  error: function (error) {
                      
                  },
                  });
              });
  
  
  
              $("#create_inventory").click(function () {
                  // Retrieve values from input fields
                  var qty = $("#Inve_Quantity").val();
                  var alert = $("#Inve_Alert").val();
                  var product_id = localStorage.getItem("co_id");
  
                  // Start AJAX request
                  $.ajax({
                    url: "functions/inventory/addnewinvproduct.php",
                    method: "POST",
                    data: {
                      product_id: product_id,
                      quantity: qty,
                      alert_quantity: alert
                    },
                    success: function (response) {
                      $("#Inve_Quantity").val("");
                      $("#Inve_Alert").val("");
                      $("#inventory").modal("hide");
                      View_ProductsRecord();
                    },
                    error: function (error) {},
                  });
              
                  $("#create_inventory").html("Please wait.."); // Update another element's text (saveNewUser)
                });
  
  
  
                $("#save_sell").click(function () {
                  // Retrieve values from input fields
                  var qty = $("#Inve_Quantity").val();
                  var alert = $("#Inve_Alert").val();
                  var product_id = localStorage.getItem("co_id");
  
                  // Start AJAX request
                  $.ajax({
                    url: "functions/inventory/addnewinvproduct.php",
                    method: "POST",
                    data: {
                      product_id: product_id,
                      quantity: qty,
                      alert_quantity: alert
                    },
                    success: function (response) {
                      $("#Inve_Quantity").val("");
                      $("#Inve_Alert").val("");
                      $("#sell-now").modal("hide");
                      View_ProductsRecord();
                    },
                    error: function (error) {},
                  });
              
                  $("#save_sell").html("Please wait.."); // Update another element's text (saveNewUser)
                });


                $("#searchInventory").on("input", function (e) {
                  var company_ID = localStorage.getItem("CoID");
                  var sales_point_id = localStorage.getItem("SptID");
                
                  // Clear the table before making the AJAX request
                  $("#inve_table").empty();
                
                  // Ajax Start!
                  $.ajax({
                    url: `functions/inventory/getproductsandinventorysptbyname.php?company=${company_ID}&spt=${sales_point_id}&name=${e.target.value}`,
                    method: "GET", // Change method to GET to match your PHP code
                    context: document.body,
                    success: function (response) {
                      if (response && response.length > 0) {
                        // Iterate through the response data and build table rows
                        $.each(response, function (index, row) {
                          var sts = row.status == 1 ? "Active" : "Not Active";
                          var html = `
                            <tr>
                              <td>${index + 1}. ${row.name}</td>
                              <td>${row.quantity}</td>
                              <td>${row.alert_quantity}</td>
                              <td>${sts}</td>
                              <td>${row.description}</td>
                              <td>${row.last_updated}</td>
                              <td class="d-flex flex-row justify-content-start align-items-center">
                                <button class="btn btn-success" type="button" data-bs-target="#modal_inventory" data-bs-toggle="modal" onclick="SelectEditInventory('${row.id}', '${row.quantity}', '${row.alert_quantity}', '${row.name}')">
                                  <i class="fa fa-edit" style="color: rgb(255,255,255);"></i>
                                </button>
                                <button class="btn btn-danger" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal" onclick="SelectDeleteInventory('${row.id}', '${row.name}')">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </td>  
                            </tr>
                          `;
                
                          $("#inve_table").append(html);
                        });
                      } else {
                        // No results found
                        $("#inve_table").html("<tr><td colspan='7'>Not Any result</td></tr>");
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
  
  function View_StoreRecord() {
    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
  
    // Ajax Start!

    $.ajax({
      url:`functions/multistore/getallCompanyStore.php?company=${company_ID}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          
          $("#storeboxes").html(response);
        } else {
          
          $("#storeboxes").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        
      },
    });
    // Ajax End!
  }
  
  
  
  
  
 
  
  
  
  
   function View_inventoryRecordPrint(store_id) {
    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    
    
  
    // Ajax Start!

    $.ajax({
      url:`functions/multistore/getallCompanyStoredetailsstock.php?company=${company_ID}&store_id=${store_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          
          const inventorydata = response.data;
          const typereport = "Store Report of "+inventorydata[0].storename;
          printInventoryReport(inventorydata,typereport);
          
        } else {
          

        }
      },
      error: function (xhr, status, error) {
    
      },
    });
    // Ajax End!
  }
  
  
//   function backToCurrentStock(store_id) {
//   window.location.href = `storedetails.php?store_id=${store_id}`;
// }
  
  function RemoveProductID(e) {
  
    localStorage.setItem("co_id", e);
  }
  
  function DisableProductID(e,a) {
    if(a==1){
      $("#disableorenable").removeClass("btn btn-success");
      $("#disableorenable").addClass("btn btn-danger");
      $("#disableorenable").html("Disable");
  
    }else{
      $("#disableorenable").removeClass("btn btn-danger");
      $("#disableorenable").addClass("btn btn-success");
      $("#disableorenable").html("Enable");
      
    }
    
  
    localStorage.setItem("co_id", e);
    localStorage.setItem("currentStatus", a);
  }
  
  function SelectEditInventory(id, quantity, alert_quantity, name) {
    


    $("#quantity").val(quantity);
    $("#alert_quantity").val(alert_quantity);
    $("#product_name").html(name);

    localStorage.setItem("co_id", id);

  }
  function getProductTransfer(store_id,id,unit,box,qty) {


    localStorage.setItem("tras_id", id);
    localStorage.setItem("store_id", store_id);
    localStorage.setItem("item", qty);
    localStorage.setItem("unit", unit);

  }
  
  function SelectDeleteInventory(e, name) {
   
    $("#product_name").html(name);
    localStorage.setItem("co_id", e);
    }
  
    
    
   function getSalesID(detail_id,product_id,box_or_carton,quantity,store_id){
     localStorage.setItem("detail_id", detail_id);
        localStorage.setItem("product_id", product_id);
        localStorage.setItem("store_id", store_id);
     
        $("#editbox_or_carton").val(box_or_carton);
        $("#editquantity").val(quantity);
        
       
        
}

function getSalesIDremove(detail_id,product_id,){
   localStorage.setItem("detail_id", detail_id);
        localStorage.setItem("product_id", product_id);
      
       
        
}


  function populateSalespoints() {
    var company_ID = parseInt(localStorage.getItem("CoID"));

    $.ajax({
        url: "functions/multistore/getallCompanySalesPoints.php",
        method: "GET", // Change to GET method
        data: { company: company_ID },
        success: function (response) {
          
            $("#salespointSelect").html(response);
        },
        error: function (error) {
            
        }
    });
}
    
    
    
    
    
function printInventoryReport(inventorydata,typereport) {
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
var address = inventorydata[0].address;
var phone = inventorydata[0].phone;
var storekeeper = inventorydata[0].storekeeper;


let table = '';

for (let i = 0; i < inventorydata.length; i++) {
  const item = inventorydata[i];
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.unit}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.box_or_carton}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.totalitem}</td>
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
                  StoreKeeper : ${storekeeper} <br> Tel: ${phone}
                </td>
                
                  </tr>
  
                  <tr>
                  <td style="font-size: 12px; color: rgb(6, 6, 61); font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
                  Address : ${address}
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
          Unit
          </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
           Container
          </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Item/Container
          </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Total Items
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
            <strong> </strong>
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







function printInventoryhistory(historydata,typereport) {
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

for (let i = 0; i < historydata.length; i++) {
  const item = historydata[i];
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.full_name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150"> ${item.product_name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.box_or_carton}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity_per_box}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150"> ${item.storename}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.sales_point_location}</td>
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
            User
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
            Product
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
                BOX/CARTON
            </th>
             <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
                ITEM/BOX
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" align="center" width="150">
            From
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          To
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

    