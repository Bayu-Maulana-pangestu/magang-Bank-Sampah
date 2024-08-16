<?php
// memulai session
session_start();
// menghancurkan session
$logout = session_destroy();
if ($logout) {
    // menampilkan alert menggunakan JavaScript dan mengarahkan ke halaman login_user.php
    echo "<script>
            alert('Logout Berhasil');
            window.location.href = 'login_user.php';
          </script>";
}
?>