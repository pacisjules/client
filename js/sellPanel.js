$(document).ready(function () {
  
  localStorage.setItem("is_paid","Paid");
  localStorage.setItem('sessionid','');
  View_DaySalesRecord();
  getSelected();
  View_LastSalesRecord();
  
  
  
  
  
  
    $("#addcustomer").click(function () {
      // Retrieve values from input fields
      var names = $("#names").val();
      var phone = $("#phone").val();
      var address = $("#address").val();
     
  
     
      var sales_point_id = localStorage.getItem("SptID");
  
      // Start AJAX request
      $.ajax({
        url: "functions/customer/addnewcustomer.php",
        method: "POST",
        data: {
          names: names,
          phone: phone,
          address: address,
          spt: sales_point_id,
          
        },
        success: function (response) {
          $("#names").val("");
          $("#phone").val("");
          $("#address").val("");
          $("#add_customer_modal").modal("hide");
          setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function (error) {},
      });
  
      $("#addcustomer").html("Please wait.."); // Update another element's text (saveNewUser)
    });
  
    
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  // ViewCartItem();
   // Call the initializeCart function on page load

    // Retrieve cart data from localStorage
    var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
    console.log(cart);
    // Update the cart display
    updateCartDisplay(cart);


$("#addCart").click(function() {
    var qty = $("#Sales_qty").val();
    var negoPrice = $("#NegoPrice").val();

    // Parse values to floats
    qty = parseFloat(qty);
    negoPrice = parseFloat(negoPrice);

    var c_qty = localStorage.getItem("current_quantity");
    var price = localStorage.getItem("product_price");
    var benefit = localStorage.getItem("product_benefit");

    // Parse stored values to floats
    c_qty = parseFloat(c_qty);
    price = parseFloat(price);
    benefit = parseFloat(benefit);

    // Check if qty is a valid number and greater than 0
    if (isNaN(qty) || qty <= 0) {
        $("#calc_result").html("Please enter a valid quantity.");
    } else if (c_qty < qty) {
        $("#calc_result").html("You entered more quantity than stock!");
    } else {
        // Define variables to hold the calculated values
        var benefits, realprice;

        // Check if Negoprice is a valid number
        if (!isNaN(negoPrice)) {
            // Update calculation if Negoprice is a valid number
            var ikiranguzo =  price - benefit;
            benefits = negoPrice - ikiranguzo ;
            realprice = negoPrice;
        } else {
            // Use regular price and benefit if Negoprice is not a valid number
            benefits = benefit;
            realprice = price;
        }

        // If all checks pass, proceed with adding to cart
        AddToCart(realprice, benefits, qty);

        // Clear input values and other elements
        $("#Sales_qty").val("");
        $("#NegoPrice").val("");
        $("#searcProductNow").val("");
        $("#gettedProduct").html("");
        $("#gettedPrice").html("");
        $("#gettedCQuantity").html("");

        // Clear any previous error messages
        $("#calc_result").html("");
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
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
  var itemToUpdate = cart.items.find(item => parseInt(item.id) == parseInt(itemId));
  
 console.log(itemToUpdate);
  

      if (itemToUpdate && parseFloat(itemToUpdate.qty) > 1) {
   // Decrease the quantity of the item
   itemToUpdate.qty -= 1;

    // Update the total amount (assuming you also need to update it)
    var totalAmount = calculateTotalAmount(cart.items);
    cart.total = totalAmount;

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
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
  var itemToUpdate = cart.items.find(item => parseInt(item.id) == parseInt(itemId));
 
  if (itemToUpdate && itemToUpdate.qty > 0) {
    // Decrease the quantity of the item
   itemToUpdate.qty = parseFloat(itemToUpdate.qty) + 1;

    // Update the total amount (assuming you also need to update it)
    var totalAmount = calculateTotalAmount(cart.items);
    cart.total = totalAmount;

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
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
  var itemIndexToRemove = cart.items.findIndex(item => parseInt(item.id) == parseInt(itemId));
  
  if (itemIndexToRemove !== -1) {
    // Remove the item from the cart
    cart.items.splice(itemIndexToRemove, 1);

    // Update the total amount
    var totalAmount = calculateTotalAmount(cart.items);
    cart.total = totalAmount;

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

  $("#gettedPrice").html("");

  $("#gettedCQuantity").html("");
  $("#calc_result").html("");
  $('#clear-modal').modal('hide');
});



  $("#Sales_qty").change(function(e) {
  updateCalcResult();
});


 $("#Sales_qty").on("input", function (e) {
    updateCalcResult();
});

$("#flexSwitchPriceChecked").change(function () {
    updateCalcResult();
});

$("#NegoPrice").on("input", function () {
    updateCalcResult();
});




 $("#savep_sell").click(function () {


  $("#savep_sell").html("Please wait..");

  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };

  // Extract the product IDs and quantities from the cart array
  var productIds = cart.items.map(function(item) {
    return parseInt(item.id);
  });

  var quantities = cart.items.map(function(item) {
    return parseFloat(item.qty);
  });
  
  var prices = cart.items.map(function(item) {
    return parseFloat(item.price);
  });
  
  var benes = cart.items.map(function(item) {
    return parseFloat(item.benefit);
  });

  //console.log("P_IDS: "+productIds);
  //console.log("Qty: "+quantities);

  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");
  var use_id = parseInt(localStorage.getItem("UserID"));
  var paid_jk = localStorage.getItem("is_paid");
  var customer_id = localStorage.getItem("customer_id");
  var cust_name = localStorage.getItem("customer_names");
  var phone = localStorage.getItem("customer_phone")


  // // Start AJAX request
  $.ajax({
    url: "functions/sales/bulksales.php",
    method: "POST",
    dataType: 'json',
    data: {
      product_id: productIds,
      sales_point_id: sales_point_id,
      customer_id:customer_id,
      cust_name:cust_name,
      phone:phone,
      quantity: quantities,
      price:prices,
      benefit:benes,
      sales_type: 1,
      paid_status: paid_jk,
      service_amount: 0,
      user_id: use_id,
    },
    
    success: function (response) {
      console.log("response:", response);
      initializeCart();
      View_LastSalesRecord();
      $("#savep_sell").html("Sell Done");
      localStorage.setItem("is_paid","Paid");
     
      var checkbox = document.getElementById("flexSwitchCheckChecked");
      
      // Toggle the checkbox's checked state
      checkbox.checked = false;
      
      $('#amadenis').hide();
      $("#finishModal").modal('show');
      $('#sessionid').html(response);
      localStorage.setItem('sessionid', response);
      localStorage.removeItem('customer_id');
      localStorage.removeItem('customer_phone');
      localStorage.removeItem('customer_names');
      localStorage.removeItem('customer_address');
    },
    error: function (xhr, status, error) {
      console.log("Error:", xhr.responseText, status);
      $("#savep_sell").html("Sell Failed");
      $("#savep_sell").style("backgroundColor","red");
    },
  });
});



 $("#searcProductNow").on("input", function (e) {

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






});

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

  $("#dateShow").html(formatDate(formattedDate));

  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/sales/getalldaysaleswithcompanyspt.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#sells_table").html(response);
      } else {
        //console.log(response);
        $("#sells_table").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      // console.log("AJAX request failed!");
      // console.log("Error:", error);
    },
  });
  // Ajax End!
}

function calculateTotalAmount(items) {
  var totalAmount = 0;
  items.forEach(item => {
    totalAmount += item.price * item.qty;
  });
  return totalAmount;
}
function View_LastSalesRecord() {
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
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!

  $.ajax({
    url: `functions/sales/getalldaysaleswithcompanysptLast5.php?date=${formattedDate}&company=${company_ID}&spt=${sales_point_id}`,
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





function getSelected(id,name,price,benefit,C_Qty) {
  console.log(name);
  
  $("#gettedProduct").html(name);

  $("#gettedPrice").html(
    new Intl.NumberFormat("en-US", {
      style: "currency",
      currency: "RWF",
    }).format(price)
  );

  $("#gettedCQuantity").html(C_Qty);

  $("#Up_benefit").val(benefit);
  
  

  //$("#product_name").html(benefit);

  $("#getseach").html('');

  localStorage.setItem("product_id", id);
  localStorage.setItem("product_price", price);
  localStorage.setItem("product_benefit", benefit);
  localStorage.setItem("product_name", name);
  localStorage.setItem("current_quantity", C_Qty);
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

  // Set the content of totalAmount to "0.00 FRW"
  $('#totalAmount').html('<strong>0.00 FRW</strong>');
  
  // Update local storage
  updateLocalStorage();
}

// Function to update Local Storage
function updateLocalStorage() {
  const cartState = {
      items: [],
      total: '0.00 FRW'
  };

  localStorage.setItem('cart', JSON.stringify(cartState));
}



function updateCalcResult() {
    var qty = $("#Sales_qty").val();
    var c_qty = localStorage.getItem("current_quantity");
    var price = localStorage.getItem("product_price");
    var benefit = localStorage.getItem("product_benefit");
    var TypeUser = localStorage.getItem("UserType");

    // Parse values to floats
    qty = parseFloat(qty);
    c_qty = parseFloat(c_qty);
    price = parseFloat(price);
    benefit = parseFloat(benefit);

    // Check if qty is a valid number and greater than 0
    // if (isNaN(qty) || qty <= 0) {
    //     $("#calc_result").html("Please enter a valid quantity.");
    //     return;
     if (c_qty < qty) {
        $("#calc_result").html("You entered more quantity than stock!");
        return;
    }else{
   
   
    var useNegotiablePrice = $("#flexSwitchPriceChecked").is(":checked");
    var Negoprice = $("#NegoPrice").val();

    // Parse Negoprice to float
    Negoprice = parseFloat(Negoprice);

    // if (isNaN(Negoprice) || Negoprice === 0) {
    //     $("#calc_result").html("Please enter a valid negotiable price.");
    //     return;
    // }

    var total, total_benefit;

    // Calculation with both price and Negoprice
    total = qty * price;
    total_benefit = qty * benefit;

    if (useNegotiablePrice) {
        // Update calculation if NegoPrice is checked
        var ikiranguzo = price - benefit;
        var beneperc = Negoprice - ikiranguzo ;
        total = qty * Negoprice;
        total_benefit = qty * beneperc;
        
        if (TypeUser === "BOSS") {
            if(total_benefit<0){
              $("#calc_result").css("color","red");  
              $("#calc_result").html(
            "Total Amount: " + total + " and Benefit: " + total_benefit +" (LOSS)"
        );  
            }else{
              $("#calc_result").css("color","green");   
             $("#calc_result").html(
            "Total Amount: " + total + " and Benefit: " + total_benefit
        );   
            }
        
    } else {
        $("#calc_result").html("Total Amount: " + total);
    }
    }else{
       total = qty * price;
    total_benefit = qty * benefit;
    
    if (TypeUser === "BOSS") {
        $("#calc_result").html(
            "Total Amount: " + total + " and Benefit: " + total_benefit
        );
    } else {
        $("#calc_result").html("Total Amount: " + total);
    }
    
    
    }

     
    }

   
}



function AddToCart(realprice, benefit, qty) {
    
   var id = localStorage.getItem("product_id");
    var name = localStorage.getItem("product_name");

    if (!id || !realprice || !benefit || !name || !qty) {
        console.log("Product information is incomplete. Cannot add to cart.");
        return;
    }
    
  var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
  


    var product = {
      id: id,
      price: realprice,
      benefit: benefit,
      name: name,
      qty: qty
    };
    cart.items.push(product);

  localStorage.setItem("cart", JSON.stringify(cart));

  // Create a new table row with the product data
  var newRow = $('<tr></tr>');
  newRow.append('<td>' + name + '</td>');
  newRow.append('<td>' + new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(product.price) + '</td>');
  newRow.append('<td>' + qty + '</td>');
  newRow.append('<td>' + new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(product.price * qty) + '</td>');
  newRow.append('<td class="d-flex flex-row justify-content-center align-items-center"> <button class="btn btn-primary decreaseQtyBtn" data-item-id="' + id + '" type="button" style="margin-right: 10px;"><i class="bi bi-dash-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-success increaseQtyBtn" data-item-id="' + id + '" type="button">  <i class="bi bi-plus-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger removeItemBtn" data-item-id="' + id + '" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal"> <i class="fa fa-trash"></i></button></td>');

  // Append the new row to the table
  $('#cartItemTable').append(newRow);

  // Calculate total amount
  var totalAmount = 0;
  for (var i = 0; i < cart.items.length; i++) {
    var item = cart.items[i];
    var itemTotal = item.price * item.qty;
    totalAmount += itemTotal;
  }

  // Display the total amount
  $("#totalAmount").text(new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(totalAmount));

  // Optional: Log the updated cart array for debugging
  localStorage.removeItem("product_id");
  localStorage.removeItem("product_price");
  localStorage.removeItem("product_benefit");
  localStorage.removeItem("product_name");
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
    newRow.append('<td>' + new Intl.NumberFormat("en-US", {
      style: "currency",
      currency: "RWF",
    }).format(item.price) + '</td>');
    newRow.append('<td>' + item.qty + '</td>');
    newRow.append('<td>' + new Intl.NumberFormat("en-US", {
      style: "currency",
      currency: "RWF",
    }).format(parseFloat(item.price) * parseFloat(item.qty)) + '</td>');
    newRow.append('<td class="d-flex flex-row justify-content-center align-items-center"> <button class="btn btn-primary decreaseQtyBtn" data-item-id="' + item.id + '" type="button" style="margin-right: 10px;"><i class="bi bi-dash-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-success increaseQtyBtn" data-item-id="' + item.id + '" type="button"><i class="bi bi-plus-circle" style="color: rgb(255,255,255);"></i></button><button class="btn btn-danger removeItemBtn" data-item-id="' + item.id + '" type="button" style="margin-left: 20px;" data-bs-target="#delete-modal" data-bs-toggle="modal"> <i class="fa fa-trash"></i></button </td>');

    // Append the new row to the table
    $('#cartItemTable').append(newRow);
  });

  // Calculate total amount
  var totalAmount = calculateTotalAmount(cart.items);

  // Display the total amount
  $("#totalAmount").text(new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(totalAmount));
}











  
  