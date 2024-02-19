$(document).ready(function () {
  
  setUpdates();
  View_Record();
  View_RecordSalesPoint();
  setSptDelete();
  setSptUpdate();

  var interval = setInterval(function () {
    View_Record();
    View_RecordSalesPoint();
  }, 1000);


  $("#saveNewUser").click(function () {
    console.log("test");
    $("#saveNewUser").html("Please wait.."); 
  });



  //Update Companies
  $("#updatecompany").click(function () {
    $("#updatecompany").html("Please wait..");

    var name = $("#company_name").val();
    var address = $("#company_address").val();
    var city = $("#company_city").val();
    var state = $("#company_state").val();
    var zip_code = $("#company_zip").val();
    var country = $("#company_country").val();
    var phone = $("#company_phone").val();
    var email = $("#company_email").val();
    var website = $("#company_web").val();
    var company_id = parseInt(localStorage.getItem("co_id"));

    //Ajax Start!
    $.ajax({
      url: "functions/company/updatecompany.php",
      method: "POST",

      data: {
        name: name,
        address: address,
        city: city,
        state: state,
        zip_code: zip_code,
        country: country,
        phone: phone,
        email: email,
        website: website,
        company_id: company_id,
      },

      success: function (response) {
        View_Record();
        $("#updatecompany").html("Update");
        $("#Editco-modal").modal("hide");
        $("#diagMsg").html("Data has been updated");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        localStorage.removeItem("co_id");
      },
      error: function (error) {
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#updatecompany").html("Update");
        //console.log(error.responseText);
      },
    });
  });

  //Add Company
  $("#savenewcompany").click(function () {
    $("#savenewcompany").html("Please wait..");

    var name = $("#Addcompany_name").val();
    var address = $("#Addcompany_address").val();
    var city = $("#Addcompany_city").val();
    var state = $("#Addcompany_state").val();
    var zip_code = $("#Addcompany_zip").val();
    var country = $("#Addcompany_country").val();
    var phone = $("#Addcompany_phone").val();
    var email = $("#Addcompany_email").val();
    var website = $("#Addcompany_web").val();

    //Ajax Start!
    $.ajax({
      url: "functions/company/insertcompany.php",
      method: "POST",

      data: {
        name: name,
        address: address,
        city: city,
        state: state,
        zip_code: zip_code,
        country: country,
        phone: phone,
        email: email,
        website: website,
      },

      success: function (response) {
        View_Record();
        $("#savenewcompany").html("Save");
        $("#registerco-modal").modal("hide");
        $("#diagMsg").html("Data has been saved");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        //console.log(response);
      },
      error: function (error) {
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#savenewcompany").html("Save");
        //console.log(error.responseText);
      },
    });
  });

  //Delete Company
  $("#btndeletecompany").click(function () {
    $("#btndeletecompany").html("Please wait..");

    var company_id = parseInt(localStorage.getItem("co_id"));

    //Ajax Start!
    $.ajax({
      url: "functions/company/removecompany.php",
      method: "POST",

      data: {
        company_id: company_id,
      },

      success: function (response) {
        View_Record();
        $("#btndeletecompany").html("Delete");
        $("#delete-modal").modal("hide");
        $("#diagMsg").html("Company removed");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
      },
      error: function (error) {
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#btndeletecompany").html("Delete");
      },
    });
  });

  //Save sales point

  $("#saveSalesPoint").click(function () {
    $("#saveSalesPoint").html("Please wait..");

    var manager_name = $("#manager_name").val();
    var location = $("#location").val();
    var phone_number = $("#phone_number").val();
    var company_ID = $("#company_ID").val();
    var email = $("#email").val();

    //Ajax Start!
    $.ajax({
      url: "functions/salespoint/insertspt.php",
      method: "POST",

      data: {
        manager_name: manager_name,
        location: location,
        phone_number: phone_number,
        company_ID: company_ID,
        email: email,
      },

      success: function (response) {
        View_Record();
        $("#saveSalesPoint").html("Save");
        $("#registerco-modal").modal("hide");
        $("#diagMsg").html("Data has been saved");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        //console.log(response);

        $("#manager_name").val("");
        $("#location").val("");
        $("#phone_number").val("");
        $("#company_ID").val("");
        $("#email").val("");
      },
      error: function (error) {
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#saveSalesPoint").html("Save");
        //console.log(error.responseText);
      },
    });
  });

  //Update SPT
  $("#updateSalesPoint").click(function () {
    $("#updateSalesPoint").html("Please wait..");

    var manager_name = $("#edit_manager_name").val();
    var company_ID = $("#edit_company").val();
    var location = $("#edit_location").val();
    var phone_number = $("#edit_phone_number").val();
    var email = $("#edit_email").val();

    var sales_point_id = parseInt(localStorage.getItem("sptId"));

    //Ajax Start!
    $.ajax({
      url: "functions/salespoint/updatespt.php",
      method: "POST",

      data: {
        location: location,
        manager_name: manager_name,
        phone_number: phone_number,
        email: email,
        company_ID: company_ID,
        sales_point_id: sales_point_id,
      },

      success: function (response) {
        View_Record();
        $("#updateSalesPoint").html("Update");
        $("#Editco-modal").modal("hide");
        $("#diagMsg").html("Data has been updated");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        localStorage.removeItem("sptId");
      },
      error: function (error) {
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#updateSalesPoint").html("Update");
      },
    });
  });

  //Delete Spt
  $("#deleteSpt").click(function () {
    $("#deleteSpt").html("Please wait..");

    var sales_point_id = parseInt(localStorage.getItem("sptId"));

    //Ajax Start!
    $.ajax({
      url: "functions/salespoint/removespt.php",
      method: "POST",

      data: {
        sales_point_id: sales_point_id,
      },

      success: function (response) {
        console.log(response)
        View_Record();
        $("#deleteSpt").html("Delete");
        $("#delete-modal").modal("hide");
        $("#diagMsg").html("Salespoint removed");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
      },
      error: function (error) {
        console.log(error)
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#deleteSpt").html("Delete");
      },
    });
  });

  

});

//Display Data function from in Database!
function View_Record() {
  //Ajax Start!
  $.ajax({
    url: "functions/company/getAllCompaniesweb.php",
    method: "POST",
    context: document.body,
    success: function (response) {
      if (response) {
        //console.log(response);
        $("#company_table").html(response);
      } else {
        //console.log(response);
        $("#company_table").html("Not Any result");
      }
    },
    error: function (xhr, status, error) {
      console.log("AJAX request failed!");
      console.log("Error:", error);
    },
  });
  //Ajax End!
}

function setUpdates(
  name,
  address,
  city,
  state,
  zip_code,
  country,
  phone,
  email,
  website,
  id
) {
  $("#company_name").val(name);
  $("#company_address").val(address);
  $("#company_city").val(city);
  $("#company_state").val(state);
  $("#company_zip").val(zip_code);
  $("#company_country").val(country);
  $("#company_phone").val(phone);
  $("#company_email").val(email);
  $("#company_web").val(website);
  localStorage.setItem("co_id", id);
}

function deletecompany(company_id, name) {
  $("#delconame").html(name);
  localStorage.setItem("co_id", company_id);
}

//Display Data function from sales point!
function View_RecordSalesPoint() {
  //Ajax Start!
  $.ajax({
    url: "functions/salespoint/getallsalespoint.php",
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
      console.log("AJAX request failed!");
      console.log("Error:", error);
    },
  });
  //Ajax End!
}

function setSptUpdate(
  sales_point_id,
  manager_name,
  location,
  phone_number,
  company_ID,
  email
) {
  $("#edit_manager_name").val(manager_name);
  $("#edit_company").val(company_ID);
  $("#edit_location").val(location);
  $("#edit_phone_number").val(phone_number);
  $("#edit_email").val(email);

  localStorage.setItem("sptId", sales_point_id);
}

function setSptDelete(id) {
  localStorage.setItem("sptId", id);
}
