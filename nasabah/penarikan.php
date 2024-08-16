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

include "../koneksi.php";

// Get total balance of the user
$id_user = $_SESSION['id_user'];
$sql_saldo = "SELECT saldo FROM saldo WHERE id_user = '$id_user'";
$result_saldo = mysqli_query($koneksi, $sql_saldo);

// Handle case where no saldo entry is found
if ($result_saldo && mysqli_num_rows($result_saldo) > 0) {
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $total_saldo = $row_saldo['saldo'];
} else {
    $total_saldo = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jumlah_penarikan = $_POST['jumlah_penarikan'];

    if ($jumlah_penarikan > 0 && $jumlah_penarikan <= $total_saldo) {
        // Insert withdrawal request (not directly to database)
        $sql_insert = "INSERT INTO penarikan (id_user, jumlah, status) VALUES ('$id_user', '$jumlah_penarikan', 'Belum disetujui')";
        if (mysqli_query($koneksi, $sql_insert)) {
            // Redirect to the same page to prevent resubmission
            header("Location: penarikan.php?success=1");
            exit();
        } else {
            // Error inserting withdrawal request
            echo "<script>alert('Gagal mengajukan permintaan penarikan!');</script>";
        }
    } else {
        // Invalid withdrawal amount
        echo "<script>alert('Jumlah penarikan tidak valid atau melebihi saldo yang tersedia!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Penarikan Saldo</title>
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
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-nasabah.php";
        ?>

        <!-- Start Page Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="container">
                        <h1 class="">Penarikan Saldo</h1>

                        <?php
                        if (isset($_GET['success'])) {
                            echo "<div class='alert alert-success'>Permintaan penarikan berhasil diajukan! Menunggu persetujuan admin.</div>";
                        }
                        ?>

                        <form method="POST" action="penarikan.php" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="jumlah_penarikan">Jumlah Penarikan:</label>
                                    <input type="number" class="form-control" id="jumlah_penarikan" name="jumlah_penarikan" max="<?php echo $total_saldo; ?>" required>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button type="submit" class="btn btn-primary">Ajukan Penarikan</button>
                                </div>
                            </div>
                        </form>

                        <div class="alert alert-info">
                            Total Saldo: <?php echo 'Rp ' . number_format($total_saldo, 0, ',', '.'); ?>
                        </div>
                        <h2>Riwayat Penarikan</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $history_sql = "SELECT * FROM penarikan WHERE id_user = '$id_user' ORDER BY tanggal DESC";
                                $history_result = mysqli_query($koneksi, $history_sql);
                                while ($history_row = mysqli_fetch_assoc($history_result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $history_row['tanggal']; ?></td>
                                        <td><?php echo number_format($history_row['jumlah'], 0, ',', '.'); ?></td>
                                        <td><?php
                                            if ($history_row['status'] == 'Disetujui') {
                                                echo '<div class="text-success"><i class="fas fa-check"></i> Disetujui</div>';
                                            } elseif ($history_row['status'] == 'Belum disetujui') {
                                                echo '<div class="text-warning"><i class="fas fa-hourglass-start"></i> Menunggu Persetujuan</div>';
                                            } elseif ($history_row['status'] == 'Ditolak') {
                                                echo '<div class="text-danger"><i class="fas fa-times"></i> Ditolak</div>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>

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