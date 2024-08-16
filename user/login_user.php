<?php
session_start();
include "../koneksi.php";

$username = "";
$password = "";
$err = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $err .= "<li>Silahkan masukkan username dan password</li>";
    }

    if (empty($err)) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user["password_hash"])) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user["role"];

                echo "<script>
                        alert('Login Berhasil.');
                        window.location.href = '";
                switch ($user["role"]) {
                    case "masyarakat":
                        echo "../nasabah/nasabah.php";
                        break;
                    case "admin":
                        echo "../admin/admin.php";
                        break;
                    case "petugas":
                        echo "../petugas/petugas.php";
                        break;
                    default:
                        echo "dash_user.php";
                        break;
                }
                echo "';
                      </script>";
                exit();
            } else {
                $err .= "<li>Password salah</li>";
            }
        } else {
            $err .= "<li>Akun tidak ditemukan</li>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <form action="" method="post">
                <h1>Bank Sampah</h1>
                <hr>
                <p>Silahkan login terlebih dahulu</p>
                <?php
                if ($err) {
                    echo "<ul class='error'>$err</ul>";
                    echo "<script>
                            alert('Login gagal: $err');
                          </script>";
                }
                ?>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="input" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="password" placeholder="Password" required>

                <button type="submit" name="login">Masuk</button>
                <p><a href="lupa_password.php">Lupa Password</a></p>
                <p><a href="../index.php">Kembali</a></p>
            </form>
        </div>
        <div class="right">
            <img src="../img/log.png" alt="">
        </div>
    </div>
</body>
</html>
