<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
    <meta name="description" content="For a large retail chain or multi-location business with advanced features and extensive customization needs, the cost of a customized POS software solution could range">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="icon.jpg" type="image/x-icon">
    <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <script src="js/sales.js"></script>
    
</head>
<body>
<div class="d-flex flex-row justify-content-between align-items-center" style="margin-bottom:20px;">
                       <a href="sales.php" ><button class="btn btn-primary"  type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zM1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1z"/>
  <path d="M0 4h16v1H0z"/>
  <path d="M0 8h16v1H0z"/>
  <path d="M0 12h16v1H0z"/>
</svg>
&nbsp;Today</button></a>
                        <button class="btn btn-primary" id="yesterdaysales" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path d="M8 1 0 8h2v6h12V8h2L8 1zm1 7h5v1H9v4H7V9H3V8h6V7z"/>
</svg>
&nbsp;Yesterday</button>

<button class="btn btn-primary" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" id="weeklysales" ><i class="fas fa-calendar-week"></i>&nbsp;Weekly</button>


<button class="btn btn-primary" id="pickDateButton" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
  <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm15-1V3h-2V1h-2v2H6V1H4v2H2V0H1a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V0h-1zM7 15v-2h2v2H7zm5-10H4V3h8v2z"/>
  <path d="M11.354 6.354a.5.5 0 0 0-.708 0l-1 1a.5.5 0 0 0 0 .708L9 9.707l1.354 1.353a.5.5 0 0 0 .708-.708L9.707 10l1.353-1.354a.5.5 0 0 0 0-.708z"/>
</svg>
&nbsp;Pick Date</button>
                       
<button class="btn btn-primary" id="Pickdaterangebtn" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-range" viewBox="0 0 16 16">
  <path d="M1 3.5a.5.5 0 0 1 1 0V13a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V3.5a.5.5 0 0 1 1 0V13a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3.5zM14 3a2 2 0 0 1 2 2V13a.5.5 0 0 1-1 0V5a1 1 0 0 0-1-1H5a.5.5 0 0 1 0-1H13z"/>
  <path d="M7.5 11.5a.5.5 0 0 1 1 0V13a.5.5 0 0 1-1 0v-1.5zM9.5 11.5a.5.5 0 0 1 1 0V13a.5.5 0 0 1-1 0v-1.5z"/>
  <path d="M3 1h1V0H3a2 2 0 0 0-2 2v1h1V2a1 1 0 0 1 1-1z"/>
  <path d="M3 5h1V4H3a2 2 0 0 0-2 2v1h1V6a1 1 0 0 1 1-1z"/>
  <path d="M3 9h1V8H3a2 2 0 0 0-2 2v1h1v-1a1 1 0 0 1 1-1z"/>
  <path d="M12 1h1V0h-1a2 2 0 0 0-2 2v1h1V2a1 1 0 0 1 1-1z"/>
  <path d="M12 5h1V4h-1a2 2 0 0 0-2 2v1h1V6a1 1 0 0 1 1-1z"/>
  <path d="M12 9h1V8h-1a2 2 0 0 0-2 2v1h1v-1a1 1 0 0 1 1-1z"/>
</svg>
&nbsp;From To</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectMonthModal" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-month" viewBox="0 0 16 16">
  <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5V13a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1.5zm1.5-.5a.5.5 0 0 0-.5.5V13a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V1a.5.5 0 0 0-.5-.5h-13zM8 12a1 1 0 0 0 0-2 1 1 0 0 0 0 2zm1-3a1 1 0 0 0-2 0v2a1 1 0 1 0 2 0v-2zm-2-6h4V2H7v1z"/>
</svg>
&nbsp;Monthly</button>        
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectYearModal" type="button" style="font-size: 19px;font-weight: bold; background: rgb(0,26,53); color:white;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-check" viewBox="0 0 16 16">
  <path d="M.5 0a.5.5 0 0 0 0 1H1v1a1 1 0 0 0 2 0V1h8v1a1 1 0 0 0 2 0V1h1a.5.5 0 0 0 0-1h-1V0a2 2 0 0 0-2 2v1H3V2a2 2 0 0 0-2-2V0H.5zM1 6a1 1 0 0 1 1-1h12a1 1 0 0 1 0 2H2a1 1 0 0 1-1-1zM0 9a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1zM1 12a1 1 0 0 0 0 2h12a1 1 0 0 0 0-2H1z"/>
  <path d="M13.854 9.854a.5.5 0 0 0-.708 0L8 14.293 3.854 10.146a.5.5 0 0 0-.708.708l4 4a.5.5 0 0 0 .708 0l6-6z"/>
</svg>
&nbsp;Yearly</button>
                    </div>
                    
                    
     <input type="text" id="datepicker" style="display: none;">  
     
     <input type="text" id="daterange" style="display: none;">
            
                           
                           
                           
     <div class="modal fade" id="devModal" tabindex="-1" aria-labelledby="devModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devModalModalLabel" style="color:#130770;">Selleasep Notice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="color:#2d52a8;">This Feature is still under development , Thank you for interest!!</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>
                    
                    
                    <!--monthly modal-->
                    
                    
                    <div class="modal fade" id="selectMonthModal" tabindex="-1" aria-labelledby="selectMonthModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectMonthModalLabel">Select Month</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="selectMonthForm">
                    <div class="mb-3">
                        <label for="monthSelect" class="form-label">Select a Month:</label>
                        <select class="form-select" id="monthSelect" required>
                            
                        </select>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="retrieveMonthlyData">OK</button>
            </div>
        </div>
    </div>
</div>

<!--yearly modal-->

<div class="modal fade" id="selectYearModal" tabindex="-1" aria-labelledby="selectYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectYearModalLabel">Select Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="selectMonthForm">
                    <div class="mb-3">
                        <label for="yearSelect" class="form-label">Select a Year:</label>
                        <select class="form-select" id="yearSelect" required>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        </select>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="retrieveYearlyData">OK</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>