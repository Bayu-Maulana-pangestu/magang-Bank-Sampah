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

$id = $_POST['id'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

$sql = "UPDATE nasabah SET nama='$nama', jenis_kelamin='$jenis_kelamin', email='$email', no_hp='$no_hp', alamat='$alamat' WHERE id='$id'";

if (mysqli_query($koneksi, $sql)) {
    header("Location: data-nasabah.php");
} else {
    echo "Error updating record: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
