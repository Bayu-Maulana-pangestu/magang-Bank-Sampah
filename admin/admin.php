<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "masyarakat") {
    header("Location:../error/forbidden.php"); // Redirect ke halaman error atau halaman lain yang sesuai
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Admin</title>
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

<!-- body start -->

<body data-menu-color="dark" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">

        <?php
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-admin.php";
        ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    </div>

                    <div class="row justify-content-center">
                        <!-- start Pembelian -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Setoran Sampah</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="justify-content-center">
                                        <?php
                                        include "../koneksi.php";

                                        // Query untuk menghitung jumlah transaksi
                                        $sql = "SELECT COUNT(*) AS totalTransaksi FROM transaksi";
                                        $result = mysqli_query($koneksi, $sql);

                                        // Mendapatkan hasil query
                                        $row = mysqli_fetch_assoc($result);
                                        $totalTransaksi = $row['totalTransaksi'];
                                        ?>
                                        <h3 class="m-0 mb-3 fs-22"><?php echo number_format($totalTransaksi); ?></h3>
                                        <div id="pembelian_chart" class="apex-charts"></div>
                                    </div>

                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                        </div> <!-- end Pembelian -->

                        <!-- start Nasabah -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Nasabah</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="justify-content-center">
                                        <?php
                                        $sql = "SELECT COUNT(*) as total_nasabah FROM nasabah";
                                        $result = mysqli_query($koneksi, $sql);
                                        $data = mysqli_fetch_assoc($result);
                                        $total_nasabah = $data['total_nasabah'];
                                        ?>
                                        <h3 class="m-0 mb-3 fs-22"><?php echo number_format($total_nasabah); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end Nasabah -->

                        <!-- start Jumlah Penarikan -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Penarikan</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="justify-content-center">
                                        <?php
                                        $sql_penarikan = "SELECT SUM(jumlah) as total_penarikan FROM penarikan WHERE status = 'Disetujui'";
                                        $result_penarikan = mysqli_query($koneksi, $sql_penarikan);
                                        $data_penarikan = mysqli_fetch_assoc($result_penarikan);
                                        $total_penarikan = $data_penarikan['total_penarikan'];
                                        ?>
                                        <h3 class="m-0 mb-3 fs-22"><?php echo 'Rp ' . number_format($total_penarikan, 0, ',', '.'); ?></h3>
                                        <div id="jumlah_pembelian_chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end Jumlah Penarikan -->

                        <!-- start Jumlah Penjualan -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Jumlah Pembelian</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="justify-content-center">
                                        <?php
                                        include "../koneksi.php";

                                        // Query untuk mengambil total harga dari transaksi
                                        $sql = "SELECT SUM(total_harga) AS totalHarga FROM transaksi";
                                        $result = mysqli_query($koneksi, $sql);

                                        // Mendapatkan hasil query
                                        $row = mysqli_fetch_assoc($result);
                                        $totalHarga = $row['totalHarga'];
                                        ?>
                                        <h3 class="m-0 mb-3 fs-22"><?php echo 'Rp ' . number_format($totalHarga, 0, ',', '.'); ?></h3>
                                        <div id="jumlah_penjualan_chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end Jumlah Penjualan -->
                    </div>

                    <!-- end revenue -->



                </div>
                <!-- container-fluid -->

            </div> <!-- content -->
        </div>
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

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