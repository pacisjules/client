$(document).ready(function () {
$('body').css('overflow', 'visible');
populateProductCategory();


//Show Tablet
$("#ShowTablet").click(function(){
    
    $('#tablet').show();
    $('body').css("overflow", "hidden");
  });


//Hide Tablet
  $("#Exit").click(function(){
    $('#tablet').hide();
    $('body').css('overflow', 'visible');
  });


  function populateProductCategory() {
    var company_ID = parseInt(localStorage.getItem("CoID"));
  
    $.ajax({
        url: `functions/product/getallCompanyCategorieslisttablet.php`,
        method: "GET", // Change to GET method
        data: { company: company_ID },
        success: function (response) {
            console.log(response);
            $("#categorylist").html(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
  }


  
});




