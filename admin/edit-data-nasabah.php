<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "masyarakat") {
    header("Location:../error/forbidden.php");
    exit();
}

include "../koneksi.php";

$id = $_GET['id'];
$sql = "SELECT * FROM nasabah WHERE id = $id";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    $nasabah = mysqli_fetch_assoc($result);
} else {
    echo "Data tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Edit Data Nasabah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-menu-color="dark" data-sidebar="default">
    <div id="app-layout">
        <?php include "../layout/top-bar-admin.php"; ?>
        <?php include "../layout/left-sidebar-admin.php"; ?>

        <div class="content-page">
            <div class="content">
                <div class="container-xxl" style="padding-top: 20px;">
                    <h1 class="">Edit Data Nasabah</h1>

                    <form action="update-data-nasabah.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $nasabah['id']; ?>">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nasabah['nama']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="Laki-laki" <?php if($nasabah['jenis_kelamin'] == "Laki-laki") echo "selected"; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php if($nasabah['jenis_kelamin'] == "Perempuan") echo "selected"; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $nasabah['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $nasabah['no_hp']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required><?php echo $nasabah['alamat']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.init.js"></script>
    <script src="../assets/js/app.js"></script>
</body>

</html>
