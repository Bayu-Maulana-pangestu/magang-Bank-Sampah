<?php
session_start();
if (!isset($_SESSION["id_user"])){
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

                    <div class="container">
                        <h1 class="">Edit Data Sampah</h1>

                        <?php
                        include "../koneksi.php";

                        if (isset($_GET['id_sampah'])) {
                            $id_sampah = htmlspecialchars($_GET['id_sampah']);

                            $sql = "SELECT * FROM sampah WHERE id_sampah='$id_sampah'";
                            $hasil = mysqli_query($koneksi, $sql);
                            $data = mysqli_fetch_assoc($hasil);
                        }

                        if (isset($_POST['submit'])) {
                            $id_sampah = htmlspecialchars($_POST['id_sampah']);
                            $jenis_sampah = htmlspecialchars($_POST['jenis_sampah']);
                            $harga = htmlspecialchars($_POST['harga']);

                            $sql = "UPDATE sampah SET jenis_sampah='$jenis_sampah', harga='$harga' WHERE id_sampah='$id_sampah'";
                            $hasil = mysqli_query($koneksi, $sql);

                            if ($hasil) {
                                echo "<script>alert('Data berhasil diedit');window.location='data-sampah.php';</script>";
                            } else {
                                echo "<div class='alert alert-danger'> Data gagal diupdate.</div>";
                            }
                        }
                        ?>

                        <form action="" method="post">
                            <input type="hidden" name="id_sampah" value="<?php echo $data['id_sampah']; ?>">
                            <div class="mb-3">
                                <label for="jenis_sampah" class="form-label">Jenis Sampah</label>
                                <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" value="<?php echo $data['jenis_sampah']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga/kg</label>
                                <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $data['harga']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Update</button> <a href="data-sampah.php" class="btn btn-secondary">Kembali</a>
                        </form>
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
