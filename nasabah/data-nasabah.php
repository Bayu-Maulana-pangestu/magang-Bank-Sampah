<?php
session_start(); // Start the session at the very beginning

include "../koneksi.php";

if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    header("Location:../error/forbidden.php");
    exit();
} 

$user_id = $_SESSION['user_id'];

// Handle form submission
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $alamat = htmlspecialchars($_POST['alamat']);

    // Check if nasabah data exists for this user
    $sql = "SELECT * FROM nasabah WHERE user_id='$user_id'";
    $hasil = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_assoc($hasil);

    if ($data) {
        // Update existing nasabah data
        $sql = "UPDATE nasabah SET nama='$nama', email='$email', jenis_kelamin='$jenis_kelamin', no_hp='$no_hp', alamat='$alamat' WHERE user_id='$user_id'";
    } else {
        // Insert new nasabah data
        $sql = "INSERT INTO nasabah (user_id, nama, email, jenis_kelamin, no_hp, alamat) VALUES ('$user_id', '$nama', '$email', '$jenis_kelamin', '$no_hp', '$alamat')";
    }

    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil) {
        echo "<div class='alert alert-success'> Data berhasil disimpan.</div>";
        header("Location: data-nasabah.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'> Data gagal disimpan.</div>";
    }
}

// Fetch nasabah data
$sql = "SELECT * FROM nasabah WHERE user_id='$user_id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Data Nasabah</title>
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
        include "../layout/left-sidebar-admin.php";
        ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Data Nasabah</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                                <li class="breadcrumb-item active">Data Nasabah</li>
                            </ol>
                        </div>
                    </div>

                    <div class="container">
                        <h1 class="mt-5">Profil Nasabah</h1>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" <?php echo ($data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php echo ($data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $data['no_hp'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required><?php echo $data['alamat'] ?? ''; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
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
