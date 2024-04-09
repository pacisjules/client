$(document).ready(function () {
    
   
  
    $("#user").click(function () { 
      $("#user").css({
        "color": "grey",
        "font-size": "16px",
        "border":"1px solid #c2c2c2"
      });
    });


    $("#pwd").click(function () { 
      $("#pwd").css({
        "color": "grey",
        "font-size": "16px",
        "border":"1px solid #c2c2c2"
      });
    });



  //Login Btn
  $("#lgnbtn").click(function () {
    var username = $("#user").val();
    var password = $("#pwd").val();

    if (username == "") {
      //Validation
      $("#user").css({
        color: "red",
        "font-size": "16px",
        "border":"1px solid red"
      });
    } else if (password == "") {
      $("#pwd").css({
        color: "red",
        "font-size": "16px",
        "border":"1px solid red"
      });
    } else {
      $('#lgnbtn').html('Wait Longing...');

            //Ajax Start!
            $.ajax({
                url: 'functions/user/userlogin.php',
                method: 'post',

                data: { UName: username, UPass: password },

                success: function (response) {
                localStorage.setItem("CoID", response.company_ID);
                localStorage.setItem("SptID", response.salepoint_id);
                localStorage.setItem("UserID", response.id);
                localStorage.setItem("UserType", response.userType);
                localStorage.setItem("companyName", response.company_name);
                localStorage.setItem("phone", response.phone); 
                localStorage.setItem("Email", response.email);
                localStorage.setItem("Username", response.username);  
                 localStorage.setItem("Names", response.names);
                 localStorage.setItem("company_logo", response.company_logo);
                 localStorage.setItem("company_color", response.company_color);
                 localStorage.setItem("spt_name", response.spt_name);
                 localStorage.setItem("user_category", response.user_category);
                 localStorage.setItem("zone", response.zone);
                window.location.href = "/client";
                $('#lgnbtn').html('Login');

                
                //console.log(response.salepoint_id);
                //console.log(response.company_ID);
                },
                error:function(error){
                  var toast = new bootstrap.Toast($('#myToast'));
                  toast.show();
                  $('#lgnbtn').html('Login');
                  console.log(error.responseText);
                }
              })
    }
  });
});









