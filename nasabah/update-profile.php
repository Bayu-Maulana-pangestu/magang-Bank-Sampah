<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["id_user"])) {
    header("Location:../user/login_user.php");
    exit(); // Pastikan keluar setelah redirect header
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    header("Location:../error/forbidden.php");
    exit();
} 

$id_user = $_POST['id_user'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
$no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

// Ambil email dari tabel users
$sql_email = "SELECT email FROM users WHERE id_user = '$id_user'";
$result_email = mysqli_query($koneksi, $sql_email);

if ($result_email) {
    $row_email = mysqli_fetch_assoc($result_email);
    $email = $row_email['email'];

    // Query untuk memeriksa apakah data nasabah sudah ada
    $sql_check = "SELECT * FROM nasabah WHERE id_user = '$id_user'";
    $result_check = mysqli_query($koneksi, $sql_check);

    if ($result_check) {
        // Jika data nasabah sudah ada, lakukan UPDATE
        if (mysqli_num_rows($result_check) > 0) {
            $sql_update = "UPDATE nasabah SET 
                            nama = '$nama', 
                            jenis_kelamin = '$jenis_kelamin', 
                            email = '$email', 
                            no_hp = '$no_hp', 
                            alamat = '$alamat' 
                            WHERE id_user = '$id_user'";

            $result_update = mysqli_query($koneksi, $sql_update);

            if ($result_update) {
                echo "<script>
                        alert('Data berhasil diperbarui');
                        window.location.href = 'profile-nasabah.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                        window.location.href = 'profile-nasabah.php';
                      </script>";
                exit();
            }
        } else {
            // Jika data nasabah belum ada, lakukan INSERT
            $sql_insert = "INSERT INTO nasabah (id_user, nama, jenis_kelamin, email, no_hp, alamat) 
                           VALUES ('$id_user', '$nama', '$jenis_kelamin', '$email', '$no_hp', '$alamat')";

            $result_insert = mysqli_query($koneksi, $sql_insert);

            if ($result_insert) {
                echo "<script>
                        alert('Data berhasil disimpan');
                        window.location.href = 'profile-nasabah.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                        window.location.href = 'profile-nasabah.php';
                      </script>";
                exit();
            }
        }
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($koneksi) . "');
                window.location.href = 'profile-nasabah.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            window.location.href = 'profile-nasabah.php';
          </script>";
    exit();
}

mysqli_close($koneksi);
