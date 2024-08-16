<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "masyarakat") {
    header("Location:../error/forbidden.php"); // Redirect ke halaman error atau halaman lain yang sesuai
    exit();
}

include "../koneksi.php";

if (isset($_GET['delete_id'])) {
    $id_transaksi = htmlspecialchars($_GET['delete_id']);
    $sql = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil) {
        echo "<script>alert('Data berhasil dihapus');window.location='data-transaksi.php';</script>";
    } else {
        echo "<div class='alert alert-danger'> Data gagal dihapus.</div>";
    }
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

<body data-menu-color="dark" data-sidebar="default">

    <div id="app-layout">

        <?php
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-admin.php";
        ?>

        <div class="content-page">
            <div class="content">
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    </div>

                    <div class="container">
                        <h1 class="">Data Transaksi</h1>

                        <form method="GET" action="data-transaksi.php" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                                </div>
                                <div class="col-md-4">
                                    <label for="user">User:</label>
                                    <input type="text" class="form-control" id="user" name="user">
                                </div>
                                <div class="col-md-4 mt-1">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Data Transaksi -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Jenis Sampah</th>
                                    <th>Harga (kg)</th>
                                    <th>Jumlah Beli</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query berdasarkan filter
                                $whereClause = "1";
                                if (isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai']) && isset($_GET['tanggal_akhir']) && !empty($_GET['tanggal_akhir'])) {
                                    $tanggal_mulai = $_GET['tanggal_mulai'];
                                    $tanggal_akhir = $_GET['tanggal_akhir'];
                                    $whereClause .= " AND transaksi.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
                                }
                                if (isset($_GET['user']) && !empty($_GET['user'])) {
                                    $user = $_GET['user'];
                                    $whereClause .= " AND users.username LIKE '%$user%'";
                                }

                                $sql = "SELECT transaksi.*, users.username, sampah.jenis_sampah, sampah.harga 
                                        FROM transaksi 
                                        JOIN users ON transaksi.id_user = users.id_user 
                                        JOIN sampah ON transaksi.id_sampah = sampah.id_sampah 
                                        WHERE $whereClause
                                        ORDER BY transaksi.id_transaksi DESC";
                                $hasil = mysqli_query($koneksi, $sql);
                                $no = 0;
                                $totalHarga = 0; // Variabel untuk menampung total harga
                                $date = date_create("2013-03-15");

                                while ($data = mysqli_fetch_array($hasil)) {
                                    $no++;
                                    // Menambahkan total harga dari setiap transaksi
                                    $totalHarga += $data["total_harga"];
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $data["username"]; ?></td>
                                        <td><?php echo $data["jenis_sampah"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($data["harga"], 0, ',', '.'); ?></td>
                                        <td><?php echo $data["jumlah_beli"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($data["total_harga"], 0, ',', '.'); ?></td>
                                        <td><?php echo date_format(date_create($data["tanggal"]), "d/m/Y"); ?></td>
                                        <td>
                                            <a href="edit-transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>" class="btn btn-warning" role="button">Update</a>
                                            <a href="data-transaksi.php?delete_id=<?php echo $data['id_transaksi']; ?>" class="btn btn-danger" role="button" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <!-- Menampilkan total keseluruhan harga -->
                                <tr>
                                    <td colspan="5" align="right"><b>Total Keseluruhan:</b></td>
                                    <td><b><?php echo 'Rp ' . number_format($totalHarga, 0, ',', '.'); ?></b></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-top: -15px;">
                            <a href="transaksi-nasabah.php" class="btn btn-success">Tambah Data</a>
                            <a href="cetak_transaksi.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">Cetak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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