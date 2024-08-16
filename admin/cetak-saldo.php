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

// Sanitize function
function sanitize($koneksi, $input) {
    return mysqli_real_escape_string($koneksi, $input);
}

if (isset($_GET['id_penarikan'])) {
    $id_penarikan = sanitize($koneksi, $_GET['id_penarikan']);
    
    // Get withdrawal details
    $sql = "SELECT penarikan.id_penarikan, users.username, penarikan.jumlah, penarikan.tanggal, penarikan.status, penarikan.id_user 
            FROM penarikan 
            JOIN users ON penarikan.id_user = users.id_user 
            WHERE penarikan.id_penarikan = '$id_penarikan'";
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Data penarikan tidak ditemukan!";
        exit();
    }

    // Get user's current balance
    $id_user = $row['id_user'];
    $saldo_sql = "SELECT saldo FROM saldo WHERE id_user = '$id_user'";
    $saldo_result = mysqli_query($koneksi, $saldo_sql);
    $saldo_row = mysqli_fetch_assoc($saldo_result);

    if (!$saldo_row) {
        echo "Saldo tidak ditemukan!";
        exit();
    }

    $saldo = $saldo_row['saldo'];
} else {
    echo "ID penarikan tidak diberikan!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Penarikan</title>
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
        <p>Nama Nasabah   : <?php echo $row['username']; ?></p>
        <p>Tanggal        : <?php echo date("d/m/Y"); ?></p> <!-- Tanggal sekarang -->
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Tanggal Penarikan</th>
                    <td><?php echo $row['tanggal']; ?></td>
                </tr>
                <tr>
                    <th>Jumlah Penarikan</th>
                    <td><?php echo 'Rp ' . number_format($row['jumlah'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Sisa Saldo</th>
                    <td><?php echo 'Rp ' . number_format($saldo, 0, ',', '.'); ?></td>
                </tr>
            </thead>
        </table>
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
