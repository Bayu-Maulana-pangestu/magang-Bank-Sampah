<?php
session_start();
if (!isset($_SESSION["id_user"])) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: monospace; }
        .nota { width: 60%; margin: auto; }
        .nota-header, .nota-footer { text-align: center; }
        .nota-details { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .nota-footer { margin-top: 20px; }
        hr { border-top: 1px solid black; }
        .tanda-tangan { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
<div class="nota">
    <div class="nota-header">
        <h2>BANK SAMPAH BERSIH</h2>
        <hr>
    </div>

    <div class="nota-details">
        <?php
        include "../koneksi.php";

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

        $sql = "SELECT transaksi.*, users.username, sampah.jenis_sampah 
                FROM transaksi 
                JOIN users ON transaksi.id_user = users.id_user 
                JOIN sampah ON transaksi.id_sampah = sampah.id_sampah 
                WHERE $whereClause
                ORDER BY transaksi.id_transaksi DESC";
        $hasil = mysqli_query($koneksi, $sql);
        $no = 0;
        $total_bayar = 0;
        $nama_nasabah = "";
        $tanggal_penarikan = date("d/m/Y"); // Tanggal penarikan saat ini

        // Mengambil data pertama untuk nama nasabah
        if ($data = mysqli_fetch_array($hasil)) {
            $nama_nasabah = $data["username"];
        }

        // Reset pointer hasil query
        mysqli_data_seek($hasil, 0);
        ?>

        <p>Nama Nasabah   : <?php echo $nama_nasabah; ?></p>
        <p>Tanggal        : <?php echo $tanggal_penarikan; ?></p>
        <hr>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th>Berat (kg)</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                    $total_bayar += $data["total_harga"];
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data["jenis_sampah"]; ?></td>
                    <td><?php echo $data["jumlah_beli"]; ?></td>
                    <td><?php echo 'Rp ' . number_format($data["total_harga"], 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <hr>
        <p style="text-align: right;">Total Keseluruhan: Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></p>
    </div>

    <div class="nota-footer">
        <hr>
        <p>Petugas,</p>
    </div>

    <div class="tanda-tangan">
        <p>---------------------------------------</p>
        <p>Tanda Tangan</p>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</div>
</body>
</html>
