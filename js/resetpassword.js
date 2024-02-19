$(document).ready(function () {
    
UserInfo();
getCompanyId();
              
               

$("#checkReset").click(function() {
    var resetValue = $("#resetTip").val();
    var Phcall= localStorage.getItem("phone"); 
     var emailAddress= localStorage.getItem("Email");
     var username= localStorage.getItem("Username");
    if(resetValue === emailAddress || resetValue === username || resetValue === Phcall){
        window.location.href = "change_password.php";
    }else{
        var toast = new bootstrap.Toast($('#myToast'));
        toast.show();
        console.log("error" );
    } 
 });

});



function UserInfo(){

var c_name = localStorage.getItem("companyName");
var Phcall = localStorage.getItem("phone"); 
var emailAddress= localStorage.getItem("Email");
var username= localStorage.getItem("Username");  
var full_name=    localStorage.getItem("Names");
var TypeUser = localStorage.getItem("UserType");

var Country= localStorage.getItem("country");
var Address= localStorage.getItem("Address");  
var city=    localStorage.getItem("city");

console.log(Country);
console.log(Address);
console.log(city);


$("#username").html(username);
$("#phone").html(Phcall);
$("#email").html(emailAddress);
$("#company").html(c_name);
$("#full_name").html(full_name);
$("#usertype").html(TypeUser);

$("#country").html(Country);
$("#address").html(Address);
$("#city").html(city);
}


function getCompanyId(){
    var id_campany = localStorage.getItem("CoID");
    
      //Ajax Start!
      $.ajax({
        url: `functions/user/userCompany.php?id=${id_campany}`,
        method: "GET",
        
        success: function (response) {
        localStorage.setItem("CompID", response.id);
        localStorage.setItem("Company_name", response.name);
        localStorage.setItem("Address", response.address);
        localStorage.setItem("city", response.city);
        localStorage.setItem("state", response.state);
        localStorage.setItem("zip_code", response.zip_code);
        localStorage.setItem("country", response.country);
        localStorage.setItem("phone", response.phone); 
        localStorage.setItem("Email", response.email);
        localStorage.setItem("website", response.website); 
        
        },
        
      })
}













