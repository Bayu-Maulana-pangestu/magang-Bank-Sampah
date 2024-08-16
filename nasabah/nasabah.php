<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    header("Location:../error/forbidden.php");
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Data Transaksi</title>
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

<body data-menu-color="dark" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">

        <?php
        // Include top bar and left sidebar
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-nasabah.php";

        // Include database connection
        include "../koneksi.php";

        $whereClause = "1";
        if (isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai']) && isset($_GET['tanggal_akhir']) && !empty($_GET['tanggal_akhir'])) {
            $tanggal_mulai = $_GET['tanggal_mulai'];
            $tanggal_akhir = $_GET['tanggal_akhir'];
            $whereClause .= " AND transaksi.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
        }

        // Default SQL query
        $sql = "SELECT transaksi.*, users.username, sampah.jenis_sampah, sampah.harga
                FROM transaksi 
                JOIN users ON transaksi.id_user = users.id_user 
                JOIN sampah ON transaksi.id_sampah = sampah.id_sampah 
                WHERE transaksi.id_user = '{$_SESSION["id_user"]}' AND $whereClause";

        // Execute the query
        $hasil = mysqli_query($koneksi, $sql);
        ?>

        <!-- Start Page Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="container">
                        <h1 class="">Data Transaksi</h1>

                        <!-- Form for filtering by date -->
                        <form method="GET" action="nasabah.php" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : ''; ?>">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Data table -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Sampah</th>
                                    <th>Harga (kg)</th>
                                    <th>Jumlah (kg)</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $totalHarga = 0;
                                while ($data = mysqli_fetch_array($hasil)) {
                                    $no++;
                                    $totalHarga += $data["total_harga"];
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $data["jenis_sampah"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($data["harga"], 0, ',', '.'); ?></td>
                                        <td><?php echo $data["jumlah_beli"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($data["total_harga"], 0, ',', '.'); ?></td>
                                        <td><?php echo date_format(date_create($data["tanggal"]), "d/m/Y"); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4" align="right"><b>Total Keseluruhan:</b></td>
                                    <td><b><?php echo 'Rp ' . number_format($totalHarga, 0, ',', '.'); ?></b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Links for actions -->
                        <!-- <a href="transaksi.php" class="btn btn-success mt-3">Tambah Transaksi</a> -->
                        <a href="cetak_transaksi.php?tanggal_mulai=<?php echo isset($tanggal_mulai) ? $tanggal_mulai : ''; ?>&tanggal_akhir=<?php echo isset($tanggal_akhir) ? $tanggal_akhir : ''; ?>" class="btn btn-success mt-3">Cetak</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- End content -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor JS -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

    <!-- Apexcharts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Widgets Init JS -->
    <script src="../assets/js/pages/dashboard.init.js"></script>

    <!-- App JS -->
    <script src="../assets/js/app.js"></script>

</body>

</html>
