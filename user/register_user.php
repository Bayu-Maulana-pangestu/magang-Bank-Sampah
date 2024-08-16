<?php
include "../koneksi.php";

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['proses'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password_hash, role) 
              VALUES ('$username', '$email', '$password_hash', 'masyarakat')";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Pendaftaran Berhasil'); window.location.href = 'login_user.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran Gagal: " . mysqli_error($koneksi) . "');</script>";
        echo "<p>SQL Query: $query</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Register</title>
    <link rel="stylesheet" href="styleregister_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="input">
        <form action="register_user.php" method="post">
            <h1>Halaman Register</h1>
            <div class="box-input">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" id="username" required>
            </div>
            <div class="box-input">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" id="email" required>
            </div>
            <div class="box-input">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Masukkan Password" id="password" required>
            </div>
            <button type="submit" name="proses" class="btn-input">Daftar</button>
            <div class="bottom">
                <a href="login_user.php">Sudah punya akun</a>
            </div>
        </form>
    </div>
</body>
</html>
