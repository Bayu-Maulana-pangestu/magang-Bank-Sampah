<?php

session_start();
if (!isset($_SESSION["username"])){
    header("Location:../user/login_user.php");
}

include "../koneksi.php";

if (isset($_POST['id_sampah'])) {
    $id_sampah = htmlspecialchars($_POST['id_sampah']);

    $sql = "SELECT harga FROM sampah WHERE id_sampah='$id_sampah'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['harga' => $data['harga']]);
    } else {
        echo json_encode(['harga' => 0]);
    }
}
?>
