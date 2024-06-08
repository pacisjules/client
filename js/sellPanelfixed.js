$(document).ready(function () {
  
//   function checkInternetConnection() {
//     fetch('https://www.google.com', { mode: 'no-cors' }) // Attempt to fetch a resource from your server
//         .then(response => {
//           $('#wifi_status').attr('src', 'styles/icons/wifiOn.png');
//             //console.log('Internet is connected');
//         })
//         .catch(error => {
//             $('#wifi_status').attr('src', 'styles/icons/wifiOff.png');
//             //console.log('Internet is not connected');
//         });
// }

// // Check internet connection every second
// setInterval(checkInternetConnection, 500);



  
  // localStorage.setItem("temporary_hold",[]);
  localStorage.setItem("is_paid","Paid");
  localStorage.setItem('sessionid','');
  View_DaySalesRecord();
  getSelected();
  View_LastSalesRecord();
  View_ProductsRecord();
  addCartTablet();
  //holded_carts();
  setOldCart();
  
  
  
  
  
  
  
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



// $("#printRec").click(function() {
//  var sessid=localStorage.getItem('sessionid');

//  var url = `printreceipt.php/sess?id=${sessid}`;
//  window.open(url, "_blank");
// });


$("#printRec").click(function() {
  printInvoiceFunc();

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
      
      // $('#amadenis').hide();
      $("#finishModal").modal('show');
      $('#sessionid').html(response);
      localStorage.setItem('sessionid', response);
      localStorage.removeItem('customer_id');
      localStorage.removeItem('customer_phone');
      localStorage.removeItem('customer_names');
      localStorage.removeItem('customer_address');
      $("#searchCustomerNow").html("");
      $("#getnames").html("");
      $("#getphone").html("");
      $("#getaddress").html("");
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


function View_ProductsRecord() {
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!
  $.ajax({
    url: `functions/product/getallproductsbyspttablet.php?company=${company_ID}&spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#productslist").html(response);
      } else {
        //console.log(response);
        $("#productslist").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      // console.log("AJAX request failed!");
      // console.log("Error:", error);
    },
  });

  // Ajax End!
}



function setSelect(e) {
  console.log(e);
  
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!
  $.ajax({
    url: `functions/product/getallproductsbyspttabletcategory.php?company=${company_ID}&spt=${sales_point_id}&category=${e}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#productslist").html(response);
      } else {
        //console.log(response);
        $("#productslist").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      // console.log("AJAX request failed!");
      // console.log("Error:", error);
    },

    
  });

  // Ajax End!
}




function setSearch(e) {
  console.log(e);
  
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");


  // Ajax Start!
  $.ajax({
    url: `functions/product/tabletsearch.php?company=${company_ID}&spt=${sales_point_id}&name=${e}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#productslist").html(response);
      } else {
        //console.log(response);
        $("#productslist").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      // console.log("AJAX request failed!");
      // console.log("Error:", error);
    },

    
  });

  // Ajax End!
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


function AddToCartTablet(id,namepro,realprice, benefits, qty) {
    
  

   if (!id || !realprice || !benefits || !namepro || !qty) {
       console.log("Product information is incomplete. Cannot add to cart.");
       return;
   }
   
 var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
 
 


   var product = {
     id: id,
     price: realprice,
     benefit: benefits,
     name: namepro,
     qty: qty
   };
   cart.items.push(product);

 localStorage.setItem("cart", JSON.stringify(cart));

 $('#items_number').html(cart.items.length);

 // Create a new table row with the product data
 var newRow = $('<tr></tr>');
 newRow.append('<td>' + product.name + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(product.price) + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(product.price * product.qty) + '</td>');
 newRow.append(`<td class="actBtn">
 <div class="actBtnIn"  onclick="decreaseQtyshow(${product.id})">
 <img src="styles/icons/minus-sign.png" alt="" srcset="">
 </div>
 <div class="actBtnInTotal">
     <p>${product.qty}</p>
 </div> 
 <div class="actBtnIn"  onclick="increaseQtyshow(${product.id})">
 <img src="styles/icons/plus.png" alt="" srcset="">
 </div>
 <div class="actBtnIn" onclick="removeItemshow(${product.id})">
 <img src="styles/icons/remove.png" alt="" srcset="">
 </div>
</td>`)

 // Append the new row to the table
 $('#cartItemTableTablet').append(newRow);

 // Calculate total amount
 var totalAmount = 0;
 for (var i = 0; i < cart.items.length; i++) {
   var item = cart.items[i];
   var itemTotal = item.price * item.qty;
   totalAmount += itemTotal;
 }

 // Display the total amount
 $("#subtotal").text(new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(totalAmount));

 $("#subtotalPayable").text(new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(totalAmount));

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



function updateCartDisplaytablet(cart) {
  // Clear the existing cart table
  $('#cartItemTableTablet').empty();
  // var cart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: 0.00 };
  console.log(cart);
  $('#items_number').html(cart.items.length);

  

  // Loop through the cart items and update the table
  cart.items.forEach(item => {
    // Create a new table row with the product data
 var newRow = $('<tr></tr>');
 newRow.append('<td>' + item.name + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(item.price) + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(item.price * item.qty) + '</td>');
 newRow.append(`<td class="actBtn">
 <div class="actBtnIn"  onclick="decreaseQtyshow(${item.id})">
 <img src="styles/icons/minus-sign.png" alt="" srcset="">
 </div>
 <div class="actBtnInTotal">
     <p>${item.qty}</p>
 </div> 
 <div class="actBtnIn"  onclick="increaseQtyshow(${item.id})">
 <img src="styles/icons/plus.png" alt="" srcset="">
 </div>
 <div class="actBtnIn" onclick="removeItemshow(${item.id})">
 <img src="styles/icons/remove.png" alt="" srcset="">
 </div>
</td>`)

 // Append the new row to the table
 $('#cartItemTableTablet').append(newRow);

  });

  // Calculate total amount
  var totalAmount = calculateTotalAmount(cart.items);

  // Display the total amount
  $("#subtotal").text(new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(totalAmount));

  $("#subtotalPayable").text(new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(totalAmount));
}



function addCartTablet(id, namepro, p_c_qty, p_price, p_benefit) {

$('#unhold').css('opacity', 0);
console.log(id)
var qty = 1;
var negoPrice = $("#NegoPrice").val();

// Parse values to floats
qty = parseFloat(qty);
negoPrice = parseFloat(negoPrice);

var c_qty = p_c_qty;
var price = p_price;
var benefit = p_benefit;

// Parse stored values to floats
c_qty = parseFloat(c_qty);
price = parseFloat(price);
benefit = parseFloat(benefit);

// Check if qty is a valid number and greater than 0
if (isNaN(qty) || qty <= 0) {
    alert("Please enter a valid quantity.");
} else if (c_qty < qty) {
    alert("You entered more quantity than stock!");
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
    AddToCartTablet(id,namepro,realprice, benefits, qty);

    // // Clear input values and other elements
    // $("#Sales_qty").val("");
    // $("#NegoPrice").val("");
    // $("#searcProductNow").val("");
    // $("#gettedProduct").html("");
    // $("#gettedPrice").html("");
    // $("#gettedCQuantity").html("");

  }
}

function decreaseQtyshow(e) {
  var itemId = e;
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
    updateCartDisplaytablet(cart);
  }
}


function increaseQtyshow(e) {
  var itemId = e;
  console.log("decresacee: "+itemId);
  

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
    updateCartDisplaytablet(cart);
  }
}


function removeItemshow(e) {
  var itemId = e;
  console.log("decresacee: "+itemId);
  
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
    updateCartDisplaytablet(cart);
  }

  // Close the modal
  $('#delete-modal').modal('hide');

}


function proceed_tablet_sales () {
  $('#unhold').css('opacity', 1);
  
  if (localStorage.getItem("cart") === null || localStorage.getItem("cart") == '{}' || localStorage.getItem("cart") == undefined) {
    alert("Your cart is empty! Please add some products.");
    return;
  }else{
    $("#savep_sell_tablet").html("Please wait..");

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
      View_ProductsRecord();
      initializeCart();
      View_LastSalesRecord();
      $("#savep_sell_tablet").html("Sell Done");
      localStorage.setItem("is_paid","Paid");
     
      var checkbox = document.getElementById("flexSwitchCheckChecked");
      
      // Toggle the checkbox's checked state
      checkbox.checked = false;
      
      // $('#amadenis').hide();
      $("#finishModal").modal('show');
      $('#sessionid').html(response);
      localStorage.setItem('sessionid', response);
      localStorage.removeItem('customer_id');
      localStorage.removeItem('customer_phone');
      localStorage.removeItem('customer_names');
      localStorage.removeItem('customer_address');
      localStorage.removeItem('cart');
      $('#subtotalPayable').html("0 Rwf");
      $('#subtotal').html("0 Rwf");
      $('#cartItemTableTablet').empty();
    },
    error: function (xhr, status, error) {
      console.log("Error:", xhr.responseText, status);
      $("#savep_sell_tablet").html("Sell Failed");
      $("#savep_sell_tablet").style("backgroundColor","red");
    },
  });
  }


  
};


function printInvoiceFunc() {
  var ssess = localStorage.getItem("sessionid");
  console.log("session id : ", ssess);

  // Check if session ID is available
  if (!ssess) {
      console.error("Session ID is missing. Unable to make the AJAX request.");
      return;
  }

  // Ajax request to fetch sales data
  $.ajax({
      url: `functions/sales/printInvoice.php?sess_id=${ssess}`,
      method: 'GET',
      dataType: 'json',
      success: function(data) {
          if (data && data.data && data.data.length > 0) {
              const salesdata = data.data;
              const date = data.data[0].created_time;
              const customer = data.data[0].cust_name;
              const phone = data.data[0].phone;
              const sumtotal = data.sumtotal;
              const typereport = "Selleasep Receipt";
              console.log("customer : ",customer);
              printInvoice(salesdata, typereport, sumtotal,date,customer,phone);
          } else {
              console.error('Empty or invalid data received from the server.');
          }
          $("#finishModal").modal('hide');
      },
      error: function(xhr, status, error) {
          console.error('Error fetching daily sales data:', error);
      }
  });
}









function hold_tablet_sales () {
  
  
  $('#unhold').css('opacity', 1);
  if (localStorage.getItem("cart") === null || localStorage.getItem("cart") == '{}' || localStorage.getItem("cart") == undefined) {
    alert("Your cart is empty! Please add some products.");
    return;
  }else{

  if(!localStorage.getItem("temporary_hold")){
    $("#holdp_sell_tablet").html("Please wait..");
    var cart_body = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
    var cart_id = 'cart_' + Math.random().toString(36).substr(2, 9);
    var data={
      "cart_id":cart_id, 
      "cart_body":cart_body
    }
    localStorage.setItem("temporary_hold", [JSON.stringify(data)]);
    localStorage.removeItem('cart');
    $('#cartItemTableTablet').empty();
    $("#holdp_sell_tablet").html("HOLD ORDER");
    $('#subtotalPayable').html("0 Rwf");
      $('#subtotal').html("0 Rwf");
  }else {
    var old_hold_data = JSON.parse(localStorage.getItem("temporary_hold")); // Parse the existing hold data
    console.log(old_hold_data);
    if (!Array.isArray(old_hold_data)) {
      old_hold_data = [old_hold_data]; // Convert to array if it's not already an array
    }
    var cart_body = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
    var cart_id = 'cart_' + Math.random().toString(36).substr(2, 9);
    var data = {
      "cart_id": cart_id,
      "cart_body": cart_body
    }
    old_hold_data.push(data); // Append new data to the existing array
    console.log(old_hold_data);
    localStorage.setItem("temporary_hold", [JSON.stringify(old_hold_data)]);
    localStorage.removeItem('cart');
    $('#items_number').html('0');

    var check_holds=localStorage.getItem("temporary_hold");
    var check_holds_nums=null;
    
    if(check_holds.length === undefined){
      check_holds_nums=[JSON.parse(localStorage.getItem("temporary_hold"))];
    }else{
      check_holds_nums=JSON.parse(localStorage.getItem("temporary_hold"));
    }
    console.log()
    $('#holds_number').html(`${check_holds.length === undefined?'1':check_holds_nums.length} ${check_holds_nums.length>1?'Holds':'Hold'}`);
    


    $('#cartItemTableTablet').empty();
    $("#holdp_sell_tablet").html("HOLD ORDER");
    $('#subtotalPayable').html("0 Rwf");
      $('#subtotal').html("0 Rwf");
  }}
};




function setHoldedArrayToOtherStorage(cartId) {
  $('#unhold').css('opacity', 0);
  $('#cartItemTableTablet').html('');
  localStorage.removeItem("cart");
  

  console.log(cartId);
  
  // Retrieve holded carts from localStorage
  var holdedCarts = JSON.parse(localStorage.getItem("temporary_hold"));
  console.log(holdedCarts);


  var newHoldedCarts = null;

  if (holdedCarts.length === undefined) 
  {
    console.log('is empty', holdedCarts.length);
    newHoldedCarts=[JSON.parse(localStorage.getItem("temporary_hold"))];
  }else{
    newHoldedCarts=JSON.parse(localStorage.getItem("temporary_hold"));
  }
  
  
  // Filter out the cart we want to set into cart localStorage
  var cartToSet = newHoldedCarts.filter(cart => cart.cart_id == cartId)[0];
  console.log('setted unhold cart',cartToSet);
  
  // Remove the cart from holdedCarts array
  newHoldedCarts = newHoldedCarts.filter(cart => cart.cart_id != cartId);
  console.log('hold last cart',newHoldedCarts);
  
  // Set the modified array back to localStorage
  localStorage.removeItem("temporary_hold");
  localStorage.setItem("temporary_hold", JSON.stringify(newHoldedCarts));
  
  // Get the cart data from localStorage
  var cart = JSON.parse(localStorage.getItem("cart"));
  
  // Check if cart is an array before iterating over it
  if (Array.isArray(cart)) {
    // Append the cart we want to set to cart array
    cart.push(cartToSet);
  } else {
    // If cart is not an array, make it an array and then push the cart to set
    cart = cartToSet.cart_body;


  // Set the modified array back to localStorage
  localStorage.setItem("cart", JSON.stringify(cart));
  console.log(cart);


var newcart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
// Loop through the cart items and update the table
for (const product of newcart.items) {
  const {id, name, qty, price} = product;
  var newRow = $('<tr></tr>');
 newRow.append('<td>' + name + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(price) + '</td>');
 newRow.append('<td>' + new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
 }).format(price * qty) + '</td>');
 newRow.append(`<td class="actBtn">
 <div class="actBtnIn"  onclick="decreaseQtyshow(${id})">
 <img src="styles/icons/minus-sign.png" alt="" srcset="">
 </div>
 <div class="actBtnInTotal">
     <p>${qty}</p>
 </div> 
 <div class="actBtnIn"  onclick="increaseQtyshow(${id})">
 <img src="styles/icons/plus.png" alt="" srcset="">
 </div>
 <div class="actBtnIn" onclick="removeItemshow(${id})">
 <img src="styles/icons/remove.png" alt="" srcset="">
 </div>
</td>`)

 // Append the new row to the table
 $('#cartItemTableTablet').append(newRow);
}}
holded_carts();
$("#holdermodal").modal('hide');

// Calculate total amount
var totalAmount = 0;
for (var i = 0; i < newcart.items.length; i++) {
  var item = newcart.items[i];
  var itemTotal = item.price * item.qty;
  totalAmount += itemTotal;
}

// Display the total amount
$("#subtotal").text(new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "RWF",
}).format(totalAmount));

$("#subtotalPayable").text(new Intl.NumberFormat("en-US", {
 style: "currency",
 currency: "RWF",
}).format(totalAmount));


var check_holds=localStorage.getItem("temporary_hold");
var check_holds_nums=null;

if(check_holds.length === undefined){
  check_holds_nums=[JSON.parse(localStorage.getItem("temporary_hold"))];
}else{
  check_holds_nums=JSON.parse(localStorage.getItem("temporary_hold"));
}
console.log()
$('#holds_number').html(`${check_holds.length === undefined?'1':check_holds_nums.length} ${check_holds_nums.length>1?'Holds':'Hold'}`);
$('#items_number').html(newcart.items.length);
}



function holded_carts() {

  $("#holdermodal").modal('show');
  $('#holdercarts').html('');
  
  // Retrieve cart data from localStorage
  var cart = JSON.parse(localStorage.getItem("temporary_hold"));

  console.log('cart',cart);
  console.log('cart size',cart.length);

  var useArray=null;

  if (cart.length === undefined) {
    console.log('is empty', cart.length);
    useArray=[JSON.parse(localStorage.getItem("temporary_hold"))];


    useArray.forEach((cartItem) => {
      var newRow = $(`<tr></tr>`);
      newRow.append(`<td>` + cartItem.cart_id + `</td>`);
      var ls=cartItem.cart_body;
      var my_array=[];
      my_array.push(ls.items);
      var totalAmount = 0;
      var num_items=0;
      var cart_id = cartItem.cart_id;
      // Initialize total amount for each cart item
      
      // Check if cart body is an array before iterating over it
      if (Array.isArray(my_array)) {
        // Loop through each item in the cart body to calculate total amount
        my_array.forEach((item) => {
          //totalAmount += item.price;
          item.forEach((t)=>{
            totalAmount += t.price;
            num_items+=1;
            console.log(t.price)
          })
          //console.log(item) // Add each item's price to the total amount
        });
      } else {
        // Handle the case where cart body is not an array
        console.error("Cart body is not an array for cart item:", cartItem);
      }
      
      newRow.append(`<td>` + new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "RWF",
        minimumFractionDigits: 0
      }).format(totalAmount) + ` - `+num_items+` items</td>`);
      newRow.append(`<td><button class="btn btn-success btn-sm" onclick="setHoldedArrayToOtherStorage('${cart_id}')"> Set </button></td>`);
      
      // Append the new row to the table
      $('#holdercarts').append(newRow);
    });

  }else{
    console.log('is not empty', cart.length);
    useArray=JSON.parse(localStorage.getItem("temporary_hold"));

    useArray.forEach((cartItem) => {
      var newRow = $(`<tr></tr>`);
      newRow.append(`<td>` + cartItem.cart_id + `</td>`);
      var ls=cartItem.cart_body;
      var my_array=[];
      my_array.push(ls.items);
      var totalAmount = 0;
      var num_items=0;
      var cart_id = cartItem.cart_id;
      // Initialize total amount for each cart item
      
      // Check if cart body is an array before iterating over it
      if (Array.isArray(my_array)) {
        // Loop through each item in the cart body to calculate total amount
        my_array.forEach((item) => {
          //totalAmount += item.price;
          item.forEach((t)=>{
            totalAmount += t.price;
            num_items+=1;
            console.log(t.price)
          })
          //console.log(item) // Add each item's price to the total amount
        });
      } else {
        // Handle the case where cart body is not an array
        console.error("Cart body is not an array for cart item:", cartItem);
      }
      
      newRow.append(`<td>` + new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "RWF",
        minimumFractionDigits: 0
      }).format(totalAmount) + ` - `+num_items+` items</td>`);
      newRow.append(`<td><button class="btn btn-success btn-sm" onclick="setHoldedArrayToOtherStorage('${cart_id}')"> Set </button></td>`);
      
      // Append the new row to the table
      $('#holdercarts').append(newRow);
      
    });

  }

  
  // Loop through each item and append to the table
  
}



function refreshPage(){
    location.reload();
}



function setOldCart(){
  $('#unhold').css('opacity', 1);

  var newcart = JSON.parse(localStorage.getItem("cart")) || { items: [], total: '0.00 FRW' };
  // Loop through the cart items and update the table
  for (const product of newcart.items) {
    const {id, name, qty, price} = product;
    var newRow = $('<tr></tr>');
   newRow.append('<td>' + name + '</td>');
   newRow.append('<td>' + new Intl.NumberFormat("en-US", {
     style: "currency",
     currency: "RWF",
   }).format(price) + '</td>');
   newRow.append('<td>' + new Intl.NumberFormat("en-US", {
     style: "currency",
     currency: "RWF",
   }).format(price * qty) + '</td>');
   newRow.append(`<td class="actBtn">
   <div class="actBtnIn"  onclick="decreaseQtyshow(${id})">
   <img src="styles/icons/minus-sign.png" alt="" srcset="">
   </div>
   <div class="actBtnInTotal">
       <p>${qty}</p>
   </div> 
   <div class="actBtnIn"  onclick="increaseQtyshow(${id})">
   <img src="styles/icons/plus.png" alt="" srcset="">
   </div>
   <div class="actBtnIn" onclick="removeItemshow(${id})">
   <img src="styles/icons/remove.png" alt="" srcset="">
   </div>
  </td>`)
  
   // Append the new row to the table
   $('#cartItemTableTablet').append(newRow);
  }

  
  // Calculate total amount
  var totalAmount = 0;
  for (var i = 0; i < newcart.items.length; i++) {
    var item = newcart.items[i];
    var itemTotal = item.price * item.qty;
    totalAmount += itemTotal;
  }
  
  // Display the total amount
  $("#subtotal").text(new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "RWF",
  }).format(totalAmount));
  
  $("#subtotalPayable").text(new Intl.NumberFormat("en-US", {
   style: "currency",
   currency: "RWF",
  }).format(totalAmount));
  $('#items_number').html(newcart.items.length);
}








function printInvoice(salesdata,typereport,sumtotal,date,customer,phone) {
  // Calculate the total amount with interest
  const currentDate = new Date();

const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');

const formattedDate = `${year}-${month}-${day}`;

const c_name = localStorage.getItem("companyName");
const Phone =  localStorage.getItem("phoneboss");
const Phonemana =  localStorage.getItem("phonemana");
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
                  <td style="padding-top:20px; font-size: 12px; color: #1f0c57; font-family: 'Open Sans', sans-serif;   vertical-align: top; text-align: left;">
                  Done By : ${nameManager} <br> Tel: ${Phone} , ${Phonemana}
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
                <td style="font-size: 18px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                  <strong>Customer : ${customer}</strong>
                </td>
              <tr>
              <tr>
                <td style="font-size: 17px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                  <strong>phone : ${phone}</strong>
                </td>
              <tr>
                <td style="font-size: 16px; color: #1f0c57; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                  <small>Receipt Date : ${date}</small>
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
          }).format(parseFloat(sumtotal))}</strong>
          </td>
          <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
            
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






  
  