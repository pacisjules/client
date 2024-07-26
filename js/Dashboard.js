$(document).ready(function () {
 GetDailyTotal(); 
 GetWeeklyTotal();
 GetYearlyTotal();
 GetBenefitData();
 GetSellStock();
 GetBenefitStock();
 GetInventoryHistoryList();
 GetInventoryAlert();
 getsalespoint();
 Gettotalofcashier();


$("#generateProfo").click(function () {
    
  printDebtRecognitionProforma(); 
});

$("#activateShiftButton").click(function () {
  var user_id = localStorage.getItem("UserID");


  $.ajax({
    url: `functions/sales/countactiveshift.php?user_id=${user_id}`,
    method: "GET",
    context: document.body,
    success: function (response) {
            
            if (response.data[0].countshift === "0") {
              window.location.href = "/client/activateshift";
           
          } else {
            $("#activatemodal").modal("show");
           
          }
          
    },
    error: function (xhr, status, error) {
        console.log("Error:", error);
    },
});

});





$("#closingcase").click(function () {
  $("#closingcase").hide();
  $("#no_shift").hide();
  $("#no_shifts").hide();
  var record_id = localStorage.getItem("record_id");
  var total = localStorage.getItem("total");
  var salesnumber = localStorage.getItem("salesnumber");
  var user_id = localStorage.getItem("UserID");
  var spt = localStorage.getItem("SptID");
  console.log(total);
  if(total==0 ){
    $("#add_customer_modal").modal("hide");
    $("#errormodal").modal("show");
  }else{
  
  $("#shift_message").html("Please wait..");

  //   // Start AJAX request
  $.ajax({
    url: "functions/sales/closingshifttask.php",
    method: "POST",
    data: {
      spt: spt,
      record_id: record_id,
      total: total,
      salesnumber: salesnumber,
      user_id: user_id,
      
    },
    success: function (response) {
      console.log(response);
      $("#add_customer_modal").modal("hide");
      $("#successmodal").modal("show");
        setTimeout(function() {
                      location.reload();
                  }, 2000);
    },
    error: function (error) {
      console.log(error);
      $("#errormodal").modal("show");
    },
  });
  }
  // Retrieve values from input fields
  

  

  
});



});

function GetDailyTotal() {
    

        const currentDate = new Date();
        const montly = currentDate.getMonth();
        const date = currentDate.getDate();
        const year = currentDate.getFullYear();
        const formattedDate =
        year +
        "-" +
        (montly + 1).toString().padStart(2, "0") +
        "-" +
        date.toString().padStart(2, "0");
    
    
        const formatDate = (myDate) => {
          const dateParts = myDate.split("-");
          const year = dateParts[0];
          const month = dateParts[1];
          const day = dateParts[2];
      
          const formattedDate = new Date(year, month - 1, day).toLocaleDateString(
            "en-US",
            {
              year: "numeric",
              month: "long",
              day: "numeric",
            }
          );
      
          return formattedDate;
        };
    
    
        $("#dateShow").html(formatDate(formattedDate));
    
        // Retrieve values from localStorage
        var sales_point_id = localStorage.getItem("SptID");
        var TypeUser = localStorage.getItem("UserType");
      
        // Ajax Start!
    
        $.ajax({
          url:`functions/sales/daytotalandcountspt.php?date=${formattedDate}&spt=${sales_point_id}`,
          method: "POST",
          context: document.body,
          success: function (response) {
            if (response) {
              // console.log(response);
              if(TypeUser==='BOSS'|| TypeUser==='Manager'){
              
              $("#getdaily").html(response);
              
            } else{
              $("#getdaily").html(' '); 
              // $("#allshift_report").css('display', 'none');
              $("#cardgetdaily").hide();
              $("#cardgetdaily1").hide();
              $("#cardgetdaily2").hide();
              $("#cardgetdaily3").hide();
              $("#cardgetdaily4").hide();
              $("#cardgetdaily5").hide();
              $("#allshift_report").hide();
            }
            } else {
              //console.log(response);
              $("#getdaily").html("Not Any result");
            }
          },
          error: function (xhr, status, error) {
            // console.log("AJAX request failed!");
            console.log("Error:", error);
          },
        });
        // Ajax End!
    
}


function GetWeeklyTotal() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth() + 1;
  const day = currentDate.getDate();
  const week = getWeekNumber(year, month, day);
  // console.log(week);

  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");
  var TypeUser = localStorage.getItem("UserType");

  // Ajax Start!
  $.ajax({
      url: `functions/sales/daytotalandcountsptweek.php?spt=${sales_point_id}&week=${week}`,
      method: "POST",
      context: document.body,
      success: function (response) {
          if (response) {
              console.log(response);
          if(TypeUser==='BOSS'){
            $("#getWeekly").html(response);
          } else{
            $("#getWeekly").html(' '); 
          }   
              
          } else {
              $("#getWeekly").html("No results available");
          }
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  // Ajax End!
}

// Function to calculate week number
function getWeekNumber(year, month, day) {
  var date = new Date(year, month - 1, day);
  date.setHours(0, 0, 0);
  date.setDate(date.getDate() + 4 - (date.getDay() || 7));
  var yearStart = new Date(date.getFullYear(), 0, 1);
  var weekNo = Math.ceil(((date - yearStart) / 86400000 + 1) / 7);
  return weekNo;
}


function getsalespoint() {
 
  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");

  $.ajax({
    url: `functions/salespoint/getsalesptbyID.php?id=${sales_point_id}`,
    method: "GET", // Change method to GET
    success: function (response) {
        if (response && response.location) {
            // console.log(response.location);
            $("#salespointlocation").html(response.location);
        } else {
            $("#salespointlocation").html("No location available");
        }
    },
    error: function (xhr, status, error) {
        console.log("Error:", error);
    }
});


}




function Gettotalofcashier() {

  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");
  var user_id = localStorage.getItem("UserID");
  

  // Ajax Start!
  $.ajax({
      url: `functions/sales/sumofcashier.php?user_id=${user_id}&spt=${sales_point_id}`,
      method: "GET",
      context: document.body,
      success: function (response) {
          if (response) {
              console.log(response);  
              // 
              const number = response.data[0].total;
              const c_name = response.data[0].user_name;
              $("#cardgetdaily7").hide();
              const formattedNumber = number.toLocaleString('en-US');
              $("#expectedCash").html(`Total: Rwf ` + formattedNumber);
              $("#cashiername").html(response.data[0].user_name);
              // console.log(c_name);
              $("#getcurrentcash").html(`Total: Rwf `+ formattedNumber);

              $("#cashiernamepoint").html(response.data[0].user_name);
              $("#shiftnames").html(response.data[0].shift_names);
              // console.log(response);
              // console.log('testing 2: '+response.data[0].shift_names);

              localStorage.setItem("total", response.data[0].totals);
              localStorage.setItem("record_id", response.data[0].record_id);
              localStorage.setItem("salesnumber", response.data[0].salesnumber);

          } else {
            console.log("No results available");
              $("#expectedCash").html("error");
          }
      },
      error: function (xhr, status, error) {
          $("#my_names").html(localStorage.getItem("Names"));
          $("#cardgetdaily5").hide();
          console.log("Error:", error);
      },
  });
  // Ajax End!
}




function GetYearlyTotal() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();

  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");
  var TypeUser = localStorage.getItem("UserType");

  // Ajax Start!
  $.ajax({
      url: `functions/sales/daytotalandcountsptYearly.php?spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
          if (response) {
              // console.log(response);
              if (TypeUser==='BOSS') {
                $("#getYearly").html(response);
              }else{
                $("#getYearly").html(' ');
              }
              
          } else {
              $("#getYearly").html("No results available");
          }
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  // Ajax End!
}

function GetBenefitData() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth() + 1;
  const date = currentDate.getDate();
  const formattedDate = `${year}-${month.toString().padStart(2, "0")}-${date.toString().padStart(2, "0")}`;

  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");
  

  // Ajax Start!
  $.ajax({
      url: `functions/sales/mostbenefitproductday.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "GET",
      context: document.body,
      success: function (response) {
          if (response) {
              // console.log(response);
              $("#getMostBenefit").html(response);
          } else {
              $("#getMostBenefit").html("No results available");
          }
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  // Ajax End!
}

function GetSellStock() {
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");
  var TypeUser = localStorage.getItem("UserType");

  // Ajax Start!
  $.ajax({
      url: `functions/inventory/getSellValues.php?company=${company_ID}&spt=${sales_point_id}`,
      method: "GET",
      context: document.body,
      success: function (response) {
          if(TypeUser==="BOSS"){
          $("#getSellStock").text(response);
          }else{
           $("#getSellStock").text(" ");   
          }
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  // Ajax End!
}


function GetBenefitStock() {
  // Retrieve values from localStorage
  var company_ID = localStorage.getItem("CoID");
  var sales_point_id = localStorage.getItem("SptID");
  var TypeUser = localStorage.getItem("UserType");
 

  // Ajax Start!
  $.ajax({
      url: `functions/inventory/getBenefitValues.php?company=${company_ID}&spt=${sales_point_id}`,
      method: "GET",
      context: document.body,
      success: function (response) {
        if(TypeUser==="BOSS"){
          $("#getBenefitStock").text(response);
        }else{
          $("#getBenefitStock").text(" ");
        }
          
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  // Ajax End!
}


function GetInventoryHistoryList() {
  
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth() + 1;
    const date = currentDate.getDate();
    const formattedDate = `${year}-${month.toString().padStart(2, "0")}-${date.toString().padStart(2, "0")}`;
  
    // Retrieve values from localStorage
    var sales_point_id = localStorage.getItem("SptID");
  
    // Ajax Start!
    $.ajax({
      url: `functions/systemhistory.php?date=${formattedDate}&spt=${sales_point_id}`,
      method: "POST",
      context: document.body,
      success: function (response) {
          if (response) {
              console.log(response);
              $("#inventoryHistoryList").html(response);
          } else {
              $("#inventoryHistoryList").html("No results available");
          }
      },
      error: function (xhr, status, error) {
          console.log("Error:", error);
      },
  });
  
}



function GetInventoryAlert() {
 
  // Retrieve values from localStorage
  var sales_point_id = localStorage.getItem("SptID");

  // Ajax Start!
  $.ajax({
    url: `functions/inventory/getAlertproduct.php?spt=${sales_point_id}`,
    method: "POST",
    context: document.body,
    success: function (response) {
        if (response) {
            // console.log(response);
            $("#inventoryAlert").html(response);
        } else {
            $("#inventoryAlert").html("No results available");
        }
    },
    error: function (xhr, status, error) {
        console.log("Error:", error);
    },
});

}



function printDebtRecognitionProforma() {
  // Calculate the total amount with interest
  const currentDate = new Date();

const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');

const formattedDate = `${year}-${month}-${day}`;

const c_name = localStorage.getItem("companyName");
const Phone =  localStorage.getItem("phone");


  // Create the proforma
  const proforma = `
    <div class="proforma">
      <h2>BORDEREAU D'EXPEDITION  No:............</h2></br>
      <p>Expediteur: .................</p>
      <p>Destinateur: ........................</p></br></br>

     <table border=2>
     <tr>
     <td>Quantite</td>
     <td>Designation</td>
     <td>Prix Unitaire</td>
     <td>Prix Total</td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
     <td><input type="text"  /></td>
     <td><input type="text"  /></td>
     <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
      <td><input type="text"  /></td>
     </tr>
     <tr>
     
     <td>TOTAL</td>
     <td><input type="text"  /></td>
     </tr>
     </table></br></br>
      
      
      
      
      <div class="detail">
      <div class="det1">
      <h4>Pour Expedition: </h4>
      <p>Camoin: ...................................</p>
      <p>Chauffeur:....................................</p>
      
      </div>
      <div class="det2">
      <h4>Recu les marchandises en bon etat:</h4>
      <p>Nom: ...................................</p>
      <p>Signature:....................................</p>
      
      </div>
      
      </div>
    </div>
  `;

  // Create a new window for printing
  const printWindow = window.open('', '_blank');
  printWindow.document.write(`
    <html>
      <head>
        <title>Debt Recognition Proforma</title>
        <style>
          .proforma {
            font-family: Arial, sans-serif;
            margin: 20px;
          }
          .camp{
            border:2px solid black;
            text-align: center;
            align-items:center;
            justify-content:center;
            margin-left:15px;
          }
          .detail{
            flex:1;
          }
          h2 {
            text-align: center;
          }
          p {
            margin: 10px 0;
          }
          hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0;
          }
        </style>
      </head>
      <body>
      <div class="camp">
      <h1>${c_name}</h1>
      <h3>TIN/TVA:....................................  Tel:${Phone}</h3>
      <p>${formattedDate}</p>
      </div>
        ${proforma}
        <script>
          // Automatically print the proforma document
          window.onload = function() {
            window.print();
            setTimeout(function() { window.close(); }, 100);
          };
        </script>
      </body>
    </html>
  `);

  // Close the document after printing
  printWindow.document.close();
}



