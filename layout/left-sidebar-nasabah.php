<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nasabah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Left Sidebar Start -->
    <div class="app-sidebar-menu" style="background-color: green;">
        <div class="h-100" data-simplebar>

            <!--- Sidemenu -->
            <div id="sidebar-menu" >

                <div class="logo-box">
                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="24">
                        </span>
                    </a>
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul id="side-menu">

                    <li class="menu-title" style="color: white;">Menu</li>

                    <li>
                        <a href="../nasabah/nasabah.php" style="color: white;">
                            <i data-feather="home"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="../nasabah/profile-nasabah.php" style="color: white;">
                            <i data-feather="user"></i>
                            <span> Data User </span>
                        </a>
                    </li>

                    <li>
                        <a href="../nasabah/data-sampah.php" style="color: white;">
                            <i data-feather="trash"></i>
                            <span> Data Sampah </span>
                        </a>
                    </li>

                    <li>
                        <a href="../nasabah/penarikan.php" style="color: white;">
                            <i data-feather="dollar-sign"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span>Penarikan</span>
                        </a>
                    </li>

                    <li>
                        <a href="../user/logout.php" style="color: white;">
                            <i data-feather="log-out"></i>
                            <span> Logout </span>
                        </a>
                    </li>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vendor -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

    <!-- Apexcharts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- for basic area chart -->
    <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

    <!-- Widgets Init Js -->
    <script src="../assets/js/pages/dashboard.init.js"></script>

    <!-- App js-->
    <script src="../assets/js/app.js"></script>
</body>

</html>