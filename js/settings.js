$(document).ready(function () {
  View_company_category();
  View_company_category_forselect();

  View_company_pages_forselect();
  View_company_permission();
  View_company_users();


  //Update User
  $("#EditUser").click(function () {
    $("#EditUser").html("Please wait..");

    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var phone = $("#phone").val();
    var email = $("#email").val();
    var username = $("#username").val();
    var user_category = $("#user_category").val();

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



  function SelectEditUsers(user_id, first_name, last_name, username, email, phone, user_category) {
    console.log(user_id);
    console.log(first_name);
    console.log(last_name);
    console.log(phone);
    console.log(email);
    console.log(username);
    console.log(user_category);

    $("#first_name").val(first_name);
    $("#last_name").val(last_name);
    $("#phone").val(phone);
    $("#email").val(email);
    $("#username").val(username);
    $("#user_category").val(user_category);

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
        } else {
          console.log(response);
          $("#categories").html("Not Any result");
          $("#user_category").html("Not Any result");
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
        } else {
          console.log(response);
          $("#pages").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }
