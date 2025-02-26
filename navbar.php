<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <script src="js/Mytablet.js"></script>

    <style>

.show_tblt {
    width: 120px;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
}
        
.show_tblt #ShowTablet {
    border: none;
    width: 120px;
    padding: 5px;
    background-color: #000030;
    border-radius: 5px;
    color: white;
    font-weight: 700;
    font-size: 12pt;
    transition: ease-in-out 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.show_tblt #ShowTablet img {
    width: 25px;
}

.show_tblt #ShowTablet:hover {
    background-color: white;
    color: #000030;
    border: 1px solid #ff8800;
    -webkit-box-shadow: -2px 5px 36px -16px #ff8800;
    -moz-box-shadow: -2px 5px 36px -16px rgb(255, 136, 0);
    box-shadow: -2px 5px 36px -16px rgb(255, 136, 0);
}
    </style>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var userType = localStorage.getItem("UserType");
        if (userType !== "BOSS") {
            var settingsLink = document.getElementById("settingsLink");
            if (settingsLink) {
                settingsLink.style.display = "none";
            }
            var salespointLink = document.getElementById("salespointLink");
            if (salespointLink) {
                salespointLink.style.display = "none";
            }
        }
    });
</script>
    
    
    
    
</head>
<body>


<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ..."><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            
                        </form>
                                                    <!-- Add jQuery -->
<script src="jquery-3.6.3.min.js" type="text/javascript"></script>

<!-- Google Translate Widget Script -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style>


/* .skiptranslate {
    display: none;
    height: 0;
    position: unset;
    overflow: hidden;
  } */


.goog-te-banner-frame .skiptranslate {
        display: none;
    }

    body {
        top: 0px;
    }

.goog-te-gadget-simple{
    background-color: transparent;
    border: none;
    color: white;
    font-family: 'Poppins', sans-serif ;
    border-radius: 35px;
    border:2px solid white;
    padding: 5px 10px 5px 10px;
    height: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.goog-te-gadget-simple span{
    color: white;
}

</style>

<!-- Div for Google Translate -->
<div id="google_translate_element"></div>

<!-- Script to Initialize Google Translate Widget -->
<script type="text/javascript">
    $('iframe.goog-te-banner-frame').hide();
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',  // Default language of the page
            includedLanguages: 'en,fr',  // Define supported languages
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }

    function changeLanguage(lang) {
        // Use jQuery to find and select the language from Google Translate
        setTimeout(function() {
            var select = $('select.goog-te-combo');
            if (select.length) {
                select.val(lang);
                select.trigger('change');  // Trigger the change event to switch language
            }
        }, 500);  // Delay to allow widget to load

        //set .skiptranslate display to none
        setTimeout(function() {
            $('.skiptranslate').css('display', 'none');
        }, 1000);

        // Hide the Google Translate top bar
        setTimeout(function() {
            $('iframe.goog-te-banner-frame').hide();  // Hide the iframe that contains the bar
            $('body').removeAttr('style');  // Remove any top margin added to the body
        }, 1000);  // Adjust timeout if needed
    }
</script>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class=" py-0" type="button" style="background-color:#040536;"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <div class="show_tblt">
                            <a href="sales-panel" style="text-decoration: none"> <button type="button" id="ShowTablet"><img src="styles/icons/tap.png" alt="" srcset=""> <span>Tablet</span></button>  </a> 
                            </div>
                            
                            
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">7</span><i class="fas fa-envelope fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar4.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Hi there! I am wondering if you can help me with a problem I've been having.</span></div>
                                                <p class="small text-gray-500 mb-0">Emily Fowler - 58m</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar2.jpeg">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>I have the photos that you ordered last month!</span></div>
                                                <p class="small text-gray-500 mb-0">Jae Chun - 1d</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar3.jpeg">
                                                <div class="bg-warning status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Last month's report looks great, I am very happy with the progress so far, keep up the good work!</span></div>
                                                <p class="small text-gray-500 mb-0">Morgan Alvarez - 2d</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar5.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</span></div>
                                                <p class="small text-gray-500 mb-0">Chicken the Dog · 2w</p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                    </div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small" style="font-weight: bold; text-transform: uppercase;"><?php echo $names;?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in" id="dropdownpages">
                                        <a class="dropdown-item" href="profile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-800"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" href="loginhistory"><i class="fas fa-sign-in-alt fa-sm fa-fw me-2 text-gray-800"></i>&nbsp;Login History</a>
                                        <a class="dropdown-item" href="shift"><i class="fas fa-exchange-alt fa-sm fa-fw me-2 text-gray-800"></i>&nbsp;Shift Manager</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="settings" id="settingsLink"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-800"></i>&nbsp;Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="salespoint" id="salespointLink"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-800"></i>&nbsp;Sales Point Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout" onclick="logout()"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-800" style="color:red;"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>