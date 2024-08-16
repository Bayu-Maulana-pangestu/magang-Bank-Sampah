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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .nota-header,
        .nota-footer {
            text-align: center;
            margin-top: 20px;
        }

        .nota-table {
            margin-top: 30px;
        }

        .nota-details {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nota-header">
            <h2>Nota Transaksi</h2>
            <p>Alamat Toko: Jl. Contoh No. 123, Kota Contoh</p>
            <p>Telepon: (012) 345-6789</p>
        </div>

        <?php
        include "../koneksi.php";

        $id_user = $_SESSION["id_user"];
        $whereClause = "transaksi.id_user = '$id_user'";

        if (isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai']) && isset($_GET['tanggal_akhir']) && !empty($_GET['tanggal_akhir'])) {
            $tanggal_mulai = $_GET['tanggal_mulai'];
            $tanggal_akhir = $_GET['tanggal_akhir'];
            $whereClause .= " AND transaksi.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
        }

        $sql = "SELECT transaksi.*, users.username, sampah.jenis_sampah 
                FROM transaksi 
                JOIN users ON transaksi.id_user = users.id_user 
                JOIN sampah ON transaksi.id_sampah = sampah.id_sampah 
                WHERE $whereClause
                ORDER BY transaksi.id_transaksi DESC";

        $hasil = mysqli_query($koneksi, $sql);
        ?>

        <div class="nota-details">
            <div class="nota-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Sampah</th>
                            <th>Jumlah Jual</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <?php
                    $no = 0;
                    $total_bayar = 0;
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;
                        $total_bayar += $data["total_harga"];
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data["jenis_sampah"]; ?></td>
                                <td><?php echo $data["jumlah_beli"]; ?></td>
                                <td><?php echo 'Rp ' . number_format($data["total_harga"], 0, ',', '.'); ?></td>
                                <td><?php echo date_format(date_create($data["tanggal"]), "d/m/Y"); ?></td>
                            </tr>
                        <?php
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right"><b>Total Keseluruhan:</b></td>
                            <td><b><?php echo 'Rp ' . number_format($total_bayar, 0, ',', '.'); ?></b></td>
                        </tr>
                        </tbody>
                </table>
            </div>

        </div>

        <div class="nota-footer">
            <h3>Total Bayar: <?php echo 'Rp ' . number_format($total_bayar, 0, ',', '.'); ?></h3>
            <p>Terima kasih telah berbelanja di toko kami!</p>
        </div>

        <script type="text/javascript">
            window.print();
        </script>
    </div>
</body>

</html>
