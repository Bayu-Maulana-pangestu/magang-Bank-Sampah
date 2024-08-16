<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    header("Location:../error/forbidden.php");
    exit();
} 

$id_user = $_SESSION['id_user'];

// Pengecekan apakah data nasabah sudah ada atau belum
$sql_nasabah = "SELECT * FROM nasabah WHERE id_user = '$id_user'";
$result_nasabah = mysqli_query($koneksi, $sql_nasabah);

if ($result_nasabah) {
    $row_nasabah = mysqli_fetch_assoc($result_nasabah);
    // Jika data nasabah belum ada, inisialisasi array kosong untuk menghindari error
    if (!$row_nasabah) {
        $row_nasabah = [
            'nama' => '',
            'jenis_kelamin' => '',
            'email' => '',
            'no_hp' => '',
            'alamat' => ''
        ];
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
    exit();
}

// Ambil data email dari tabel users
$sql_users = "SELECT email FROM users WHERE id_user = '$id_user'";
$result_users = mysqli_query($koneksi, $sql_users);

if ($result_users) {
    $row_users = mysqli_fetch_assoc($result_users);
    $email = $row_users['email'];
} else {
    echo "Error: " . mysqli_error($koneksi);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Profile Nasabah</title>
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
                        <h2 class="text-center">Profile Nasabah</h2>
                        <form method="POST" action="update-profile.php">
                            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row_nasabah['nama']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" <?php if ($row_nasabah['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php if ($row_nasabah['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required readonly>
                                <!-- Tambahkan readonly untuk email jika sudah terisi dari registrasi -->
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP:</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $row_nasabah['no_hp']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <textarea class="form-control" id="alamat" name="alamat" required><?php echo $row_nasabah['alamat']; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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