$(document).ready(function () {
$('body').css('overflow', 'visible');


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
});




