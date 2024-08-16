<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "masyarakat") {
    header("Location:../error/forbidden.php");
    exit();
}

include "../koneksi.php";

// Function to sanitize inputs
function sanitize($koneksi, $input)
{
    return mysqli_real_escape_string($koneksi, $input);
}

// Get total balance of the user
$id_user = $_SESSION['id_user'];

$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penarikan = sanitize($koneksi, $_POST['id_penarikan']);
    $action = sanitize($koneksi, $_POST['action']);

    // Get current status and withdrawal details
    $penarikan_sql = "SELECT id_user, jumlah, status FROM penarikan WHERE id_penarikan = '$id_penarikan'";
    $penarikan_result = mysqli_query($koneksi, $penarikan_sql);
    $penarikan_row = mysqli_fetch_assoc($penarikan_result);

    $id_user = $penarikan_row['id_user'];
    $jumlah = $penarikan_row['jumlah'];
    $current_status = $penarikan_row['status'];

    if ($action == 'approve') {
        $sql = "UPDATE penarikan SET status = 'Disetujui' WHERE id_penarikan = '$id_penarikan'";
        if ($current_status != 'Disetujui') {
            // Update saldo if not already approved
            $update_saldo_sql = "UPDATE saldo SET saldo = saldo - '$jumlah' WHERE id_user = '$id_user'";
            mysqli_query($koneksi, $update_saldo_sql);
        }
    } else {
        $sql = "UPDATE penarikan SET status = 'Ditolak' WHERE id_penarikan = '$id_penarikan'";
        if ($current_status == 'Disetujui') {
            // Revert saldo if previously approved
            $update_saldo_sql = "UPDATE saldo SET saldo = saldo + '$jumlah' WHERE id_user = '$id_user'";
            mysqli_query($koneksi, $update_saldo_sql);
        }
    }

    if (mysqli_query($koneksi, $sql)) {
        $message = "Penarikan berhasil diupdate.";
        $success = true;
        // Redirect with a success flag in the query string
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        $success = false;
    }
}

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $message = "Penarikan berhasil diupdate.";
    $success = true;
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var message = "<?php echo $message; ?>";
            var success = "<?php echo $success; ?>";
            if (message) {
                alert(message);
                if (success) {
                    setTimeout(function() {
                        window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>"; // Reload without query string
                    }, 1000); // 1 second delay before refreshing
                }
            }
        });
    </script>
</head>

<body data-menu-color="dark" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">

        <?php
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-admin.php";
        ?>

        <!-- Start Page Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="container">
                        <h1>Saldo</h1>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="background-color: blanchedalmond;">No</th>
                                    <th style="background-color: blanchedalmond;">Nama User</th>
                                    <th style="background-color: blanchedalmond;">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldo_sql = "SELECT saldo.*, users.username
                                              FROM saldo
                                              JOIN users ON saldo.id_user = users.id_user";
                                $saldo_result = mysqli_query($koneksi, $saldo_sql);
                                $no = 0;

                                while ($saldo_data = mysqli_fetch_assoc($saldo_result)) {
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $saldo_data["username"]; ?></td>
                                        <td><?php echo 'Rp ' . number_format($saldo_data["saldo"], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <h2 class="mt-4">Riwayat Penarikan</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="background-color: blanchedalmond;">No</th>
                                    <th style="background-color: blanchedalmond;">Tanggal</th>
                                    <th style="background-color: blanchedalmond;">Nama User</th>
                                    <th style="background-color: blanchedalmond;">Jumlah</th>
                                    <th style="background-color: blanchedalmond;">Status</th>
                                    <th style="background-color: blanchedalmond;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $requests_sql = "SELECT penarikan.id_penarikan, users.username, penarikan.jumlah, penarikan.tanggal, penarikan.status 
                                                 FROM penarikan 
                                                 JOIN users ON penarikan.id_user = users.id_user 
                                                 ORDER BY penarikan.tanggal DESC";
                                $requests_result = mysqli_query($koneksi, $requests_sql);
                                $no = 1;
                                $jumlah_tarik = 0;

                                while ($row = mysqli_fetch_assoc($requests_result)) {
                                    if ($row['status'] == 'Disetujui') {
                                        $jumlah_tarik += $row["jumlah"];
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo 'Rp ' . number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'Disetujui') { ?>
                                                <div class="text-success">Disetujui</div>
                                            <?php } elseif ($row['status'] == 'Belum disetujui') { ?>
                                                <div class="text-primary">Belum Disetujui</div>
                                            <?php } else { ?>
                                                <div class="text-danger">Ditolak</div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <form method="POST" action="" class="me-2">
                                                    <input type="hidden" name="id_penarikan" value="<?php echo $row['id_penarikan']; ?>">
                                                    <button type="submit" name="action" value="approve" class="btn btn-success">Setujui</button>
                                                    <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                                                </form>
                                                <form method="GET" action="cetak-saldo.php" target="_blank">
                                                    <input type="hidden" name="id_penarikan" value="<?php echo $row['id_penarikan']; ?>">
                                                    <button type="submit" class="btn btn-secondary">Cetak</button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="3" align="right"><b>Total Keseluruhan:</b></td>
                                    <td><b><?php echo 'Rp ' . number_format($jumlah_tarik, 0, ',', '.'); ?></b></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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