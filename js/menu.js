$(document).ready(function () {
  View_company_pages_menu();
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
          console.log(response);
          $("#all_menu").html(response);
        } else {
          console.log(response);
          $("#all_menu").html("Not Any result");
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed!");
        console.log("Error:", error);
      },
    });
    // Ajax End!
  }
