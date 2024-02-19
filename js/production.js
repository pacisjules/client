$(document).ready(function () {
  var session_id = getParameterByName('session_id'); 
   var product_id = getParameterByName('product_id'); 
  localStorage.setItem("is_paid","Paid");
  localStorage.setItem('sessionid','');
  View_DayFinishedRecord();
  getSelected();
  View_LastFinishedRecord();
  
  $("#generateFinishedPrintRecord").click(function() {
     View_DayFinishedPrintRecord();   
  });  
  
//   $("#generateFinishedStockedRecord").click(function() {
//      View_DayFinishedStockedtRecord();   
//   });
  
   $("#getProductionDetails").click(function() {
     View_DayFinishedDetailsRecord(session_id, product_id); 
  });
  
  
  
   
   
    var sales_point_id = localStorage.getItem("SptID");

  // Make an AJAX request to fetch data by customer_id
  $.ajax({
    url: `functions/production/getallProductionbySession.php?session_id=${session_id}&product_id=${product_id}&spt=${sales_point_id}`,
    method: 'GET',
    success: function(data) {
      // Handle the data received from the AJAX request and display it in the table
      var html = '';
      var product_name = data.name;
                              
      $.each(data.data, function(index, item) {
          
        html += '<tr>';
        html += '<td>' + item.raw_material_name + '</td>';
        html += '<td>' + item.quantity + '</td>';
        html += '<td> Frw ' + item.unit + '</td>';
        html += '<td>' + item.created_at + '</td>';
        html += `<td class="d-flex flex-row justify-content-start align-items-center"><button class="btn btn-success getEditSales" type="button" data-bs-target="#edit_sales_modal" data-bs-toggle="modal" onclick="getSalesID('${item.id}','${item.raw_material_name}','${item.quantity}','${item.unit}')"><i class="fa fa-edit" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger getremoveSales" type="button" style="margin-left: 20px;" data-bs-target="#delete_sales_modal" data-bs-toggle="modal" onclick="getSalesIDremove('${item.stock_id}','${item.id}','${item.raw_material_name}')" "><i class="fa fa-trash"></i></button></td>`; // Replace with your action buttons
        html += '</tr>';
      });
      $('#detail_table').html(html);
      $('#product_name').html(product_name);
      $('#custn').html(product_name);
      
    },
    error: function() {
      alert('An error occurred while fetching debt details.');
    }
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
  
  
  
  
      $(function () {
    // Open the datepicker when the button is clicked
    $("#generateFinishedStockedRecord").on("click", function () {
        $("#datepickerTransfer").datepicker("show");
    });

    // Initialize the datepicker
    $("#datepickerTransfer").datepicker({
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
      url:`functions/production/getalldayFinishedsptStocked.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function(response) {
         try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                 const historydata = response.data;
                 console.log(historydata);
                 const typereport =  "Transferred Finished Product Report On "+formattedDate;
                 printFinishedReport(historydata,typereport);
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

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  // ViewCartItem();
   // Call the initializeCart function on page load

    // Retrieve cart data from localStorage
    var cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
   console.log(cart);
    // Update the cart display
    updateCartDisplay(cart);


$("#addCart").click(function() {

var qty = $("#Sales_qty").val();


    var c_qaty = localStorage.getItem("current_quantity");

    // Parse stored values to floats
    c_qty = parseFloat(qty);
    
    if (c_qaty < c_qty) {
        $("#calc_result").html("You entered more quantity than stock!");
        $("#calc_result").css("color:red");
    }else{
        // If all checks pass, proceed with adding to cart
        AddToCart( c_qty);

        // Clear input values and other elements
        $("#Sales_qty").val("");
        $("#searcProductNow").val("");
        $("#gettedProduct").html("");
        $("#unitvalue").html("");
        $("#gettedCQuantity").html("");
    }


        

    
});



$("#printRec").click(function() {
 var sessid=localStorage.getItem('sessionid');

 var url = `printreceipt.php/sess?id=${sessid}`;
 window.open(url, "_blank");
});


$("#printnowrec").click(function() {
    $("#printnowrec").hide();
    $("#closereceipt").hide();
// Hide elements with class "hide-on-print" before printing
var hideElements = document.querySelectorAll('.hide-on-print');
for (var i = 0; i < hideElements.length; i++) {
  hideElements[i].style.display = 'none';
}

// Trigger the print dialog
window.print();

// Restore visibility of hidden elements after printing
for (var i = 0; i < hideElements.length; i++) {
  hideElements[i].style.display = 'block';
}

    $("#printnowrec").show();
    $("#closereceipt").show();

 });



$("#shareReceipt").click(function() {
  var sessid=localStorage.getItem('sessionid');
  if (navigator.share) {
    // Share using navigator.share() if supported
    navigator.share({
        title: 'Shared from Selleasep POS',
        text: 'Please open link below to check the receipt',
        url: `https://selleasep.shop/client/printreceipt.php/sess?id=${sessid}`
    })
    .then(() => console.log('Shared successfully'))
    .catch((error) => console.error('Error sharing:', error));
} else {
    // Fallback for devices that do not support navigator.share()
    alert('Sharing not supported on this device.');
}
});





// Attach click events to buttons for each item in the cart
$(document).on('click', '.decreaseQtyBtn', function() {
  var itemId = $(this).data('item-id');
  console.log("decresacee: "+itemId);
  
  
  // Find the item in the cart by itemId
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
  var itemToUpdate = cart.items.find(item => parseInt(item.id) == parseInt(itemId));
  
 console.log(itemToUpdate);
  

      if (itemToUpdate && parseFloat(itemToUpdate.qty) > 1) {
   // Decrease the quantity of the item
   itemToUpdate.qty -= 1;

    // Update the total amount (assuming you also need to update it)

    // Update the cart in local storage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Update the cart display
    updateCartDisplay(cart);
  }

  
});




// Attach click events to buttons for each item in the cart
$(document).on('click', '.increaseQtyBtn', function() {
  var itemId = $(this).data('item-id');
  console.log("incresacee: "+itemId);
  // Find the item in the cart by itemId
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: []};
  var itemToUpdate = cart.items.find(item => parseInt(item.id) == parseInt(itemId));
 
  if (itemToUpdate && itemToUpdate.qty > 0) {
    // Decrease the quantity of the item
   itemToUpdate.qty = parseFloat(itemToUpdate.qty) + 1;



    // Update the cart in local storage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Update the cart display
    updateCartDisplay(cart);
  }
});

$('#delete-modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var itemId = button.data('item-id'); // Extract item-id from the button

  $('#removeItem').data('item-id', itemId); // Set itemId as a data attribute on the modal's delete button
});

$('#removeItem').click(function () {
  var itemId = $(this).data('item-id');
  console.log("remove: " + itemId);
  
  // Find the item in the cart by itemId
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: []};
  var itemIndexToRemove = cart.items.findIndex(item => parseInt(item.id) == parseInt(itemId));
  
  if (itemIndexToRemove !== -1) {
    // Remove the item from the cart
    cart.items.splice(itemIndexToRemove, 1);

    // Update the total amount


    // Update the cart in local storage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Update the cart display
    updateCartDisplay(cart);
  }

  // Close the modal
  $('#delete-modal').modal('hide');
});




$('#clearItemBtn').click(function () {
  initializeCart();
  $("#gettedProduct").html("");

  $("#unitvalue").html("");

  $("#gettedCQuantity").html("");
  $('#clear-modal').modal('hide');
});



  $("#Sales_qty").change(function(e) {
  updateCalcResult();
});


 $("#Sales_qty").on("input", function (e) {
    updateCalcResult();
});







 $("#savep_sell").click(function () {


  $("#savep_sell").html("Please wait..");

  var cart = JSON.parse(localStorage.getItem("cart")) || { items: []};

  // Extract the product IDs and quantities from the cart array
  var rowIds = cart.items.map(function(item) {
    return parseInt(item.id);
  });

  var quantities = cart.items.map(function(item) {
    return parseFloat(item.qty);
  });
  
  var units = cart.items.map(function(item) {
    return item.unit;
  });
  

  //console.log("P_IDS: "+productIds);
  //console.log("Qty: "+quantities);quantityExpected

  // Retrieve values from localStorage
  var NeeddedQty = $("#quantityExpected").val();
  var sales_point_id = localStorage.getItem("SptID");
  var use_id = parseInt(localStorage.getItem("UserID"));
  var product_id = parseInt(localStorage.getItem("product_id"));


  // // Start AJAX request
  $.ajax({
    url: "functions/production/bulkproduction.php",
    method: "POST",
    dataType: 'json',
    data: {
      row_id: rowIds,
      product_id: product_id,
      needdedQty:NeeddedQty,
      sales_point_id: sales_point_id,
      quantity: quantities,
      unit:units,
      user_id: use_id,
    },
    
    success: function (response) {
    //   console.log("response:", response);
      initializeCart();
      View_LastFinishedRecord();
      $("#savep_sell").html("Production Done");
      
      $("#finishModal").modal('show');
      $('#sessionid').html(response);
      localStorage.setItem('sessionid', response);
      localStorage.removeItem('product_id');
    },
    error: function (xhr, status, error) {
      console.log("Error:", xhr.responseText, status);
      $("#savep_sell").html("Production Failed");
      $("#savep_sell").css("backgroundColor","red");
    },
  });
});



 $("#searcProductNow").on("input", function (e) {

    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/rowmaterial/searchrowmaterialbyname.php?spt=${sales_point_id}&name=${e.target.value}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          $("#getseach").html(response);
        } else {
          //console.log(response);
          $("#getseach").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!


    
 });
 
 
 
  $("#searcProductingNow").on("input", function (e) {
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/product/searchproductbyname.php?company=${company_ID}&spt=${sales_point_id}&name=${e.target.value}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          $("#getseachproduct").html(response);
        } else {
          //console.log(response);
          $("#getseachproduct").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!


    
 });

 $("#searchCustomerNow").on("input", function (e) {

    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/customer/searchcustomerforDebit.php?spt=${sales_point_id}&names=${e.target.value}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          $("#getsearchCustomer").html(response);
        } else {
          //console.log(response);
          $("#getsearchCustomer").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!


    
 });
 
 
 
   $("#transferInStock").click(function () {
    $("#transferInStock").html("Please wait..");
    

    var sales_point_id = localStorage.getItem("SptID");
    var UserID = localStorage.getItem("UserID");
    var product_id = parseInt(localStorage.getItem("product_id"));
    var quantity = localStorage.getItem("quantity");
    var prod_session = localStorage.getItem("prod_session");

    //Ajax Start!
    $.ajax({
      url: "functions/inventory/transferQuantity.php",
      method: "POST",

      data: {
        product_id: product_id,
        salespt_id: sales_point_id,
        user_id: UserID,
        quantity:quantity,
        prod_session:prod_session,
      },

      success: function (response) {
        View_DayFinishedRecord();
        $("#edit_product_modal").modal("hide");
        localStorage.removeItem("co_id");
      },
      error: function (error) {
        //console.log(error.responseText);
      },
    });
  });

 
 
 
 
 
 
 
 






});

function View_DayFinishedRecord() {
//   const currentDate = new Date();
//   const montly = currentDate.getMonth();
//   const date = currentDate.getDate();
//   const year = currentDate.getFullYear();
//   const formattedDate =
//     year +
//     "-" +
//     (montly + 1).toString().padStart(2, "0") +
//     "-" +
//     date.toString().padStart(2, "0");

//   const formatDate = (myDate) => {
//     const dateParts = myDate.split("-");
//     const year = dateParts[0];
//     const month = dateParts[1];
//     const day = dateParts[2];

//     const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
//       "en-US",
//       {
//         year: "numeric",
//         month: "long",
//         day: "numeric",
//       }
//     );

//     return formattedDate; date=${formattedDate}&
//   };

//   $("#dateShow").html(formatDate(formattedDate));

  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/production/getalldayFinishedspt.php?spt=${sales_point_id}`,
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

function View_DayFinishedDetailsRecord(session_id, product_id) {

  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/production/getallProductionbySession.php?session_id=${session_id}&product_id=${product_id}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
     try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                 const historydata = response.data;
                 const ProductName = response.name;
                 console.log(historydata);
                 const typereport =  "Producion Details Report of "+ProductName;
                 printFinishedDetailsReport(historydata,typereport);
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



function View_DayFinishedPrintRecord() {

  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/production/getalldayFinishedsptPrint.php?spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
     try {
            console.log("Success Response: ", response);

            if (response.data && response.data.length > 0) {
                 const historydata = response.data;
                 console.log(historydata);
                 const typereport =  "Produced Finished Product Report";
                 printFinishedReport(historydata,typereport);
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

// function View_DayFinishedStockedtRecord() {

//   var sales_point_id = localStorage.getItem("SptID");

//   // Ajax Start!

//   $.ajax({
//     url: `functions/production/getalldayFinishedsptStocked.php?spt=${sales_point_id}`,
//     method: "POST",
//     context: document.body,
//     success: function (response) {
//      try {
//             console.log("Success Response: ", response);

//             if (response.data && response.data.length > 0) {
//                  const historydata = response.data;
//                  console.log(historydata);
//                  const typereport =  "Produced Finished Product Report";
//                  printFinishedReport(historydata,typereport);
//              }
//         } catch (e) {
//             console.error("Error handling response: ", e);
//             // Handle the error or display an error message to the user
//         }
//     },
//     error: function (xhr, status, error) {
//       // console.log("AJAX request failed!");
//       // console.log("Error:", error);
//     },
//   });
//   // Ajax End!
// }

function View_LastFinishedRecord() {
//   const currentDate = new Date();
//   const montly = currentDate.getMonth();
//   const date = currentDate.getDate();
//   const year = currentDate.getFullYear();
//   const formattedDate =
//     year +
//     "-" +
//     (montly + 1).toString().padStart(2, "0") +
//     "-" +
//     date.toString().padStart(2, "0");

//   const formatDate = (myDate) => {
//     const dateParts = myDate.split("-");
//     const year = dateParts[0];
//     const month = dateParts[1];
//     const day = dateParts[2];

//     const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
//       "en-US",
//       {
//         year: "numeric",
//         month: "long",
//         day: "numeric",
//       }
//     );

//     return formattedDate;   date=${formattedDate}&
//   };


  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/production/getalldayFinishedsptLast5.php?spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#lastsells_table").html(response);
        
      } else {
        
        $("#lastsells_table").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      console.log("AJAX request failed!");
      console.log("Error:", error);
    },
  });
  // Ajax End!
}





function getSelecteRow(raw_material_id,raw_material_name,unit_of_measure,C_Qty) {
  console.log(unit_of_measure);
  
  $("#gettedProduct").html(raw_material_name);



  $("#gettedCQuantity").html(C_Qty);

  $("#unitvalue").html(unit_of_measure);
  
  

  //$("#product_name").html(benefit);

  $("#getseach").html('');

  localStorage.setItem("raw_material_id", raw_material_id);
  localStorage.setItem("raw_material_name", raw_material_name);
  localStorage.setItem("unit_of_measure", unit_of_measure);
  localStorage.setItem("current_quantity", C_Qty);
}



function getSelected(id,name,price,benefit,C_Qty) {
  console.log(name);
  
  $("#gettedProduction").html(name);


  $("#getseachproduct").html('');

  localStorage.setItem("product_id", id);
}










function getSelectedCustomer(customer_id,names,phone,address) {
  console.log(names);

  $("#getnames").html(names);
  $("#getphone").html(phone);
  $("#getaddress").html(address);
  $("#getsearchCustomer").html('');

  localStorage.setItem("customer_id", customer_id);
  localStorage.setItem("customer_names", names);
  localStorage.setItem("customer_phone", phone);
  localStorage.setItem("customer_address", address);
 
}

function initializeCart() {
  // Clear the content of the tbody
  $('#cartItemTable').empty();

  // Update local storage
  updateLocalStorage();
}

// Function to update Local Storage
function updateLocalStorage() {
  const cartState = {
      items: [],
  };

  localStorage.setItem('cart', JSON.stringify(cartState));
}



function updateCalcResult() {
    var qty = $("#Sales_qty").val();
    var c_qty = localStorage.getItem("current_quantity");

    // Parse values to floats
    qty = parseFloat(qty);
    c_qty = parseFloat(c_qty);


     if (c_qty < qty) {
        $("#calc_result").html("You entered more quantity than stock!");
        return;
    }
 $("#calc_result").html("");
     
    }



function AddToCart(qty) {
    
   var id = localStorage.getItem("raw_material_id");
    var name = localStorage.getItem("raw_material_name");

  var unit = localStorage.getItem("unit_of_measure");



    if (!id || !unit || !name || !qty) {
        console.log("Product information is incomplete. Cannot add to cart.");
        return;
    }
    
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
  


    var product = {
      id: id,
      unit: unit,
      name: name,
      qty: qty
    };
    cart.items.push(product);

  localStorage.setItem("cart", JSON.stringify(cart));

  // Create a new table row with the product data
  var newRow = $('<tr></tr>');
  newRow.append('<td>' + name + '</td>');
  newRow.append('<td>' + qty + '</td>');
  newRow.append('<td>' + unit + '</td>');
  newRow.append('<td class="d-flex flex-row justify-content-center align-items-center"> <button class="btn btn-primary decreaseQtyBtn" data-item-id="' + id + '" type="button" style="margin-right: 10px;"><i class="bi bi-dash-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-success increaseQtyBtn" data-item-id="' + id + '" type="button">  <i class="bi bi-plus-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger removeItemBtn" data-item-id="' + id + '" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal"> <i class="fa fa-trash"></i></button></td>');

  // Append the new row to the table
  $('#cartItemTable').append(newRow);

  // Calculate total amount
  
  

  // Optional: Log the updated cart array for debugging
  localStorage.removeItem("raw_material_id");
  localStorage.removeItem("raw_material_name");
  localStorage.removeItem("unit_of_measure");
  localStorage.removeItem("current_quantity");
  console.log(cart);
}



function updateCartDisplay(cart) {
  // Clear the existing cart table
  $('#cartItemTable').empty();
  // var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: 0.00 };
  console.log(cart);

  // Loop through the cart items and update the table
  cart.items.forEach(item => {
    var newRow = $('<tr></tr>');
    newRow.append('<td>' + item.name + '</td>');
    newRow.append('<td>' + item.qty + '</td>');
    newRow.append('<td>' + item.unit + '</td>');
    newRow.append('<td class="d-flex flex-row justify-content-center align-items-center"> <button class="btn btn-primary decreaseQtyBtn" data-item-id="' + item.id + '" type="button" style="margin-right: 10px;"><i class="bi bi-dash-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-success increaseQtyBtn" data-item-id="' + item.id + '" type="button"><i class="bi bi-plus-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger removeItemBtn" data-item-id="' + item.id + '" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal"> <i class="fa fa-trash"></i></button </td>');

    // Append the new row to the table
    $('#cartItemTable').append(newRow);
  });

}


function setFinishedProduct(product_id, prod_session,quantity,Product_Name){
    console.log(product_id);
    console.log(quantity);
    console.log(Product_Name);
    console.log(prod_session);
    
    $("#finishedPro").html(Product_Name);
    $("#quantity").html(quantity);
    localStorage.setItem("product_id", product_id);   
    localStorage.setItem("quantity", quantity); 
    localStorage.setItem("prod_session", prod_session); 
    
    
}







function printFinishedReport(historydata,typereport) {
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
  let color = "";
  if(item.statuss === "Pending"){
    color="orange";  
  }else{
    color="green";   
  }
  
  table += `<tr >
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.Product_Name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.usernames}</td>
   <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: ${color}; font-weight: bold;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.statuss}</td>
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
            Finished Product
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Produced Quantity
          </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Produced By
            </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Status
          </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Produced Time
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


function printFinishedDetailsReport(historydata,typereport) {
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
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${i+1}. ${item.raw_material_name}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.quantity}</td>
  <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.unit}</td>
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
            Row Material Name
            </th>
          <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
          Used Quantity
          </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Unit
            </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
            Produced Time
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











  
  