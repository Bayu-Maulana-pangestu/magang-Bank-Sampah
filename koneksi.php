<?php
$koneksi = mysqli_connect("localhost", "root", "", "sampah"); // Ganti "nama_database" dengan nama database Anda

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
?>