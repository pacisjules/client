$(document).ready(function () {
  View_company_category();
  View_company_category_forselect();

  View_company_pages_forselect();
  View_company_permission();
  View_company_users();
  View_salespointRecord();
  SelectEdisalespoint();
  View_shift();


  $("#VisitSalesPointBtn").click(function () {
    $("#VisitSalesPointBtn").html("Please wait..");
    localStorage.removeItem("SptID");
    
    var newsalepoint = localStorage.getItem("salespointid");
    $.ajax({
      url: "functions/salespoint/setmysalespoint.php",
      method: "POST",
      data: {
        salespointid: newsalepoint,
      },
      success: function (data) {
        console.log(data);
      },
    });
    localStorage.setItem("SptID", newsalepoint);
    localStorage.removeItem("salespointid");


    // Navigate to index.php after a short delay (e.g., 1 second)
    setTimeout(function() {
        window.location.href = "index.php";
    }, 1000); // Adjust the delay time as needed
});









  //Update User
  $("#EditUser").click(function () {
    $("#EditUser").html("Please wait..");

    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var phone = $("#phone").val();
    var email = $("#email").val();
    var username = $("#username").val();
    var user_category = $("#user_category").val();
    var user_shift = $("#user_shift").val();

    var company_id = localStorage.getItem("CoID");
    var user_id = parseInt(localStorage.getItem("select_user_id"));

    //Ajax Start!
    $.ajax({
      url: "functions/settings/updateusers.php",
      method: "POST",

      data: {
        first_name: first_name,
        last_name: last_name,
        phone: phone,
        email: email,
        username: username,
        user_category: user_category,
        user_shift: user_shift,
        company_id: company_id,
        user_id: user_id,
      },

      success: function (response) {
        View_company_users();
        $("#EditUser").html("Edit User");
        $("#modal_user").modal("hide");
        localStorage.removeItem("select_user_id");
      },
      error: function (error) {
        $("#EditUser").html("Update");
        console.log(error.responseText);
      },
    });
  });
  
  
  
  
    $("#EditPermission").click(function () {
    $("#EditPermission").html("Please wait..");

    var namepermi = $("#namepermi").val();
    var cat_id = $("#cat_id").val();
    var page_id = $("#page_id").val();
    var permid = parseInt(localStorage.getItem("permid"));

    //Ajax Start!
    $.ajax({
      url: "functions/settings/updatepermission.php",
      method: "POST",

      data: {
        permid: permid,
        namepermi: namepermi,
        cat_id: cat_id,
        page_id: page_id,
      },

      success: function (response) {
        View_company_permission();
        $("#EditPermission").html("Edit");
        $("#modal_permission").modal("hide");
        localStorage.removeItem("permid");
        var toast = new bootstrap.Toast($("#myToastPermedit"));
          toast.show();
      },
      error: function (error) {
        $("#EditPermission").html("error");
        console.log(error.responseText);
      },
    });
  });
  
  
  

  $("#addCategory").click(function () {
    // Retrieve values from input fields
    var category_name = $("#category").val();
    var company_id = localStorage.getItem("CoID");

    if (category_name === "") {
      alert("Please enter category name");
    } else {
      // Start AJAX request
      $.ajax({
        url: "functions/settings/addnewcategory.php",
        method: "POST",
        data: {
          category_name: category_name,
          company_id: company_id,
        },
        success: function (response) {
          View_company_category();
          $("#category_name").val("");
          var toast = new bootstrap.Toast($("#myToast"));
          toast.show();
        },
        error: function (error) {},
      });
    }
  });


  $("#AddPermission").click(function () {
    // Retrieve values from input fields
    var permission_name = $("#permission").val();
    var category = $("#categories").val();
    var page = $("#pages").val();
    var company_id = localStorage.getItem("CoID");

    if (permission_name === "") {
      alert("Please enter permission name");
    } else {
      // Start AJAX request
      $.ajax({
        url: "functions/settings/addnewPermission.php",
        method: "POST",
        data: {
            name: permission_name,
            cat_id:category,
            page_id:page,
            company_id: company_id,
        },
        success: function (response) {
          View_company_permission();
            console.log(response);
          $("#permission").val("");
          var toast = new bootstrap.Toast($("#myToastPerm"));
          toast.show();
        },
        error: function (error) {
            console.log(error);
        },
      });
    }
  });
  
  
  
  
  
  $("#removePermission").click(function () {
    // Retrieve values from input fields
    var perm_id = localStorage.getItem("permid");

      // Start AJAX request
      $.ajax({
        url: "functions/settings/deletepermission.php",
        method: "POST",
        data: {
            perm_id: perm_id,
        },
        success: function (response) {
        $("#permissiondelete-modal").modal("hide");
          View_company_permission();
            console.log(response);
          var toast = new bootstrap.Toast($("#myToastPermdelete"));
          toast.show();
        },
        error: function (error) {
            console.log(error);
        },
      });
    
  });
  
  
  
    $("#removeCategory").click(function () {
    // Retrieve values from input fields
    var cat_id = localStorage.getItem("cat_id");
    

      // Start AJAX request
      $.ajax({
        url: "functions/settings/deletecategory.php",
        method: "POST",
        data: {
            cat_id: cat_id,
        },
        success: function (response) {
        $("#categorydelete-modal").modal("hide");
          View_company_category();
            console.log(response);
          var toast = new bootstrap.Toast($("#myToastcatedelete"));
          toast.show();
        },
        error: function (error) {
            console.log(error);
        },
      });
    
  });
  
  
  
      $("#EditCategory").click(function () {
    $("#EditCategory").html("Please wait..");

    var category_name = $("#category_name").val();
    var statuscategory = $("#statuscategory").val();
    var cat_id = parseInt(localStorage.getItem("cat_id"));

    //Ajax Start!
    $.ajax({
      url: "functions/settings/updatecategory.php",
      method: "POST",

      data: {
        cat_id: cat_id,
        category_name: category_name,
        status: statuscategory,
      },

      success: function (response) {
        View_company_category();
        $("#EditCategory").html("Edit");
        $("#modal_category").modal("hide");
        localStorage.removeItem("cat_id");
        var toast = new bootstrap.Toast($("#myToastcateedit"));
          toast.show();
      },
      error: function (error) {
        $("#EditCategory").html("error");
        console.log(error.responseText);
      },
    });
  });




});










function View_company_category() {
  // Retrieve values from localStorage
  var company_id = localStorage.getItem("CoID");

  // Ajax Start!

  $.ajax({
    url: `functions/settings/getcategoriesbycoid.php?coid=${company_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        console.log(response);
        $("#category_tbl").html(response);
      } else {
        console.log(response);
        $("#category_tbl").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      console.log("AJAX request failed!");
      console.log("Error:", error);
    },
  });
  // Ajax End!
}


function View_company_permission() {
    // Retrieve values from localStorage
    var company_id = localStorage.getItem("CoID");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getPermissionByCompany.php?coid=${company_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#permission_table").html(response);
        } else {
          console.log(response);
          $("#permission_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }



  function View_company_users() {
    // Retrieve values from localStorage
    var company_id = localStorage.getItem("CoID");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getusersByCompany.php?coid=${company_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#users_table").html(response);
        } else {
          console.log(response);
          $("#users_table").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }



  function SelectEditUsers(user_id, first_name, last_name, username, email, phone, user_category,user_shift) {
    console.log(user_id);
    console.log(first_name);
    console.log(last_name);
    console.log(phone);
    console.log(email);
    console.log(username);
    console.log(user_shift);
    

    $("#first_name").val(first_name);
    $("#last_name").val(last_name);
    $("#phone").val(phone);
    $("#email").val(email);
    $("#username").val(username);
    $("#user_category").val(user_category);
    $("#user_shift").val(user_shift);
    

   localStorage.setItem("select_user_id", user_id);
}


     


// function SelectDeleteUser(e, names) {
//   console.log(e);
//   $("#delnames").html(names);
//   localStorage.setItem("cust_id", e);
//   }
  



function View_company_category_forselect() {
    // Retrieve values from localStorage
    var company_id = localStorage.getItem("CoID");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getcategoriesbycoidoption.php?company=${company_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#categories").html(response);
          $("#user_category").html(response);
          $("#cat_id").html(response);
        } else {
          console.log(response);
          $("#categories").html("Not Any result");
          $("#user_category").html("Not Any result");
          $("#cat_id").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }


  function View_shift() {
    // Retrieve values from localStorage
    var company = localStorage.getItem("CoID");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getusershift.php?company=${company}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#user_shift").html(response);
        
        } else {
          console.log(response);
          $("#user_shift").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }



  function View_salespointRecord() {
    // Retrieve values from localStorage
    var company_ID = parseInt(localStorage.getItem("CoID"));
  
    // Ajax Start!
    $.ajax({
        url: `functions/salespoint/getsalesptbycompany.php?company=${company_ID}`,
        method: "GET", // Change method to GET
        dataType: "json", // Expect JSON response
        success: function (response) {
            if (response) {
                $("#salespoint_table").html(response); // Set the HTML content of salespoint_table element
            } else {
                $("#salespoint_table").html("Not Any result");
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX request failed!");
            console.log("Error:", error);
        },
    });
    // Ajax End!
}





 


  function View_company_pages_forselect() {
    // Retrieve values from localStorage
    var company_id = localStorage.getItem("CoID");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getpagebycompanyId.php?company=${company_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          console.log(response);
          $("#pages").html(response);
          $("#page_id").html(response);
        } else {
          console.log(response);
          $("#pages").html("Not Any result");
          $("#page_id").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }

  function SelectEdisalespoint(id){
    console.log(id);
    localStorage.setItem("salespointid",id);
    localStorage.setItem("SptID",id);
  }
  
  function SelectEditCustomer(id,name,cat_id,page_id){
     
    localStorage.setItem("permid",id);

   
    $("#namepermi").val(name);
    $("#cat_id").val(cat_id);
    $("#page_id").val(page_id);  
  }
  
   function SelectDeleteCustomer(id,name){
      
    localStorage.setItem("permid",id);
    
   
      
  }
  
  function SelectEditCategory(cat_id, category_name,status){
       
    localStorage.setItem("cat_id",cat_id);
    

   
    $("#category_name").val(category_name);
    $("#statuscategory").val(status);
  }
  
  function SelectdeleteCategory(cat_id, category_name){
       console.log("cat_id ",cat_id);
    localStorage.setItem("cat_id",cat_id);
    

  }
