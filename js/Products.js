$(document).ready(function () {
    
  //   updateSptandcompany();  
    RemoveProductID();
    RemoveCategoryID();
    getProductid();
  
    setUpdates();
    View_ProductsRecord();
    DisableProductID();
    SetProductID();
    populateSupplier();
    populateStores();
    populateSalespoints();
    populateUnittypes();
    populateUnittypesSales();
    populateSuppliers();
    SetSPProductID();
    populateProducts();
    populateProductCategory();
    
     
      $("#generateproductReport").click(function () {
      
        View_productRecordPrint();
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
        url:`functions/product/getaddinghistoryproducts.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
          try {
              console.log("Success Response: ", response);
  
              if (response.data && response.data.length > 0) {
                   const historydata = response.data;
                   console.log(historydata);
                   const typereport =  "Adding Product History";
                   printProducthistory(historydata,typereport);
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
        url:`functions/product/geteditinghistoryproducts.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
          try {
              console.log("Success Response: ", response);
  
              if (response.data && response.data.length > 0) {
                   const historydata = response.data;
                   console.log(historydata);
                   const typereport =  "Editing Product History";
                   printProducthistory(historydata,typereport);
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
        url:`functions/product/getdeletehistoryproducts.php?date=${formattedDate}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function(response) {
          try {
              console.log("Success Response: ", response);
  
              if (response.data && response.data.length > 0) {
                   const historydata = response.data;
                   console.log(historydata);
                   const typereport =  "Deleting Product History";
                   printProducthistory(historydata,typereport);
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
     
    
    
    
    
    
    
    
    
    
    
    
  
    $("#searcProductNow").on("input", function (e) {
  
      var company_ID = localStorage.getItem("CoID");
      var sales_point_id = localStorage.getItem("SptID");
    
      // Ajax Start!
      $.ajax({
        url: `functions/product/getallproductsbysearch.php?company=${company_ID}&spt=${sales_point_id}&name=${e.target.value}`,
        method: "POST",
        context: document.body,
        success: function (response) {
          if (response) {
            //console.log(response);
            $("#spt_table").html(response);
          } else {
            //console.log(response);
            $("#spt_table").html("Not Any result");
          }
        },
        error: function (xhr, status, error) {
          // console.log("AJAX request failed!");
          // console.log("Error:", error);
        },
      });
      // Ajax End!   
   });
  
  
  
  
    $("#Sale_qty").change(function (e) {
      console.log(e.target.value);
    
      var qty = $("#Sale_qty").val();
    
      var c_qty = localStorage.getItem("current_qty");
      var price = localStorage.getItem("c_price");
      var benefit = localStorage.getItem("c_benefit");
    
      if (parseInt(c_qty) < parseInt(qty)) {
        $("#calc_result").html("You entered more quantity than stock!");
    
        $("#save_sell").css({
          display: "none"
        });
    
      } else {
        var total = parseFloat(qty) * parseFloat(price);
        var total_benefit = parseFloat(qty) * parseFloat(benefit);
    
        if (qty === "") {
          $("#calc_result").html("");
          $("#save_sell").css({
            display: "none"
          });
    
        } else {
          $("#save_sell").css({
            display: "inline"
          });
          $("#calc_result").html(
            "Total Amount: " + total + " and Benefit: " + total_benefit
          );
        }
      }
    });
    
  
    $("#Sale_qty").on("input", function (e) {
      console.log(e.target.value);
    
      var qty = $("#Sale_qty").val();
    
      var c_qty = localStorage.getItem("current_qty");
      var price = localStorage.getItem("c_price");
      var benefit = localStorage.getItem("c_benefit");
    
      if (parseInt(c_qty) < parseInt(qty)) {
        $("#calc_result").html("You entered more quantity than stock!");
    
        $("#save_sell").css({
          display: "none"
        });
    
      } else {
        var total = parseFloat(qty) * parseFloat(price);
        var total_benefit = parseFloat(qty) * parseFloat(benefit);
    
        if (qty === "") {
          $("#calc_result").html("");
          $("#save_sell").css({
            display: "none"
          });
    
        } else {
          $("#save_sell").css({
            display: "inline"
          });
          $("#calc_result").html(
            "Total Amount: " + total + " and Benefit: " + total_benefit
          );
        }
      }
    });



    $("#savecategory").click(function () {
      $("#savecategory").html("Please wait..");
      // Retrieve values from input fields
      var name = $("#categoryname").val();
  
      // Retrieve values from localStorage
      var company_id = localStorage.getItem("CoID");
  
      // Start AJAX request
      $.ajax({
        url: "functions/product/addnewcategory.php",
        method: "POST",
        data: {
          name: name,
          company_id: company_id,
        },
        success: function (response) {
          $("#categoryname").val("");
          populateProductCategory();
          populateProducts();
        },
        error: function (error) {},
      });
      $("#savecategory").html("Save category");
       // Update another element's text (saveNewUser)
    });
  
    
    
    
    $("#saveproduct").click(function () {
      // Retrieve values from input fields
      var name = $("#name").val();
      var price = $("#price").val();
      var benefit = $("#benefit").val();
      var barcode = $("#barcode").val();
      var description = $("#description").val();
      var category_id = $("#categorySelect").val();
      // Retrieve values from localStorage
      var company_ID = localStorage.getItem("CoID");
      var sales_point_id = localStorage.getItem("SptID");
      var use_id= parseInt(localStorage.getItem("UserID"));
  
      // Start AJAX request
      $.ajax({
        url: "functions/product/addnewproduct.php",
        method: "POST",
        data: {
          name: name,
          price: price,
          benefit: benefit,
          barcode: barcode,
          company_ID: company_ID,
          sales_point_id: sales_point_id,
          category_id:category_id,
          status: 1,
          description: description,
          user_id:use_id,
        },
        success: function (response) {
          $("#name").val("");
          $("#price").val("");
          $("#benefit").val("");
          $("#barcode").val("");
          $("#description").val("");
          $("#add_product_modal").modal("hide");
          View_ProductsRecord();
        },
        error: function (error) {},
      });
  
    });
    
      $("#purchaseBtn").click(function () {
      // Retrieve values from input fields
      var supplier = $("#supplierSelect").val();
      var store_id = $("#storerSelect").val();
      var unit_id = $("#unitSelect").val();
      var container = $("#containernum").val();
      var quantity = $("#qty").val();
      var price_per_unity = $("#priceunity").val();
  
      // Retrieve values from localStorage
      var company_ID = localStorage.getItem("CoID");
      var use_id= parseInt(localStorage.getItem("UserID"));
      var product_id = parseInt(localStorage.getItem("purchid"));
     console.log
      // Start AJAX request
      $.ajax({
        url: "functions/purchase/addnewpurchaseMultistore.php",
        method: "POST",
        data: {
          product_id: product_id,
          store_id: store_id,
          company: company_ID,
          unit_id:unit_id,
          container:container,
          quantity: quantity,
          price_per_unity: price_per_unity,
          supplier_id: supplier,
          user_id:use_id,
        },
        success: function (response) {
          $("#qty").val("");
          $("#priceunity").val("");
          $("#purchase_modal").modal("hide");
          View_ProductsRecord();
           $("#successmodal").modal("show");
                    setTimeout(function() {
                          location.reload();
                      }, 1000);
        },
        error: function (error) {
            console.log(error);
            $("#purchase_modal").modal("hide");
            $("#successmodal").modal("show");
                    setTimeout(function() {
                          location.reload();
                      }, 1000);
                    
        },
      });
    });
    
    
    
    
     $("#SalesPointpurchaseBtn").click(function () {
      // Retrieve values from input fields
      var supplier = $("#supplieSelect").val();
      var spt_id = $("#salespointSelect").val();
  
      var quantity = $("#qtii").val();
      var price_per_unity = $("#priceunitii").val();
  
      // Retrieve values from localStorage
      var company_ID = localStorage.getItem("CoID");
      var use_id= parseInt(localStorage.getItem("UserID"));
      var product_id = parseInt(localStorage.getItem("spproductid"));
     console.log
      // Start AJAX request
      $.ajax({
        url: "functions/purchase/addnewpurchaseSalesPoint.php",
        method: "POST",
        data: {
          product_id: product_id,
          spt_id: spt_id,
          company: company_ID,
          quantity: quantity,
          price_per_unity: price_per_unity,
          supplier_id: supplier,
          user_id:use_id,
        },
        success: function (response) {
          $("#qtii").val("");
          $("#priceunitii").val("");
          $("#purchaseSalespoint_modal").modal("hide");
          View_ProductsRecord();
           $("#successmodal").modal("show");
                    setTimeout(function() {
                          location.reload();
                      }, 1000);
        },
        error: function (error) {
            console.log(error);
            $("#purchaseSalespoint_modal").modal("hide");
            $("#successmodal").modal("show");
                    setTimeout(function() {
                          location.reload();
                      }, 1000);
                    
        },
      });
  
    });
  
  
  
  
    //Sell Single
  
    $("#save_sell").click(function () {
  
      //var price = localStorage.getItem("c_price");
      var qty = $("#Sale_qty").val();
  
      // Retrieve values from localStorage
      var use_id= parseInt(localStorage.getItem("UserID"));
      var sales_point_id = localStorage.getItem("SptID");
      var product_id = parseInt(localStorage.getItem("co_id"));
      var paid_jk=localStorage.getItem("is_paid");
      var cust_nms= $("#customer_name").val();
      var  cust_phone= $("#customer_phone").val();
  
  
      if(paid_jk==="Paid"){
           
        cust_nms= "Normal Customer";
        cust_phone= "1234567890";
      }else{
        
      
         
      }
  
      // Start AJAX request
      $.ajax({
        url: "functions/sales/addnewsales.php",
        method: "POST",
        data: {
          product_id:product_id,
          sales_point_id:sales_point_id,
          quantity:qty,
          sales_type:1,
          paid_status:paid_jk,
          service_amount:0,
          cust_name:cust_nms,
          phone:cust_phone,
          user_id:use_id
        },
        success: function (response) {
          alert("Sell Done");
          localStorage.removeItem("current_qty");
          localStorage.removeItem("c_price");
          localStorage.removeItem("c_benefit");
  
          $("#sell-now").modal("hide");
          View_ProductsRecord();
          $("#save_sell").html("Sell");
        },
        error: function (error) {},
      });
    });
  
  
  
  
    //Update Product
    $("#updateproduct").click(function () {
      $("#updateproduct").html("Please wait..");
  
      var name = $("#Up_name").val();
      var price = $("#Up_price").val();
      var benefit = $("#Up_benefit").val();
      var description = $("#Up_desc").val();
  
      var sales_point_id = localStorage.getItem("SptID");
      var UserID = localStorage.getItem("UserID");
      var product_id = parseInt(localStorage.getItem("co_id"));
  
      //Ajax Start!
      $.ajax({
        url: "functions/product/updateproduct.php",
        method: "POST",
  
        data: {
          product_id: product_id,
          salespt_id: sales_point_id,
          user_id: UserID,
          name: name,
          price: price,
          benefit: benefit,
          description: description,
          barcode: 12345,
        },
  
        success: function (response) {
          View_ProductsRecord();
          $("#updateproduct").html("Update");
          $("#edit_product_modal").modal("hide");
          localStorage.removeItem("co_id");
        },
        error: function (error) {
          $("#updateproduct").html("Update");
          //console.log(error.responseText);
        },
      });
    });



    //Update Category
    $("#updatecategory").click(function () {
      $("#updatecategory").html("Please wait..");
  
      var name = $("#cat_name").val();
      var category_id = parseInt(localStorage.getItem("category_id"));
  
      //Ajax Start!
      $.ajax({
        url: "functions/product/updatecategory.php",
        method: "POST",
  
        data: {
          category_id: category_id,
          name: name,
        },
  
        success: function (response) {
          View_ProductsRecord();
          $("#updatecategory").html("Update");
          $("#edit_category_modal").modal("hide");
          $("#add_category_modal").modal("show");
          populateProducts();
          populateProductCategory();

          localStorage.removeItem("category_id");
        },
        error: function (error) {
          $("#updatecategory").html("Update");
          //console.log(error.responseText);
        },
      });
    });

    
    //Delete Category
    $("#removeCategory").click(function () {
      $("#removeCategory").html("Please wait..");
      var category_id = parseInt(localStorage.getItem("category_id"));
  
      //Ajax Start!
      $.ajax({
        url: "functions/product/deletecategory.php",
        method: "POST",
  
        data: {
          category_id: category_id,
        },
  
        success: function (response) {
          console.log(response);
          populateProductCategory();
          populateProducts();
          $("#removeCategory").html("Delete");
          $("#delete-modal-category").modal("hide");
          $("#add_category_modal").modal("show");
          var toast = new bootstrap.Toast($("#myToast"));
          toast.show();
        },
        error: function (error) {
          console.log(error);
          var toast = new bootstrap.Toast($("#myToast"));
          toast.show();
          $("#removeCategory").html("Delete");
        },
      });
    });



  
    //Delete Product
    $("#removeProduct").click(function () {
      $("#removeProduct").html("Please wait..");
      var product_id = parseInt(localStorage.getItem("co_id"));
       var sales_point_id = localStorage.getItem("SptID");
      var UserID = localStorage.getItem("UserID");
  
      //Ajax Start!
      $.ajax({
        url: "functions/product/deleteproduct.php",
        method: "POST",
  
        data: {
          product_id: product_id,
          spt: sales_point_id,
          user_id:UserID,
        },
  
        success: function (response) {
          console.log(response);
          View_ProductsRecord();
          $("#removeProduct").html("Delete");
          $("#delete-modal").modal("hide");
          var toast = new bootstrap.Toast($("#myToast"));
          toast.show();
        },
        error: function (error) {
          console.log(error);
          var toast = new bootstrap.Toast($("#myToast"));
          toast.show();
          $("#removeProduct").html("Delete");
        },
      });
    });
  
    //Disable Product
    $("#disableorenable").click(function () {
      $("#disableorenable").html("Please wait..");
      var product_id = parseInt(localStorage.getItem("co_id"));
      var c_status = parseInt(localStorage.getItem("currentStatus"));
  
      var currentStatus = null;
  
      if (c_status == 1) {
        currentStatus = 0;
      } else {
        currentStatus = 1;
      }
  
      //Ajax Start!
      $.ajax({
        url: "functions/product/disableproduct.php",
        method: "POST",
  
        data: {
          product_id: product_id,
          state: currentStatus,
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
      // var alert = $("#Inve_Alert").val();
      var product_id = localStorage.getItem("co_id");
      var user_id = localStorage.getItem("UserID");
      var salespt_id = localStorage.getItem("SptID");
  
      // Start AJAX request
      $.ajax({
        url: "functions/inventory/increseinventory.php",
        method: "POST",
        data: {
          product_id: product_id,
          quantity: qty,
          salespt_id:salespt_id,
          user_id: user_id,
          // alert_quantity: alert,
          
        },
        success: function (response) {
          $("#Inve_Quantity").val("");
          // $("#Inve_Alert").val("");
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
          alert_quantity: alert,
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
  });
  
  function View_ProductsRecord() {
    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/product/getallproductsbyspt.php?company=${company_ID}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          //console.log(response);
          $("#spt_table").html(response);
        } else {
          //console.log(response);
          $("#spt_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
  
  function updateSptandcompany() {
    // Retrieve values from localStorage
    var company_ID = localStorage.getItem("CoID");
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/inventory/updateinventorysPT.php?company=${company_ID}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
       success: function(response){
              console.log(response);
              // Handle success response here
              alert('Inventory updated successfully!');
          },
          error: function(xhr, status, error){
              // Handle error here
              console.error(xhr.responseText);
              alert('Error updating inventory. Please try again later.');
          }
    });
    // Ajax End!
  }
  
  
  function populateUnittypes() {
    
  
      $.ajax({
          url: "functions/multistore/getallUnittype.php",
          method: "GET", 
          success: function (response) {
              console.log(response);
              $("#unitSelect").html(response);
          },
          error: function (error) {
              console.log(error);
          }
      });
  }
  
  function populateUnittypesSales() {
    
  
      $.ajax({
          url: "functions/multistore/getallUnittype.php",
          method: "GET", 
          success: function (response) {
              console.log(response);
              $("#unitSelectsales").html(response);
          },
          error: function (error) {
              console.log(error);
          }
      });
  }
  
  
   function populateSalespoints() {
      var company_ID = parseInt(localStorage.getItem("CoID"));
  
      $.ajax({
          url: "functions/multistore/getallCompanySalesPoints.php",
          method: "GET", // Change to GET method
          data: { company: company_ID },
          success: function (response) {
              console.log("sales point : ",response);
              $("#salespointSelect").html(response);
          },
          error: function (error) {
              console.log("Error : ",error);
          }
      });
  }
  
   function populateSupplier() {
      var company_ID = parseInt(localStorage.getItem("CoID"));
  
      $.ajax({
          url: "functions/supplier/getsupplierforpurchase.php",
          method: "GET", // Change to GET method
          data: { company: company_ID },
          success: function (response) {
              console.log(response);
              $("#supplierSelect").html(response);
          },
          error: function (error) {
              console.log(error);
          }
      });
  }
  
  function populateSuppliers() {
      var company_ID = parseInt(localStorage.getItem("CoID"));
  
      $.ajax({
          url: "functions/supplier/getsupplierforpurchase.php",
          method: "GET", // Change to GET method
          data: { company: company_ID },
          success: function (response) {
              console.log(response);
              $("#supplieSelect").html(response);
          },
          error: function (error) {
              console.log(error);
          }
      });
  }
  
   function populateStores() {
      var company_ID = parseInt(localStorage.getItem("CoID"));
  
      $.ajax({
          url: "functions/multistore/getallCompanyStorePurchase.php",
          method: "GET", // Change to GET method
          data: { company: company_ID },
          success: function (response) {
              console.log(response);
              $("#storerSelect").html(response);
          },
          error: function (error) {
              console.log(error);
          }
      });
  }


  function populateProducts() {
    var company_ID = parseInt(localStorage.getItem("CoID"));

    $.ajax({
        url: `functions/product/getallCompanyCategories.php`,
        method: "GET", // Change to GET method
        data: { company: company_ID },
        success: function (response) {
            console.log(response);
            $("#categorySelect").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function populateProductCategory() {
  var company_ID = parseInt(localStorage.getItem("CoID"));

  $.ajax({
      url: `functions/product/getallCompanyCategorieslist.php`,
      method: "GET", // Change to GET method
      data: { company: company_ID },
      success: function (response) {
          console.log(response);
          $("#ct_table").html(response);
      },
      error: function (error) {
          console.log(error);
      }
  });
}
  
  
  
  function RemoveProductID(e) {
    console.log(e);
    localStorage.setItem("co_id", e);
  }


  function RemoveCategoryID(e) {
    console.log(e);
    localStorage.setItem("category_id", e);
  }
  
  function getProductid(id){
      console.log("purchase product is"+ id);
      localStorage.setItem("purchid", id);
  }
  
  function SetSPProductID(id){
      console.log("purchase sales point id is"+ id);
      localStorage.setItem("spproductid", id);
  }
  
  function DisableProductID(e, a) {
    if (a == 1) {
      $("#disableorenable").removeClass("btn btn-success");
      $("#disableorenable").addClass("btn btn-danger");
      $("#disableorenable").html("Disable");
    } else {
      $("#disableorenable").removeClass("btn btn-danger");
      $("#disableorenable").addClass("btn btn-success");
      $("#disableorenable").html("Enable");
    }
  
    console.log(e);
    console.log(a);
    localStorage.setItem("co_id", e);
    localStorage.setItem("currentStatus", a);
  }
  
  function setUpdates(name, price, benefit, description, id) {
    console.log(name);
    $("#Up_name").val(name);
    $("#Up_price").val(price);
    $("#Up_benefit").val(benefit);
    $("#Up_desc").html(description);
  
    localStorage.setItem("co_id", id);
  }

  function setUpdateCategory(name, id) {
    console.log(name);
    $("#cat_name").val(name);
    localStorage.setItem("category_id", id);
  }
  
  function SetProductID(e, name, price, benefit, c_qty) {
    console.log("selected Product: " + e);
    localStorage.setItem("is_paid", "Paid");
  
    $("#product_name").html(name);
  
    $("#product_price").html(
      new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "RWF",
      }).format(price)
    );
  
    $("#current_quantity").html(c_qty);
  
    $("#Up_benefit").val(benefit);
  
    localStorage.setItem("c_price", price);
    localStorage.setItem("c_benefit", benefit);
    localStorage.setItem("current_qty", c_qty);
  
    localStorage.setItem("co_id", e);
  }
  
  
  
   function View_productRecordPrint() {
      // Retrieve values from localStorage
      var company_ID = localStorage.getItem("CoID");
      var sales_point_id = localStorage.getItem("SptID");
    
      // Ajax Start!
  
      $.ajax({
        url:`functions/product/getallproductsbysptprint.php?company=${company_ID}&spt=${sales_point_id}`,
        method: "POST",
        context: document.body,
        success: function (response) {
          if (response) {
            console.log(response);
            const inventorydata = response.data;
            const inventorytotal = inventorydata.length;
            const typereport = "Product Report";
            printInventoryReport(inventorydata,inventorytotal, typereport);
            
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
    
  
  
  
  
  
  
  
  
  
  
  
  function printProducthistory(historydata,typereport) {
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
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.price}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.benefit}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.invquantity}</td>
    <td style="font-size: 12px;font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal;  vertical-align: top; padding: 0 0 7px;" align="center" width="150">${item.status}</td>
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
              Product
              </th>
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
            Price
            </th>
    
             
    
              <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="100">
              Benefit
              </th> 
              
              <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
              Quantity
              </th>
            
            <th style="font-size: 16px; font-family: 'Open Sans', sans-serif; color: #1f0c57; font-weight: bold; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center" width="150">
              Status
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
              <strong>Total Ptoduct: ${inventorytotal}</strong>
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
  
  