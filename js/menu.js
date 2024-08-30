$(document).ready(function () {
  View_company_pages_menu();
  $('.menu_icon_cont').css({"background-color": "transparent"});
  localStorage.setItem("sidebar", "expanded");


  $("#sidebarToggle").on("click", function (e) {
    e.preventDefault();

    if (localStorage.getItem("sidebar") == "collapsed") {
      localStorage.setItem("sidebar", "expanded");
      $(".page_name").css("display", "flex");
      $(".fas").css({"font-size": "12px", "margin-left": "0px", "color": "white"});
      $('.menu_icon_cont').css({"background-color": "transparent"});
    }else{
      localStorage.setItem("sidebar", "collapsed");
      $(".page_name").css("display", "none");
      $(".sidebar").css("width", "100px")
      $(".fas").css({"font-size": "16px","color": "white"});
      $(".menu_icon_cont").css({"background-color": "red"});
    }
  });
});






  function View_company_pages_menu() {
    // Retrieve values from localStorage
    var cat_id = localStorage.getItem("user_category");
  
    // Ajax Start!
  
    $.ajax({
      url: `functions/settings/getmenubycategory.php?cat_id=${cat_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
        if (response) {
          // console.log(response);
          $("#all_menu").html(response);
        } else {
          // console.log(response);
          $("#all_menu").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        // console.log("AJAX request failed!");
        // console.log("Error:", error);
      },
    });
    // Ajax End!
  }
