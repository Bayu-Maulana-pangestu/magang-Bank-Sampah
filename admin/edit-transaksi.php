<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "masyarakat") {
    header("Location:../error/forbidden.php");
    exit();
}

include "../koneksi.php";

// Fungsi untuk memperbarui saldo
function updateSaldo($id_user, $difference, $koneksi)
{
    $sql = "SELECT saldo FROM saldo WHERE id_user = '$id_user'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $new_saldo = $row['saldo'] + $difference;
        $update_saldo_sql = "UPDATE saldo SET saldo = '$new_saldo' WHERE id_user = '$id_user'";
        mysqli_query($koneksi, $update_saldo_sql);
    } else {
        // Jika tidak ada saldo, buat entri baru
        $insert_saldo_sql = "INSERT INTO saldo (id_user, saldo) VALUES ('$id_user', '$difference')";
        mysqli_query($koneksi, $insert_saldo_sql);
    }
}

// Mengambil data transaksi berdasarkan id_transaksi dari URL
if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $query = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $tanggal = $data['tanggal'];
        $id_user = $data['id_user'];
        $id_sampah = $data['id_sampah'];
        $jumlah_beli = $data['jumlah_beli'];
        $total_harga = $data['total_harga'];
    } else {
        echo "<script>alert('Data transaksi tidak ditemukan');window.location='data-transaksi.php';</script>";
        exit();
    }
}

// Proses update transaksi
if (isset($_POST['proses'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $tanggal = $_POST['tanggal'];
    $id_user = $_POST['id_user'];
    $jumlah_beli = $_POST['jumlah_beli'];
    $total_harga_baru = str_replace(['Rp ', '.', ','], ['', '', '.'], $_POST['total_harga']);
    $id_sampah = $_POST['jenis_sampah'];

    // Menghitung selisih total harga transaksi baru dan yang sebelumnya
    $difference = $total_harga_baru - $total_harga;

    $update_query = "UPDATE transaksi SET tanggal = '$tanggal', id_user = '$id_user', id_sampah = '$id_sampah', jumlah_beli = '$jumlah_beli', total_harga = '$total_harga_baru' WHERE id_transaksi = '$id_transaksi'";
    mysqli_query($koneksi, $update_query) or die(mysqli_error($koneksi));

    // Memperbarui saldo pengguna
    updateSaldo($id_user, $difference, $koneksi);

    echo "<script>alert('Data transaksi berhasil diupdate');window.location='data-transaksi.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Edit Transaksi</title>
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

        <!-- Include Top Bar and Left Sidebar -->
        <?php
        include "../layout/top-bar-admin.php";
        include "../layout/left-sidebar-admin.php";
        ?>

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-xxl" style="padding-top: 20px;">
                    <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    </div>

                    <div class="container">
                        <h2>Edit Transaksi</h2>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Transaksi</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required value="<?php echo $tanggal; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="id_user">Nama User</label>
                                <select id="id_user" name="id_user" class="form-control" required>
                                    <?php
                                    $query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE role != 'admin'") or die(mysqli_error($koneksi));
                                    while ($data_user = mysqli_fetch_array($query_user)) {
                                        $selected = ($data_user['id_user'] == $id_user) ? 'selected' : '';
                                        echo "<option value='$data_user[id_user]' $selected> $data_user[username] </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="jenis_sampah">Jenis Sampah</label>
                                <select id="jenis_sampah" name="jenis_sampah" class="form-control" onchange="updateHarga()" required>
                                    <?php
                                    $query_sampah = mysqli_query($koneksi, "SELECT * FROM sampah") or die(mysqli_error($koneksi));
                                    while ($data_sampah = mysqli_fetch_array($query_sampah)) {
                                        $selected = ($data_sampah['id_sampah'] == $id_sampah) ? 'selected' : '';
                                        echo "<option value='$data_sampah[id_sampah]' $selected> $data_sampah[jenis_sampah] </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="harga">Harga (per kg)</label>
                                <input type="text" id="harga" name="harga" class="form-control" readonly>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="jumlah_beli">Jumlah Jual (kg)</label>
                                <input type="number" id="jumlah_beli" name="jumlah_beli" class="form-control" min="0" step="any" onchange="calculateTotal()" required value="<?php echo $jumlah_beli; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input type="text" id="total_harga" name="total_harga" class="form-control" readonly value="<?php echo 'Rp ' . number_format($total_harga, 0, ',', '.'); ?>">
                            </div>
                            <br>
                            <button type="submit" value="simpan" name="proses" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
                <!-- End container-xxl -->

            </div>
            <!-- End content -->

        </div>
        <!-- End content-page -->

    </div>
    <!-- END app-layout -->

    <!-- Vendor js -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

    <script>
        function updateHarga() {
            var idSampah = document.getElementById("jenis_sampah").value;
            if (idSampah) {
                $.ajax({
                    type: "POST",
                    url: "harga.php",
                    data: {
                        id_sampah: idSampah
                    },
                    dataType: "json",
                    success: function(response) {
                        var harga = response.harga;
                        document.getElementById("harga").value = formatRupiah(harga.toString(), 'Rp ');
                        calculateTotal();
                    }
                });
            } else {
                document.getElementById("harga").value = '';
                document.getElementById("total_harga").value = '';
            }
        }

        function calculateTotal() {
            var harga = document.getElementById('harga').value.replace(/[^,\d]/g, '');
            var jumlah_beli = document.getElementById('jumlah_beli').value;
            var total_harga = harga * jumlah_beli;

            document.getElementById('total_harga').value = formatRupiah(total_harga.toString(), 'Rp ');
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        // Function to set today's date to the input field
        function setTodayDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById('tanggal').value = today;
        }

        // Call setTodayDate function when the page loads
        window.onload = function() {
            setTodayDate();
            updateHarga(); // Update harga saat halaman dimuat
        }
    </script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

</body>

</html>