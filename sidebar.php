<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="js/menu.js"></script>
</head>

<style>
    #all_menu{
        display:flex; 
        flex-direction:column;
        justify-content:flex-start;
    }
</style>
<body>
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background: rgb(0,26,53);">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" style="background: orange;width: 98%; border-radius: 15px 0px 0px 15px;" href="/"> 
                <img src="assets/img/icon.jpg" width="69" height="61" style="width: 50px;height: 50px; border-radius: 5px">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <div style="display: flex;flex-direction: column; justify-content: flex-start; align-items: flex-start">
                <div class="sidebar-brand-text mx-3"><span>SELLEASEP</span></div>
                <div class="sidebar-brand-text mx-3" style="font-size: 10px; text-transform: none; font-weight: 500"><span>Business Solution</span></div>
                </div>
            </a>
            <hr class="sidebar-divider my-0">
                <ul  class="navbar-nav text-light" id="all_menu">
            </ul>

            <div class="text-center d-none d-md-inline">
                <button style="margin-left: -30px" class="btn rounded-circle border-0" id="sidebarToggle" type="button" ></button>
            </div>
        </div>
    </nav>
</body>

</html>