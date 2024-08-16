<?php
$host           = "localhost";
$user           = "root";
$pass           = "";
$db             = "sampah";

$koneksi        = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("Koneksi Gagal");
}