$(document).ready(function () {

    RemoveUserInfo();

    View_UsersRecord(); 
    $("#saveNewUser").click(function () {

        var username = $("#username").val();
        var email = $("#email").val();
        var company_ID = $("#company_ID").val();
        var salepoint_id = $("#salepoint_id").val();
        var f_name = $("#f_name").val();
        var l_name = $("#l_name").val();
        var salary = $("#salary").val();
        var hired_date = $("#hired_date").val();
        var phone = $("#phone").val();
        var userType = $("#userType").val();

        // Ajax Start!
        $.ajax({
            url: "functions/user/insertuserandemployee.php",
            method: "POST",
            data: {
                username: username,
                email: email,
                password: 12345,
                company_name: "Server",
                company_ID: company_ID,
                salepoint_id: salepoint_id,
                f_name: f_name,
                l_name: l_name,
                salary: salary,
                hired_date: hired_date,
                phone: phone,
                userType: userType
            },
            success: function (response) {
              View_UsersRecord();
                console.log(response);
                $("#saveNewUser").html("Save");
                $("#registerco-modal").modal("hide");
                $("#diagMsg").html("Data has been saved");
                var toast = new bootstrap.Toast($("#myToast"));
                toast.show();
                $("#username").val("");
                $("#email").val("");
                $("#company_name").val("");
                $("#company_ID").val("");
                $("#salepoint_id").val("");
                $("#f_name").val("");
                $("#l_name").val("");
                $("#salary").val("");
                $("#hired_date").val("");
            },
            error: function (error) {
                console.log(error);
                var toast = new bootstrap.Toast($("#myToast"));
                toast.show();
                $("#saveNewUser").html("Save");
            },
        });

        $("#saveNewUser").html("Please wait..");
    });




    //Delete User
  $("#removeUser").click(function () {

    $("#removeUser").html("Please wait..");
    var user_id = parseInt(localStorage.getItem("userId"));

    //Ajax Start!
    $.ajax({
      url: "functions/user/removeUser.php",
      method: "POST",

      data: {
        user_id: user_id,
      },

      success: function (response) {
        console.log(response)
        View_UsersRecord();
        $("#removeUser").html("Delete");
        $("#delete-modal").modal("hide");
        $("#diagMsg").html("User removed");
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
      },
      error: function (error) {
        console.log(error)
        var toast = new bootstrap.Toast($("#myToast"));
        toast.show();
        $("#removeUser").html("Delete");
      },
    });
  });


});



function View_UsersRecord() {
    //Ajax Start!
    $.ajax({
      url: "functions/user/getallusers.php",
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


 function RemoveUserInfo(e) { 
    console.log("Delete test: "+e);
    localStorage.setItem("userId", e);
};
