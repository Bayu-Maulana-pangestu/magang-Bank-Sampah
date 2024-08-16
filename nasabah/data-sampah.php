<?php
session_start();
if (!isset($_SESSION["id_user"])){
    header("Location:../user/login_user.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Data Sampah</title>
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
        include "../layout/left-sidebar-nasabah.php";
        ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    </div>

                    <div class="container">
                        <h1 class="">Data Sampah</h1>

                        <?php

                        include "../koneksi.php";

                        //Cek apakah ada kiriman form dari method post
                        if (isset($_GET['id_sampah'])) {
                            $id_sampah = htmlspecialchars($_GET["id_sampah"]);

                            $sql = "delete from sampah where id_sampah='$id_sampah' ";
                            $hasil = mysqli_query($koneksi, $sql);

                            //Kondisi apakah berhasil atau tidak
                            if ($hasil) {
                                header("Location:data-sampah.php");
                            } else {
                                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
                            }
                        }
                        ?>
                        <!-- Data Sampah -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Sampah</th>
                                    <th>Harga (kg)</th>
                                </tr>
                            </thead>
                            <?php
                            include "../koneksi.php";
                            $sql = "SELECT * FROM sampah order by id_sampah desc";
                            $hasil = mysqli_query($koneksi, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                                $no++;
                            ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $data["jenis_sampah"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($data["harga"], 0, ',', '.');    ?></td>
                                    </tr>
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>



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