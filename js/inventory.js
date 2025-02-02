$(document).ready(function () {
    
  
  
  View_inventoryRecord(); 
  DisableProductID();

  SelectEditInventory();
  SelectDeleteInventory();
  
  
  
  $("#generateInventoryReport").click(function () {
  
    View_inventoryRecordPrint();
    console.log("print"); 
  });
  
  
  
  
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
          console.log("picking date: " + formattedDate);

           var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/inventory/getaddinghistory.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function(response) {
      try {
          console.log("Success Response: ", response);

          if (response.data && response.data.length > 0) {
               const historydata = response.data;
               console.log(historydata);
               const typereport =  "Adding History Report";
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

// pick date for editing


$(function () {
  // Open the datepicker when the button is clicked
  $("#pickeditButton").on("click", function () {
      $("#datepickeredit").datepicker("show");
  });

  // Initialize the datepicker
  $("#datepickeredit").datepicker({
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
          console.log("picking date: " + formattedDate);

           var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/inventory/geteditinghistory.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function(response) {
      try {
          console.log("Success Response: ", response);

          if (response.data && response.data.length > 0) {
               const historydata = response.data;
               console.log(historydata);
               const typereport =  "Editing History Report";
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
  // Open the datepicker when the button is clicked
  $("#pickdeleteButton").on("click", function () {
      $("#datepickerdelete").datepicker("show");
  });

  // Initialize the datepicker
  $("#datepickerdelete").datepicker({
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
          console.log("picking date: " + formattedDate);

           var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/inventory/getdeletinghistory.php?date=${formattedDate}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function(response) {
      try {
          console.log("Success Response: ", response);

          if (response.data && response.data.length > 0) {
               const historydata = response.data;
               console.log(historydata);
               const typereport =  "Deleting History Report";
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


  
  
  
  
  
  
  
  
  

  $("#saveproduct").click(function () {
    // Retrieve values from input fields
    var name = $("#name").val();
    var price = $("#price").val();
    var benefit = $("#benefit").val();
    var description = $("#description").val();

    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");

    // Start AJAX request
    $.ajax({
      url: "functions/product/addnewproduct.php",
      method: "POST",
      data: {
        name: name,
        price: price,
        benefit: benefit,
        company_ID: company_ID,
        sales_point_id: sales_point_id,
        status: 1,
        description: description,
        barcode: 12345,
      },
      success: function (response) {
        $("#name").val("");
        $("#price").val("");
        $("#benefit").val("");
        $("#description").val("");
        $("#add_product_modal").modal("hide");
        View_ProductsRecord();
      },
      error: function (error) {},
    });

    $("#saveNewUser").html("Please wait.."); // Update another element's text (saveNewUser)
  });

  
  
  
  
  //Update Inventory
  $("#EditInventory").click(function () {

    var quantity = $("#quantity").val();
    var alert_quantity = $("#alert_quantity").val();

    var sales_point_id = localStorage.getItem("SptID");
    var UserID = localStorage.getItem("UserID");
    var product_id = parseInt(localStorage.getItem("co_id"));

    var usertype = localStorage.getItem("UserType");

    if(usertype === 'BOSS'){
       //Ajax Start!
    $.ajax({
      url: "functions/inventory/updateinventory.php",
      method: "POST",

      data: {
          product_id:product_id,
          salespt_id:sales_point_id,
          user_id:UserID,
          quantity:quantity,
          alert_quantity:alert_quantity,
      },

      success: function (response) {
        View_inventoryRecord(); 
        console.log(response);
        $("#EditInventory").html("Edit Inventory");
        $("#modal_inventory").modal("hide");
        localStorage.removeItem("co_id");
      },
      error: function (error) {
        $("#EditInventory").html("error");
        console.log(error);
      },
    });
    }else{
      $("#modal_inventory").modal("hide");
      $("#notallowedmodal").modal("show");
    }




   
  });








            //Delete Inventory
            $("#removeInventory").click(function () {
                $("#removeInventory").html("Please wait..");
                var id = parseInt(localStorage.getItem("co_id"));
                var UserID = localStorage.getItem("UserID");
                var sales_point_id = localStorage.getItem("SptID");

                console.log("deleteable id: "+id);


                var usertype = localStorage.getItem("UserType");

              if(usertype === 'BOSS'){

                //Ajax Start!
                $.ajax({
                url: "functions/inventory/deleteinventory.php",
                method: "POST",

                data: {
                  product_id: id,
                  user_id:UserID,
                  salespt_id:sales_point_id,
                  
                },

                success: function (response) {
                    console.log(response);
                    View_inventoryRecord(); 
                    $("#removeInventory").html("Delete");
                    $("#delete-modal").modal("hide");
                    $("#diagMsg").html("User removed");
                },
                error: function (error) {
                    console.log(error);
                    $("#removeInventory").html("Delete");
                },
                });
              }else{
                $("#delete-modal").modal("hide");
                $("#notallowedmodal").modal("show");
              }
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
                    console.log(response);
                    View_ProductsRecord();
                    $("#disable-product").modal("hide");
                    $("#diagMsg").html("User removed");
                },
                error: function (error) {
                    console.log(error);
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
                    if (response) {
                      //console.log(response);
                      $("#inve_table").html(response);
                    } else {
                      //console.log(response);
                      $("#inve_table").html("Not Any result");
                    }
                  },
                  error: function (xhr, status, error) {
                    // console.log("AJAX request failed!");
                    // console.log("Error:", error);
                  },
                });
                // Ajax End!   
              });
              
              
            

});

function View_inventoryRecord() {
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/inventory/getproductsandinventoryspt.php?company=${company_ID}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#inve_table").html(response);
      } else {
        //console.log(response);
        $("#inve_table").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      // console.log("AJAX request failed!");
      // console.log("Error:", error);
    },
  });
  // Ajax End!
}


 function View_inventoryRecordPrint() {
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url:`functions/inventory/getproductsandinventorysptprint.php?company=${company_ID}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        const inventorydata = response;
        const inventorytotal = response.length;
        const typereport = "Inventory Report";
        printInventoryReport(inventorydata, inventorytotal,typereport);
        
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




function RemoveProductID(e) {
  console.log(e);
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
  
  console.log(e);
  console.log(a);
  localStorage.setItem("co_id", e);
  localStorage.setItem("currentStatus", a);
}

function SelectEditInventory(id, quantity, alert_quantity, name) {
  
  console.log(id);

  $("#quantity").val(quantity);
  $("#alert_quantity").val(alert_quantity);
  $("#product_name_edit").css({"color": "green", "text-transform": "uppercase", "font-weight": "bold"});
  $("#product_name_edit").html('<br/>' +name);

  localStorage.setItem("co_id", id);

}


function SelectDeleteInventory(e, name) {
  console.log(e);
  $("#product_name").css({"color": "red", "text-transform": "uppercase", "font-weight": "bold"});
  $("#product_name").html('<br/>' + name);
  localStorage.setItem("co_id", e);
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
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.unit}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.container}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.item_per_container}</td>
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
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.action}</td>
<td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.timestamp}</td>

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
        <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
        Action
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

  