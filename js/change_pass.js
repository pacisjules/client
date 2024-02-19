$(document).ready(function () {


    $("#editbtn").click(function () {
      var user_Id = localStorage.getItem("UserID");
      var newPassword = $("#newpass").val();
      var confirmPassword = $("#confpass").val();
      if (newPassword !== confirmPassword || newPassword === "" || confirmPassword === "") {
        var toast = new bootstrap.Toast($('#myToastm'));
        toast.show();
      }else{
        $.ajax({
          url: "functions/user/changepassword.php",
          method: "POST",
    
          data: {
            user_id: user_Id,
            password: newPassword
            
          },
    
          success: function (response) {
            console.log("Done "+response);
            window.location.href = "login.php";
          },
          error: function (error) {
            var toast = new bootstrap.Toast($('#myToast'));
            toast.show();
            console.log("error "+error);
          },
        });
      }

    

    });
});