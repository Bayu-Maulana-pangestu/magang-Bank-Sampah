<?php
// Connect to the database
include "../koneksi.php";

session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    header("Location:../error/forbidden.php");
    exit();
} 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $id_sampah = htmlspecialchars($_POST['nama_sampah']);
    $jumlah_beli = htmlspecialchars($_POST['jumlah_beli']);
    $total_harga = htmlspecialchars($_POST['total_harga']);

    // Validate the form data
    if (empty($tanggal) || empty($id_sampah) || empty($jumlah_beli) || empty($total_harga)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    // Get the user_id from the session
    $id_user = $_SESSION['id_user'];

    // Insert the data into the database
    $sql = "INSERT INTO transaksi (id_user, id_sampah, tanggal, jumlah_beli, total_harga) 
            VALUES ('$id_user', '$id_sampah', '$tanggal', '$jumlah_beli', '$total_harga')";
    $result = mysqli_query($koneksi, $sql);

    // Check if the data was inserted successfully
    if ($result) {
        echo "<div class='alert alert-success'>Data successfully saved.</div>";
        header("Location: nasabah.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Data failed to save: " . mysqli_error($koneksi) . "</div>";
    }
}
?>
